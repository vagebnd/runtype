<?php

namespace Vagebond\Runtype\Converters\Modifiers;

use Vagebond\Runtype\Contracts\Modifiable;

class UnsetRelationsModifier implements Modifiable
{
    public function modify($instance)
    {
        if (method_exists($instance, 'unsetRelations')) {
            $instance->unsetRelations();
        }

        return $instance;
    }
}
