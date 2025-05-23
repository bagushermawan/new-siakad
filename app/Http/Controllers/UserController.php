<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\WaliSantri;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        $userType = $user->user_type;
        $santri = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        // Mengambil daftar guru
        $roless = Role::get();

        // Mengambil daftar wali santri
        $wali = WaliSantri::get();

        // Mendapatkan user_type dari setiap wali santri
        $waliTypes = $wali->pluck('user_type');

        return view('admin.user.index', [
            'roles' => $roles,
            'daftar_user' => $daftar_user,
            'isAdmin' => $isAdmin,
            'roless' => $roless,
            'kelasOptions' => $kelasOptions,
            'userType' => $userType,
            'waliTypes' => $waliTypes,
            'santri' => $santri,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $user = User::find($id);
        return view('admin.user.profileEdit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Proses gambar jika diunggah
        if ($request->hasFile('foto_user')) {
            // Simpan gambar baru
            $fotoPath = $request->file('foto_user')->store('foto_user', 'public');
            $user->update(['foto_user' => $fotoPath]);
        }

        $user->save();
        return redirect()->back()->with('status', 'profile-updated');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        // Jika pengguna tidak ditemukan
        if (!$user) {
            return Redirect::route('admin.user.index')->with('error', 'User not found');
        }

        // Lakukan operasi penghapusan
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully');
    }

    public function getDataForDataTables()
    {
        $data = User::all();

        $formattedData = $data->map(function ($user, $index) {
            return [
                'no' => $index + 1,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at->toDateString(),
                'roles' => ucfirst(implode(', ', $user->roles->pluck('name')->all())), // Tambah kolom roles
                'edit_url' => route('admin.user.edit', $user->id),
                'delete_url' => route('admin.user.destroy', $user->id),
            ];
        });

        $isAdmin = auth()->user()->hasRole('admin');

        return response()->json(['data' => $formattedData, 'isAdmin' => $isAdmin]);
    }
}
