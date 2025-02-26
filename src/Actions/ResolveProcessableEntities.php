<?php

namespace Vagebond\Runtype\Actions;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Vagebond\Runtype\Exceptions\ConfigurationException;
use Vagebond\Runtype\RuntypeConfig;

class ResolveProcessableEntities
{
    public function __construct(
        private Finder $finder,
        private RuntypeConfig $config,
    ) {}

    public function handle(array $types = [])
    {
        $this->config->getAutoDiscoverPaths();
        $entities = [];

        if (empty($paths = $this->config->getAutoDiscoverPaths())) {
            throw ConfigurationException::NoAutoDiscoverPathsDefined();
        }

        foreach ($this->resolveIterator($paths) as $path) {
            // TODO: add support for only looking for a specific type
            $entities[] = $path->getName();
        }

        return $entities;
    }

    protected function resolveIterator(array $paths)
    {
        $paths = array_map(
            fn (string $path) => is_dir($path) ? $path : dirname($path),
            $paths
        );

        foreach ($this->finder->in($paths) as $fileInfo) {
            try {
                $classes = (new ResolveClassesInPhpFile)->handle($fileInfo);

                foreach ($classes as $name) {
                    $rc = new ReflectionClass($name);

                    yield $name => $rc;
                }
            } catch (\Exception $exception) {
            }
        }
    }
}
