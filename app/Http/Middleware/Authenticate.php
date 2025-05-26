<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\ForbiddenException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected $guard = 'wali';

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (auth()->guard($this->guard)->check()) {
                //login tapi tidak punya izin
                abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
            } else {
                //tidak login lagi/sesi habis
                abort(403, 'Maaf, sesi Anda telah berakhir. Silakan login terlebih dahulu.');
            }
        }

        return null;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        foreach ($guards as $guard) {
            $user = Auth::guard($guard)->user();

            if ($guard === 'web' && $user) {
                $status = \App\Models\RiwayatLogin::where('user_id', $user->id)
                    ->latest()
                    ->value('status_login');

                Log::info('Status login user', ['user_id' => $user->id, 'status_login' => $status]);

                if (!$status) {
                    Auth::guard($guard)->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    abort(403, 'Anda telah di-logout oleh admin, silakan login ulang.');
                }
            }

            if ($guard === 'wali' && $user) {
                $status = \App\Models\RiwayatLogin::where('wali_santri_id', $user->id)
                    ->latest()
                    ->value('status_login');

                Log::info('Status login wali', ['wali_id' => $user->id, 'status_login' => $status]);

                if (!$status) {
                    Auth::guard($guard)->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    abort(403, 'Anda telah di-logout oleh admin, silakan login ulang.');
                }
            }
        }

        return $next($request);
    }
}
