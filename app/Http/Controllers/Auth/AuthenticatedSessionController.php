<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Events\UserLoggedIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\RiwayatLogin;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        // Jika pengguna sudah login dengan guard 'web'
        if (Auth::guard('web')->check()) {
            // Redirect ke rute dashboard untuk guard 'web'
            return redirect('/qwe/dashboard'); // Ganti 'web.dashboard' dengan rute yang sesuai
        }
        // Jika pengguna sudah login dengan guard 'wali'
        if (Auth::guard('wali')->check()) {
            // Redirect ke rute '/' untuk guard 'wali'
            return redirect('/');
        }
        // Jika belum login, tampilkan halaman login
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

        // Panggil event UserLoggedIn
        // event(new UserLoggedIn(auth()->user()));

        // Riwayat Login
        $userId = auth()
            ->guard($guard)
            ->id();
        $waliSantriId = null;

        if ($guard === 'web') {
            $cekRiwayat = RiwayatLogin::where('user_id', $userId)->first();

            if (is_null($cekRiwayat)) {
                $riwayatLogin = new RiwayatLogin([
                    'user_id' => $userId,
                    'status_login' => true,
                ]);
                $riwayatLogin->save();
            } else {
                $cekRiwayat->update(['status_login' => true]);
            }
        } elseif ($guard === 'wali') {
            // Jika yang login adalah wali santri
            $waliSantriId = $userId;

            $cekRiwayat = RiwayatLogin::where('wali_santri_id', $waliSantriId)->first();

            if (is_null($cekRiwayat)) {
                $riwayatLogin = new RiwayatLogin([
                    'wali_santri_id' => $waliSantriId,
                    'status_login' => true,
                ]);
                $riwayatLogin->save();
            } else {
                $cekRiwayat->update(['status_login' => true]);
            }
        }

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
        if ($guard === 'wali' || $guard === 'web' && auth()->guard($guard)->user()->hasRole('user')) {
            return RouteServiceProvider::WALI_HOME;
        }

        return RouteServiceProvider::HOME;
    }

    public function destroy(Request $request): RedirectResponse
    {
        $guard = null;
        $userId = null;

        if (
            auth()
            ->guard('web')
            ->check()
        ) {
            $guard = 'web';
            $userId = auth()
                ->guard('web')
                ->id();
            auth()
                ->guard('web')
                ->logout();
        } elseif (
            auth()
            ->guard('wali')
            ->check()
        ) {
            $guard = 'wali';
            $userId = auth()
                ->guard('wali')
                ->id();
            auth()
                ->guard('wali')
                ->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Update status login
        if ($guard && isset($userId)) {
            if ($guard === 'web') {
                RiwayatLogin::where('user_id', $userId)->update([
                    'status_login' => false,
                ]);
            } elseif ($guard === 'wali') {
                RiwayatLogin::where('wali_santri_id', $userId)->update([
                    'status_login' => false,
                ]);
            }
        }

        return redirect('login');
    }
}
