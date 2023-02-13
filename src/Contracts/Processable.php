<?php

namespace Vagebond\Runtype\Contracts;

interface Processable
{
    public function process(string $classString);
}
