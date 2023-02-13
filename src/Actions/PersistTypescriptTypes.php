<?php

namespace Vagebond\Runtype\Actions;

use Illuminate\Support\Collection;
use Vagebond\Runtype\RuntypeConfig;
use Vagebond\Runtype\Values\TypescriptType;

class PersistTypescriptTypes
{
    protected RuntypeConfig $config;

    public function __construct(RuntypeConfig $config)
    {
        $this->config = $config;
    }

    /** @param  Collection<TypescriptType>  $types */
    public function handle(collection $types)
    {
        $this->ensureOutputFileExists();

        file_put_contents(
            $this->config->getOutputFile(),
            (new TranspileToTypescript)->handle($types)
        );
    }

    protected function ensureOutputFileExists(): void
    {
        if (! file_exists(pathinfo($this->config->getOutputFile(), PATHINFO_DIRNAME))) {
            mkdir(pathinfo($this->config->getOutputFile(), PATHINFO_DIRNAME), 0755, true);
        }
    }
}
