<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GuruController extends Controller
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

        return view('admin.user.guru.index', ['roles' => $roles, 'daftar_user' => $daftar_user, 'isAdmin' => $isAdmin]);
    }
}
