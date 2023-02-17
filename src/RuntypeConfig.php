<?php

namespace Vagebond\Runtype;

use ReflectionClass;
use Vagebond\Runtype\Contracts\Modifiable;
use Vagebond\Runtype\Exceptions\ConfigurationException;

class RuntypeConfig
{
    /** @var string[] */
    private array $autoDiscoverPaths = [];

    private array $processors = [];

    private array $converters = [];

    private string $outputFile = 'runtype.d.ts';

    private array $typeReplacements = [];

    private array $modifiers = [];

    private array $hooks = [];

    public static function make(): self
    {
        return new self();
    }

    public function autoDiscoverPaths(array $paths): self
    {
        $this->autoDiscoverPaths = array_merge($this->autoDiscoverPaths, $paths);

        return $this;
    }

    public function processors(array $processors): self
    {
        $this->processors = array_merge($this->processors, $processors);

        return $this;
    }

    public function converters(array $converters): self
    {
        $this->converters = array_merge($this->converters, $converters);

        return $this;
    }

    public function outputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    public function typeReplacements(array $typeReplacements): self
    {
        $this->typeReplacements = $typeReplacements;

        return $this;
    }

    public function modifiers(array $modifiers): self
    {
        $this->modifiers = $modifiers;

        return $this;
    }

    public function hooks(array $hooks): self
    {
        $this->hooks = $hooks;

        return $this;
    }

    public function getAutoDiscoverPaths(): array
    {
        return $this->autoDiscoverPaths;
    }

    public function getProcessors(): array
    {
        // TODO: Check if they exists and are of the correct type.
        return $this->processors;
    }

    public function getConverters(): array
    {
        // TODO: Check if they exists and are of the correct type.
        return $this->converters;
    }

    public function getOutputFile(): string
    {
        return $this->outputFile;
    }

    public function getTypeReplacements(): array
    {
        foreach ($this->typeReplacements as $class => $replacement) {
            if (! class_exists($class) && ! interface_exists($class)) {
                throw ConfigurationException::classDoesNotExist($class);
            }

            if (! is_string($replacement)) {
                throw ConfigurationException::replacementTypeShouldBeString($class, $replacement);
            }
        }

        return $this->typeReplacements;
    }

    public function getModifier(string $class)
    {
        $modifiersCollection = collect($this->modifiers);

        /** @var string */
        $modifier = $modifiersCollection->get($class);

        if (empty($modifier)) {
            return;
        }

        if (! class_exists($modifier)) {
            throw ConfigurationException::classDoesNotExist($modifier);
        }

        if (! (new ReflectionClass($modifier))->implementsInterface(Modifiable::class)) {
            throw ConfigurationException::classDoesNotImplementModifiable($modifier);
        }

        return $modifier;
    }

    public function getHooks(): array
    {
        return collect($this->hooks)
            ->map(fn ($hook) => app($hook))
            ->toArray();
    }
}
