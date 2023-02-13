<?php

namespace Vagebond\Runtype\Exceptions;

use Exception;
use Vagebond\Runtype\Contracts\Modifiable;

class ConfigurationException extends Exception
{
    public static function NoAutoDiscoverPathsDefined()
    {
        return new self(__('No auto discover paths defined'));
    }

    public static function classDoesNotExist(string $class)
    {
        return new self(__('Class :class does not exist', ['class' => $class]));
    }

    public static function replacementTypeShouldBeString(string $class, $replacement)
    {
        return new self(__('Replacement type for :class should be string, got :type', [
            'class' => $class, 'type' => gettype($replacement),
        ]));
    }

    public static function classDoesNotImplementModifiable(string $class)
    {
        return new self(__('Class :class does not implement :modifiable', [
            'class' => $class,
            'modifiable' => Modifiable::class,
        ]));
    }
}
