<?php

namespace Vagebond\Runtype;

use Symfony\Component\Finder\Finder;
use Vagebond\Runtype\Actions\ConvertEntities;
use Vagebond\Runtype\Actions\PersistTypescriptTypes;
use Vagebond\Runtype\Actions\ProcessEntities;
use Vagebond\Runtype\Actions\ResolveProcessableEntities;

class Runtype
{
    protected RuntypeConfig $config;

    public function __construct(RuntypeConfig $config)
    {
        $this->config = $config;
    }

    public function generate()
    {
        $hooks = $this->config->getHooks();

        foreach ($hooks as $hook) {
            $hook->before();
        }

        $entities = (new ResolveProcessableEntities(new Finder, $this->config))->handle();
        $instances = (new ProcessEntities($this->config))->handle($entities);
        $typescriptTypes = (new ConvertEntities($this->config))->handle($instances);

        (new PersistTypescriptTypes($this->config))->handle($typescriptTypes);

        foreach ($hooks as $hook) {
            $hook->after();
        }

        return $typescriptTypes;
    }
}
