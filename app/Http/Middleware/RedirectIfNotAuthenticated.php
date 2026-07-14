<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class RedirectIfNotAuthenticated extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            if ($request->is('parish/*')) {
                return route('parish.login');
            }

            return route('userLogin'); //fallback
        }

        return null;
    }
}
