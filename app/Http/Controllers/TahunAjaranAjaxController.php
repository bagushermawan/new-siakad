<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = TahunAjaran::orderBy('tahun', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tahunajaran.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
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
                'tahun' => ['required', 'string', 'max:255'],
            ],
            [
                'tahun.required' => 'tahun ajaran wajib diisi',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'tahun' => $request->tahun,
            ];
            // Membuat user baru
            $prestasi = TahunAjaran::create($data);

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
        $data = TahunAjaran::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'tahun' => $request->tahun,
        ];

        TahunAjaran::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TahunAjaran::where('id', $id)->delete();
    }
}
