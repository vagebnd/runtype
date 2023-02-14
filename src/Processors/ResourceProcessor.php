<?php

namespace Vagebond\Runtype\Processors;

use Illuminate\Http\Resources\Json\ResourceCollection;
use ReflectionClass;
use Vagebond\Runtype\Actions\ProcessEntities;
use Vagebond\Runtype\Actions\ResolveMixinFromClass;
use Vagebond\Runtype\Contracts\Processable;
use Vagebond\Runtype\RuntypeConfig;

class ResourceProcessor implements Processable
{
    public function __construct(
        protected RuntypeConfig $config
    ) {
    }

    public function process(string $class)
    {
        $resolvedClass = (new ResolveMixinFromClass)->handle($class);

        $valueInstance = (new ProcessEntities($this->config))->handle([$resolvedClass]);

        if (! $this->isResourceCollection($class)) {
            return $class::make($valueInstance->first());
        }

        return $class::make($valueInstance->values());
    }

    private function isResourceCollection(string $class): bool
    {
        return (new ReflectionClass($class))->isSubclassOf(ResourceCollection::class);
    }
}
