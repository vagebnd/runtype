<?php

namespace Vagebond\Runtype\Tests\Fakes\Hooks;

use Vagebond\Runtype\Contracts\Hookable;
use Vagebond\Runtype\RuntypeConfig;

class TestHook implements Hookable
{
    public function before(RuntypeConfig $config): void {}

    public function middle($content): string {
        return $content;
    }

    public function after(RuntypeConfig $config): void {}
}
