<?php

namespace Vagebond\Runtype\Converters;

use ReflectionClass;
use Vagebond\Runtype\Values\TypescriptType;

class ResourceConverter extends AbstractConverter
{
    protected TypescriptType $type;

    protected array $modifiers = [
        Modifiers\UnsetRelationsModifier::class,
    ];

    public function handle($instance): TypescriptType
    {
        $type = (new TypescriptType(get_class($instance)));

        if ($instance->resource instanceof ReflectionClass) {
            return $type;
        }

        $resourceData = collect($instance->resolve($this->getRequest()));

        $type = $type->addProperties($this->convertPropertiesToTypes($resourceData));

        return $type;
    }
}
