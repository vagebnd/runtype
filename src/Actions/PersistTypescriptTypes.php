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
    public function handle(Collection $types)
    {
        $this->ensureOutputFileExists();

        $content = $this->config->getLines()->join(PHP_EOL) . (new TranspileToTypescript)->handle($types);

        foreach ($this->config->getHooks() as $hook) {
            $content = $hook->middle($content);
        }

        file_put_contents(
            $this->config->getOutputFile(),
            $content,
        );
    }

    protected function ensureOutputFileExists(): void
    {
        if (! file_exists(pathinfo($this->config->getOutputFile(), PATHINFO_DIRNAME))) {
            mkdir(pathinfo($this->config->getOutputFile(), PATHINFO_DIRNAME), 0755, true);
        }
    }
}
