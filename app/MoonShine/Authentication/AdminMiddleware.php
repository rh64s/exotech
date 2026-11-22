<?php

namespace App\MoonShine\Authentication;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null && ! $user->hasRole('admin')) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
