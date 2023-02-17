<?php
namespace Vagebond\Runtype\Contracts;

interface Hookable
{
    public function before(): void;
    public function after(): void;
}
