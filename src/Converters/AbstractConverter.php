<?php

namespace Vagebond\Runtype\Converters;

use Illuminate\Support\Collection;
use ReflectionClass;
use Vagebond\Runtype\Contracts\Modifiable;
use Vagebond\Runtype\Contracts\ResolvesRequest;
use Vagebond\Runtype\Exceptions\ConverterException;
use Vagebond\Runtype\RuntypeConfig;
use Vagebond\Runtype\Types\Types;
use Vagebond\Runtype\Values\TypescriptProperty;
use Vagebond\Runtype\Values\TypescriptType;

abstract class AbstractConverter
{
    protected array $modifiers = [];

    final public function __construct(
        protected RuntypeConfig $config
    ) {
    }

    abstract protected function handle($instance): TypescriptType;

    public function convert($instance): TypescriptType
    {
        $type = $this->handle($instance);

        $type = $this->runModifiers($type, $instance);

        return $type;
    }

    protected function runModifiers(TypescriptType $type, $instance): TypescriptType
    {
        foreach ($this->getModifiers($instance) as $modifier) {
            $classReflection = new ReflectionClass($modifier);

            if (! $classReflection->implementsInterface(Modifiable::class)) {
                ConverterException::modifierDoesNotImplementModifiable($modifier);
            }

            $instance = app($modifier)->modify($instance);
            $modifiedType = app(static::class)->handle($instance);

            $type = $type->merge($modifiedType);
        }

        return $type;
    }

    protected function convertPropertiesToTypes(Collection $properties, bool $optional = false): Collection
    {
        // TODO: Improve this and make it more descriptive
        $typer = new Types($this->config);

        return $properties->map(
            fn ($value, $key) => new TypescriptProperty(
                name: $key,
                type: $typer->determineType($value),
                optional: $optional,
            )
        );
    }

    protected function getRequest()
    {
        return app()->make(ResolvesRequest::class)->resolve();
    }

    private function getModifiers($instance)
    {
        $modifiers = array_merge($this->modifiers, [$this->config->getModifier($instance::class)]);
        return array_filter($modifiers);
    }
}
