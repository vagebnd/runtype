<?php

namespace Vagebond\Runtype\Tests\Fakes\Modifiers;

use Vagebond\Runtype\Contracts\Modifiable;

class FeatureModifier implements Modifiable
{
    public function modify($instance)
    {
        $instance->showHiddenData = true;

        return $instance;
    }
}
