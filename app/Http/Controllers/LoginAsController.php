<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WaliSantri;
use App\Models\RiwayatLogin;

class LoginAsController extends Controller
{
    public function loginAsUser(Request $request, $id)
    {
        if (Auth::user()->hasRole('admin')) {
            $user = User::findOrFail($id);

            $guard = null;
            $userId = null;

            if (auth()->guard('web')->check()) {
                $guard = 'web';
                $userId = auth()->guard('web')->id();
                auth()->guard('web')->logout();
            } elseif (auth()->guard('wali')->check()) {
                $guard = 'wali';
                $userId = auth()->guard('wali')->id();
                auth()->guard('wali')->logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();

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

            Auth::login($user);

            if ($user->hasRole('user')) {
                return redirect('/');
            }

            return redirect('/qwe/dashboard')->with('success', 'Berhasil login sebagai ' . $user->name);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function loginAsWaliSantri(Request $request, $id)
    {
        if (Auth::user()->hasRole('admin')) {
            $waliSantri = WaliSantri::findOrFail($id);

            $guard = null;
            $userId = null;

            if (auth()->guard('web')->check()) {
                $guard = 'web';
                $userId = auth()->guard('web')->id();
                auth()->guard('web')->logout();
            } elseif (auth()->guard('wali')->check()) {
                $guard = 'wali';
                $userId = auth()->guard('wali')->id();
                auth()->guard('wali')->logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();

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

            // Autentikasi pengguna sebagai pengguna terkait
            Auth::guard('wali')->login($waliSantri);

            // Redirect ke dashboard atau halaman yang sesuai
            return redirect('/');
        } else {
            // Jika tidak memiliki izin, kembalikan error
            return response()->json(['error' => 'gagal'], 401);
        }
    }
}
