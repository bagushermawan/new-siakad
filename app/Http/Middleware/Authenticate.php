<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\ForbiddenException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected $guard = 'wali';

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Use the custom ForbiddenException for error 403
            throw new ForbiddenException();
        }

        return null;
    }
}
