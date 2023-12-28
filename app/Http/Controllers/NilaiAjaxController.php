<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Nilai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class NilaiAjaxController extends Controller
{

    public function getMatpelOptions()
    {
        $matpelOptions = MataPelajaran::orderBy('name', 'asc')->get(['id', 'name']);
        return response()->json($matpelOptions);
    }

    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        // Mengambil daftar guru
        $santri = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();
        $total_nilai = Nilai::count();

        $kelas = Kelas::all();
        $matpel = MataPelajaran::all();
        $tahunajaran = TahunAjaran::all();

        return view('admin.nilai.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'santri' => $santri,
            'kelas' => $kelas,
            'matpel' => $matpel,
            'tahunajaran' => $tahunajaran,
            'total_nilai' => $total_nilai,
        ]);
    }

    public function indexNilai()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = Nilai::with(['user', 'kelas', 'mataPelajaran', 'tahunAjaran'])->orderBy('user_id', 'asc');

        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.nilai.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->addColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->addColumn('kelas_id', function ($data) {
                return $data->kelas->name;
            })
            ->addColumn('mata_pelajaran_id', function ($data) {
                return ($data->mataPelajaran)->name;
            })
            ->addColumn('tahun_ajaran_id', function ($data) {
                $tahunAjaran = $data->tahunAjaran;
                return $tahunAjaran->name . ' (' . $tahunAjaran->semester . ')';
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
                'user_id' => ['nullable', 'exists:users,id'],
                'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajarans,id'],
                'kelas_id' => ['nullable', 'exists:kelas,id'],
                'tahun_ajaran_id' => ['nullable', 'exists:tahun_ajarans,id'],
                'nilai' => ['required', 'numeric', 'max:255'],
            ],
            [
                'nilai.required' => 'Nilai wajib diisi',
                // 'walikelas_id.exists' => 'Wali kelas tidak valid',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'nilai' => $request->nilai,
                'user_id' => $request->user_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
            ];
            // Membuat user baru
            $nilai = Nilai::create($data);

            // Memberikan role 'nilai' pada nilai yang baru dibuat
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
        $data = Nilai::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'nilai' => $request->nilai,
            'user_id' => $request->user_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ];

        Nilai::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data nilai']);
    }

    public function destroy(string $id)
    {
        Nilai::where('id', $id)->delete();
    }

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('nilais')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
