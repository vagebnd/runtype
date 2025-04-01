<?php

namespace Vagebond\Runtype\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vagebond\Runtype\Contracts\ResolvesRequest;

class ResolveRequest implements ResolvesRequest
{
    public function resolve(): Request
    {
        return Auth::check()
            ? request()->setUserResolver(fn () => Auth::user())
            : request();
    }
}
