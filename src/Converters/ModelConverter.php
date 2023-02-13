<?php

namespace Vagebond\Runtype\Converters;

use Vagebond\Runtype\Values\TypescriptType;

class ModelConverter extends AbstractConverter
{
    protected function handle($instance): TypescriptType
    {
        return (new TypescriptType(get_class($instance)))
            ->addProperties($this->convertPropertiesToTypes(collect($instance->toArray())));
    }
}
