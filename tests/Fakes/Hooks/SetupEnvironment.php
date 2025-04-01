<?php

namespace Vagebond\Runtype\Tests\Fakes\Hooks;

use Illuminate\Support\Facades\Auth;
use Vagebond\Runtype\Contracts\Hookable;
use Vagebond\Runtype\Tests\Fakes\Models\User;

class SetupEnvironment implements Hookable
{
    public function before(): void
    {
        $user = User::firstOrFail();

        Auth::login($user);
    }

    public function after(): void {}
}
