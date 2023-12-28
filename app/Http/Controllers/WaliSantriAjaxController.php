<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\WaliSantri;

class WaliSantriAjaxController extends Controller
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
        $santri = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        $data = WaliSantri::with(['roles', 'santri'])
        ->orderBy('name', 'asc')->get();

        // Mengambil daftar guru
        $roless = Role::get();

        return view('admin.user.wali.index', ['data' => $data, 'roles' => $roles, 'daftar_user' => $daftar_user, 'isAdmin' => $isAdmin, 'roless' => $roless, 'santri' => $santri]);
    }

    public function indexWali()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $data = WaliSantri::with(['roles', 'santri'])
        ->orderBy('name', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('santri_name', function ($data) {
                return $data->santri->name ?? '';
            })
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:wali_santris',
            'email' => 'required|email|unique:wali_santris',
            'nohp' => 'nullable|string',
            'role' => 'required|string',
        ]);

        // Cari user dengan peran 'user'
        $santriUser = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })
            ->where('id', $request->input('santri_id'))
            ->first();

        // Pastikan user dengan peran 'user' dan ID yang diberikan ditemukan
        if (!$santriUser) {
            return response()->json(['error' => 'User santri tidak valid.'], 400);
        }

        // Buat instansi model WaliSantri
        $waliSantri = new WaliSantri;
        $waliSantri->name = $request->input('name');
        $waliSantri->username = $request->input('username');
        $waliSantri->email = $request->input('email');
        $waliSantri->nohp = $request->input('nohp');

        // Menetapkan santri_id (user_id) dari user yang ditemukan
        $waliSantri->santri_id = $santriUser->id;

        // Simpan ke dalam database
        $waliSantri->save();

        // Assign peran 'wali santri' ke model WaliSantri yang baru dibuat
        $waliSantri->assignRole($request->input('role'));

        // Redirect atau berikan respons sesuai kebutuhan aplikasi
        return response()->json(['success' => 'Berhasil menyimpan data']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = WaliSantri::where('id', $id)->first();
        $role = $data->getRoleNames();
        return response()->json(['result' => $data, 'role' => $role]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'nohp' => $request->nohp,
            'name' => $request->name,
            'username' => $request->username,
            'santri_id' => $request->santri_id,
            'email' => $request->email,
        ];

        // Check if the password field is filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user data
        WaliSantri::where('id', $id)->update($data);

        // Update roles
        if ($request->filled('role')) {
            $user = WaliSantri::findOrFail($id);

            // Remove existing roles
            $user->roles()->detach();

            // Add new roles
            $user->assignRole($request->role);
        }

        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    public function destroy(string $id)
    {
        WaliSantri::where('id', $id)->delete();
    }
}
