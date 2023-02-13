<?php

namespace Vagebond\Runtype\Processors;

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
        $mixinClass = (new ResolveMixinFromClass)->handle($class);

        $valueInstance = (new ProcessEntities($this->config))->handle([$mixinClass])->first();

        return $class::make($valueInstance);
    }
}
