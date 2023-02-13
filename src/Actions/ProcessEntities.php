<?php

namespace Vagebond\Runtype\Actions;

use Illuminate\Support\Collection;
use ReflectionClass;
use Vagebond\Runtype\Processors\DefaultProcessor;
use Vagebond\Runtype\RuntypeConfig;

class ProcessEntities
{
    public function __construct(
        private RuntypeConfig $config,
    ) {
    }

    public function handle(array $classes = []): Collection
    {
        return collect($classes)
            ->mapWithKeys(fn (string $class) => [$class => $this->getProcessor($class)])
            ->map(fn (string $processor, string $entity) => (new $processor($this->config))->process($entity));
    }

    private function getProcessor(string $class)
    {
        $classReflection = new ReflectionClass($class);

        return collect($this->config->getProcessors())
            ->filter(function (string $processor, string $entity) use ($classReflection) {
                return $classReflection->isSubclassOf($entity);
            })
            ->first(default: $this->getDefaultProcessor());
    }

    private function getDefaultProcessor()
    {
        return DefaultProcessor::class;
    }
}
