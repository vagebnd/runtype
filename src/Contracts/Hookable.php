<?php

namespace Vagebond\Runtype\Contracts;

use Vagebond\Runtype\RuntypeConfig;

interface Hookable
{
    public function before(RuntypeConfig $config): void;

    public function middle(string $content): string;

    public function after(RuntypeConfig $config): void;
}
