<?php

declare(strict_types=1);

namespace App\MoonShine\Authentication;

use MoonShine\Laravel\Http\Middleware\Authenticate as MoonshineAuthenticateMiddleware;

class Authenticate extends MoonshineAuthenticateMiddleware
{
    #[\Override]
    protected function redirectTo($request): string
    {
        return route('home');
    }
}
