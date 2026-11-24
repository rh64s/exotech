<?php

declare(strict_types=1);

namespace App\MoonShine\Authentication;

use Illuminate\Http\RedirectResponse;
use MoonShine\Laravel\Http\Middleware\Authenticate as MoonshineAuthenticateMiddleware;

class Authenticate extends MoonshineAuthenticateMiddleware
{
    /* protected function authenticate($request, array $guards): void */
    /* { */
    /*     if (! moonshineConfig()->isAuthEnabled()) { */
    /*         return; */
    /*     } */
    /**/
    /*     $guard = MoonShineAuth::getGuard(); */
    /**/
    /*     if (! $guard->check()) { */
    /*         $this->unauthenticated($request, [$guard, ...$guards]); */
    /*     } */
    /**/
    /*     $this->auth->shouldUse(MoonShineAuth::getGuardName()); */
    /**/
    /* } */

    #[\Override]
    protected function redirectTo($request): string
    {
        return route('login');
    }
}
