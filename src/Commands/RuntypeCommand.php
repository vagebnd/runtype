<?php

namespace Vagebond\Runtype\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Vagebond\Runtype\Runtype;
use Vagebond\Runtype\RuntypeConfig;

class RuntypeCommand extends Command
{
    use ConfirmableTrait;

    public $signature = 'runtype:generate {--force : Force the operation to run when in production}';

    public $description = 'Transform resources into typescript';

    public function handle(RuntypeConfig $config): int
    {
        $this->confirmToProceed();

        (new Runtype($config))->generate();

        $this->info('Typescript types generated');

        return self::SUCCESS;
    }
}
