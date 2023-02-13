<?php

namespace Vagebond\Runtype\Contracts;

use Illuminate\Http\Request;

interface ResolvesRequest
{
    public function resolve(): Request;
}
