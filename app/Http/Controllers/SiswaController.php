<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kelas;
use Spatie\Permission\Models\Role;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        $daftar_user = User::get();
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $kelasOptions = Kelas::all();
        $roless = Role::get();
        // dd($kelasOptions);

        return view('admin.user.siswa.index', ['roles' => $roles, 'daftar_user' => $daftar_user, 'isAdmin' => $isAdmin, 'kelasOptions' =>$kelasOptions, 'roless' => $roless]);
    }
}
