<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

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
                return view('admin.user.tombol', ['data' =>$data, 'isAdmin' => $isAdmin]);
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

        $data = User::with('roles')
        ->when($isAdmin, function ($query) {
            // Jika bukan admin, filter hanya user dengan role 'guru'
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'user');
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'nisn' => ['required', 'string', 'max:255'],
                'nuptk' => ['required', 'string', 'max:255'],
                'nohp' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_num'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', Rules\Password::defaults()],
            ],
            [
                'nohp.required' => 'No HP wajib diisi',
                'nisn.required' => 'NISN wajib diisi',
                'nuptk.required' => 'NUPTK wajib diisi',
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
            ],
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
                'password' => Hash::make($request->password),
                'email_verified_at' => Carbon::now(),
            ];
            // Membuat user baru
            $user = User::create($data);

            // Memberikan role 'user' pada user yang baru dibuat
            $user->assignRole('user');
            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'nisn' => $request->nisn,
            'nuptk' => $request->nuptk,
            'nohp' => $request->nohp,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        // Check if the password field is filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        User::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
    }
}
