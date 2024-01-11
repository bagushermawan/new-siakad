<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\ForbiddenException;

class Authenticate extends Middleware
{
    protected $guard = 'wali';

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Cek apakah pengguna sedang login
            if (auth()->guard($this->guard)->check()) {
                throw new ForbiddenException('Anda tidak memiliki hak akses untuk halaman ini.');
            } else {
                throw new ForbiddenException('Maaf, sesi anda telah berakhir silahkan login terlebih dahulu.');
            }
        }

        return null;
    }
}
