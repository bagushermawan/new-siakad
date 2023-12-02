<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class UserAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = User::with('roles')->orderBy('name', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.user.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function indexGuru()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        $data = User::with('roles')
            ->when($isAdmin, function ($query) {
                // Jika bukan admin, filter hanya user dengan role 'guru'
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'guru');
                });
            })
            ->orderBy('name', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.user.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function indexSiswa()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');


        $data = User::with(['roles', 'kelas'])->orderBy('name', 'asc')
            ->when($isAdmin, function ($query) {
                // Jika bukan admin, filter hanya user dengan role 'guru'
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'user');
                });
            })
            ->orderBy('name', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kelas_name', function ($data) {
                return $data->kelas->name ?? ''; // Pastikan menangani kasus jika tidak ada kelas terkait
            })
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.user.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function getUserRoleCountChartjs()
    {
        $adminCount = User::role('admin')->count();
        $guruCount = User::role('guru')->count();
        $userCount = User::role('user')->count();

        return response()->json([
            'admin' => $adminCount,
            'guru' => $guruCount,
            'user' => $userCount,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'nisn' => ['nullable', 'string', 'max:255'],
                'nuptk' => ['nullable', 'string', 'max:255'],
                'nohp' => ['nullable', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_num'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', Rules\Password::defaults()],
                'kelas_id' => ['nullable', 'exists:kelas,id'],
            ],
            [
                'nohp.required' => 'No HP wajib diisi',
                'nisn.required' => 'NISN wajib diisi',
                'nuptk.required' => 'NUPTK wajib diisi',
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
                'kelas_id.exists' => 'Kelas tidak valid',
            ]
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'nohp' => $request->nohp,
                'nisn' => $request->nisn,
                'nuptk' => $request->nuptk,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'kelas_id' => $request->kelas_id,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'email_verified_at' => Carbon::now(),
            ];

            // Membuat user baru
            // print_r($request->role);
            $user = User::create($data);

            $user->assignRole($request->role);

            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = User::where('id', $id)->first();
        $role = $data->getRoleNames();
        return response()->json(['result' =>$data, 'role' => $role]);
    }


    public function update(Request $request, string $id)
    {
        $data = [
            'nisn' => $request->nisn,
            'nuptk' => $request->nuptk,
            'nohp' => $request->nohp,
            'name' => $request->name,
            'username' => $request->username,
            'kelas_id' => $request->kelas_id,
            'email' => $request->email,
        ];

        // Check if the password field is filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user data
        User::where('id', $id)->update($data);

        // Update roles
        if ($request->filled('role')) {
            $user = User::findOrFail($id);

            // Remove existing roles
            $user->roles()->detach();

            // Add new roles
            $user->assignRole($request->role);
        }

        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
    }
}
