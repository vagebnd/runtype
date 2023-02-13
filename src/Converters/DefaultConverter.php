<?php

namespace Vagebond\Runtype\Converters;

use ReflectionClass;
use Vagebond\Runtype\Values\TypescriptType;

class DefaultConverter extends AbstractConverter
{
    protected function handle($instance): TypescriptType
    {
        if ($instance instanceof ReflectionClass) {
            return (new TypescriptType($instance->getName()));
        }

        return (new TypescriptType(get_class($instance)));
    }
}
