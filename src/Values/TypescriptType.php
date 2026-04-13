<?php

namespace Vagebond\Runtype\Values;

use Illuminate\Support\Collection;
use ReflectionClass;

class TypescriptType
{
    /** @var TypescriptProperty[] */
    private array $properties = [];

    private ?string $rawType = null;

    public function __construct(
        private string $class
    ) {}

    public function addProperty(TypescriptProperty $property): self
    {
        $this->properties[] = $property;

        return $this;
    }

    public function addProperties(iterable $properties): self
    {
        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        return $this;
    }

    public function listProperties(): Collection
    {
        return collect($this->properties);
    }

    public function getName(): string
    {
        return self::determineName($this->class);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setRawType(string $type): self
    {
        $this->rawType = $type;

        return $this;
    }

    public function getRawType(): ?string
    {
        return $this->rawType;
    }

    public function merge(TypescriptType $type, Collection $originalProperties): self
    {
        $newProperties = $type->listProperties()
            ->filter(fn ($prop) => ! $this->listProperties()->contains($prop));

        $this->addProperties($newProperties);

        $optionalProperties = $this->listProperties()
            ->filter(fn ($prop) => ! $originalProperties->contains($prop));

        $optionalProperties->each(fn ($prop) => $prop->setOptional(true));

        $missingProperties = $originalProperties->filter(fn ($prop) => !$type->listProperties()->contains($prop));
        $missingProperties->each(fn ($prop) => $prop->setOptional(true));

        return $this;
    }

    public static function determineNamespace(string $className): string
    {
        $namespace = explode('\\', $className);
        array_pop($namespace);

        if (empty($namespace)) {
            return '';
        }

        return implode('.', $namespace);
    }

    public static function determineName(string $className): string
    {
        $class = new ReflectionClass($className);

        return $class->getShortName().'Type';
    }
}
