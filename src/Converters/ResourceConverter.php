<?php

namespace Vagebond\Runtype\Converters;

use Illuminate\Support\Arr;
use ReflectionClass;
use Vagebond\Runtype\Types\Types;
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

        $resourceData = $instance->resolve($this->getRequest());

        if (! Arr::isAssoc($resourceData)) {
            return $type->setRawType((new Types($this->config))->determineType($resourceData));
        }

        $type = $type->addProperties($this->convertPropertiesToTypes(collect($resourceData)));

        return $type;
    }
}
