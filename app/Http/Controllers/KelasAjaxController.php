<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class KelasAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        // Mengambil daftar guru
        $walikelas = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->get();

        return view('admin.kelas.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'walikelas' => $walikelas, // Menyertakan daftar guru ke dalam view
        ]);
    }

    public function indexKelas()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $data = Kelas::select(['kelas.*', DB::raw('COUNT(users.id) as users_count')])
            ->leftJoin('users', 'kelas.id', '=', 'users.kelas_id')
            ->groupBy('kelas.id')
            ->orderBy('name', 'asc');

        if (!$isAdmin) {
            // Jika bukan admin, tambahkan kondisi untuk siswa yang memiliki role 'guru'
            $data->where(function ($query) {
                $query
                    ->whereHas('users', function ($subquery) {
                        $subquery->whereHas('roles', function ($rolesQuery) {
                            $rolesQuery->where('name', 'guru');
                        });
                    })
                    ->orWhereNull('users.id'); // Siswa tanpa kelas juga akan ditampilkan
            });
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('users_count', function ($data) {
                return $data->users_count ?? 0;
            })
            ->addColumn('walikelas_name', function ($data) {
                // Mengambil nama dari ID wali kelas melalui relasi
                return optional($data->walikelas)->name;
            })
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.kelas.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
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
                'name' => ['required', 'string', 'max:255'],
                'walikelas_id' => ['nullable', 'exists:users,id'],
            ],
            [
                'name.required' => 'Nama wajib diisi',
                // 'walikelas_id.exists' => 'Wali kelas tidak valid',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
                'walikelas_id' => $request->walikelas_id,
            ];
            // Membuat user baru
            $kelas = Kelas::create($data);

            // Memberikan role 'kelas' pada kelas yang baru dibuat
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
        $data = Kelas::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
            'walikelas_id' => $request->walikelas_id,
        ];

        Kelas::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kelas::where('id', $id)->delete();
    }
}
