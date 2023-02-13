<?php

namespace Vagebond\Runtype\Tests\Fakes\Modifiers;

class InvalidModifier
{
    public function modify($model, $resource): void
    {
        $resource->showHiddenData = true;
    }
}
