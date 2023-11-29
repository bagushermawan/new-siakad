<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class PrestasiAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = Prestasi::orderBy('name', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.prestasi.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
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
            ],
            [
                'name.required' => 'Nama wajib diisi',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
            ];
            // Membuat user baru
            $prestasi = Prestasi::create($data);

            // Memberikan role 'prestasi' pada prestasi yang baru dibuat
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
        $data = Prestasi::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
        ];

        Prestasi::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Prestasi::where('id', $id)->delete();
    }
}
