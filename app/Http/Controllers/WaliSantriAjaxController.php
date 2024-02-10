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
            ->orderBy('name', 'asc')
            ->get();

        // Mengambil daftar guru
        $roless = Role::get();
        $totalWali = WaliSantri::count();

        return view('admin.user.wali.index', [
            'data' => $data,
            'roles' => $roles,
            'daftar_user' => $daftar_user,
            'isAdmin' => $isAdmin,
            'roless' => $roless,
            'santri' => $santri,
            'totalWali' => $totalWali,
        ]);
    }

    public function indexWali()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $data = WaliSantri::with(['roles', 'santri'])
            ->orderBy('name', 'asc')
            ->get();

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
            'santri_id' => 'nullable|exists:users,id', // Tambahkan validasi untuk santri_id
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        // Cari user dengan peran 'user' jika santri_id disediakan
        $santriUser = $request->filled('santri_id')
            ? User::whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })
                ->where('id', $request->input('santri_id'))
                ->first()
            : null;

        // Buat instansi model WaliSantri
        $waliSantri = new WaliSantri();
        $waliSantri->name = $request->input('name');
        // $waliSantri->username = $request->input('username');
        $username = $request->username;
        $nameParts = explode(' ', $request->name);
        $namePart1 = $nameParts[0];
        $namePart2 = count($nameParts) > 1 ? $nameParts[1] : null;

        if (count($nameParts) === 1) {
            $username = strtolower(str_replace('.', '', $namePart1)) . rand(10, 99);
        } else {
            $username = strtolower(str_replace('.', '', $namePart1 . $namePart2));
        }
        $waliSantri->username = $username;
        $waliSantri->email = $request->input('email');
        $waliSantri->nohp = $request->input('nohp');
        $waliSantri->password = $request->password ? Hash::make($request->password) : Hash::make($request->username);

        // Tetapkan santri_id (user_id) dari user yang ditemukan, jika ada
        if ($santriUser) {
            $waliSantri->santri_id = $santriUser->id;
        }

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

    public function deleteAllWaliSantri()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('wali_santris')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
