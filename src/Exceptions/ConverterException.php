<?php

namespace Vagebond\Runtype\Exceptions;

class ConverterException extends \Exception
{
    public static function modifierDoesNotImplementModifiable(string $modifier): self
    {
        return new self(__('Modifier :modifier does not implement Modifiable interface', ['modifier' => $modifier]));
    }
}
