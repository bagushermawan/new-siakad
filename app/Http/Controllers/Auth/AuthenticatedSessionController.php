<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Tambahkan logika untuk menentukan guard yang berhasil login
        $guard = $this->getGuard($request);

        return redirect()->intended($this->redirectPath($guard));
    }

    protected function getGuard(LoginRequest $request): string
    {
        // Tentukan guard yang berhasil login berdasarkan kondisi tertentu
        if (Auth::guard('web')->check()) {
            return 'web';
        } elseif (Auth::guard('wali')->check()) {
            return 'wali';
        }

        // Default guard jika tidak ada guard yang berhasil login
        return 'web';
    }

    protected function redirectPath(string $guard): string
    {
        // Tambahkan logika untuk menentukan redirect path berdasarkan guard
        if ($guard === 'wali') {
            return RouteServiceProvider::WALI_HOME;
        }

        return RouteServiceProvider::HOME;
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            // dd('Logout from web guard');
        } elseif (Auth::guard('wali')->check()) {
            Auth::guard('wali')->logout();
            // dd('Logout from wali guard');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
