<?php

namespace Vagebond\Runtype\Exceptions;

class UnresolvableResourceException extends \Exception
{
    public static function noMixinFound(string $resource): self
    {
        return new self(__('No @mixin found for resource :resource', ['resource' => $resource]));
    }

    public static function resourceDoesNotExist(string $resource): self
    {
        return new self(__('Class :resource does not exist', ['resource' => $resource]));
    }
}
