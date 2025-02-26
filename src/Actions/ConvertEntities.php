<?php

namespace Vagebond\Runtype\Actions;

use Illuminate\Support\Collection;
use Vagebond\Runtype\Converters\DefaultConverter;
use Vagebond\Runtype\RuntypeConfig;

class ConvertEntities
{
    public function __construct(
        private RuntypeConfig $config,
    ) {}

    public function handle(Collection $entities)
    {
        return $entities->map(fn ($entity) => $this->convertEntity($entity));
    }

    private function convertEntity($entity)
    {
        $converter = collect($this->config->getConverters())
            ->filter(function (string $converter, string $entityClass) use ($entity) {
                return is_subclass_of($entity, $entityClass);
            })
            ->first(default: $this->getDefaultConverter());

        return (new $converter($this->config))->convert($entity);
    }

    private function getDefaultConverter()
    {
        return DefaultConverter::class;
    }
}
