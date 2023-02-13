<?php

namespace Vagebond\Runtype\Tests\Fakes\Values;

class TestValue
{
    private string $stringProperty;

    public function __construct(
        public string $name,
        public int $value,
    ) {
    }
}
