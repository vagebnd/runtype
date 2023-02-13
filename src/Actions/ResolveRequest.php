<?php

namespace Vagebond\Runtype\Actions;

use Illuminate\Http\Request;
use Vagebond\Runtype\Contracts\ResolvesRequest;

class ResolveRequest implements ResolvesRequest
{
    public function resolve(): Request
    {
        return request();
    }
}
