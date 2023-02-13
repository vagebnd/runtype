<?php

namespace Vagebond\Runtype\Processors;

use ReflectionClass;
use Vagebond\Runtype\Contracts\Processable;

class DefaultProcessor implements Processable
{
    public function process(string $classString)
    {
        // TODO: Add support for value objects
        return new ReflectionClass($classString);
    }
}
