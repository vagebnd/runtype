<?php

namespace Vagebond\Runtype\Tests\Fakes\Hooks;

use Illuminate\Support\Facades\Auth;
use Vagebond\Runtype\Contracts\Hookable;
use Vagebond\Runtype\RuntypeConfig;
use Vagebond\Runtype\Tests\Fakes\Models\User;

class SetupEnvironment implements Hookable
{
    public function before(RuntypeConfig $config): void
    {
        $user = User::firstOrFail();

        Auth::login($user);
    }

    public function middle(string $content): string
    {
        return $content;
    }

    public function after(RuntypeConfig $config): void {}

}
