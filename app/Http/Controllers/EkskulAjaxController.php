<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EkskulAjaxController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');

        return view('admin.ekskul.index', ['roles' => $roles, 'isAdmin' => $isAdmin]);
    }

    public function indexEkskul()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = Ekskul::orderBy('name', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.ekskul.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
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
            $ekskul = Ekskul::create($data);

            // Memberikan role 'ekskul' pada ekskul yang baru dibuat
            return response()->json(['success' => 'Berhasil menyimpan data ekskul']);
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = Ekskul::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }


    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
        ];

        Ekskul::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Ekskul::where('id', $id)->delete();
    }
}
