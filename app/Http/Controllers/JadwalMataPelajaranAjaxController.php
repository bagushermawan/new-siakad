<?php

namespace App\Http\Controllers;

use App\Models\JadwalMataPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JadwalMataPelajaranAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $kelas = Kelas::all();
        $matpel = MataPelajaran::all();
        $tahunajaran = TahunAjaran::all();

        return view('admin.jadwalmatapelajaran.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'kelas' => $kelas,
            'matpel' => $matpel,
            'tahunajaran' => $tahunajaran,
        ]);
    }

    public function indexJadwalMatapelajaran()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = JadwalMataPelajaran::with(['kelas', 'mataPelajaran', 'tahunAjaran'])->orderBy('kelas_id', 'asc');

        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.matapelajaran.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->addColumn('kelas_id', function ($data) {
                return $data->kelas->name;
            })
            ->addColumn('mata_pelajaran_id', function ($data) {
                return optional($data->mataPelajaran)->name;
            })
            ->addColumn('tahun_ajaran_id', function ($data) {
            $tahunAjaran = $data->tahunAjaran;
            return $tahunAjaran->name . ' (' . $tahunAjaran->semester.')';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'kelas_id' => ['required', 'string', 'max:255'],
                'mata_pelajaran_id' => ['required', 'string', 'max:255'],
                'hari' => ['required', 'string', 'max:255'],
                'jam' => ['required', 'string', 'max:255'],
                'tahun_ajaran_id' => ['required', 'string', 'max:255'],
            ],
            [
                'kelas_id.required' => 'Kelas wajib diisi',
                'mata_pelajaran_id.required' => 'Mata Pelajaran wajib diisi',
                'hari.required' => 'Hari wajib diisi',
                'jam.required' => 'Jam wajib diisi',
                'tahun_ajaran_id.required' => 'Tahun Ajaran wajib diisi',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'kelas_id' => $request->kelas_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
            ];
            // Membuat user baru
            $jadwal = JadwalMataPelajaran::create($data);

            // Memberikan role 'kelas' pada kelas yang baru dibuat
            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ];

        JadwalMataPelajaran::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }



    public function edit(string $id)
    {
        $data = JadwalMataPelajaran::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function destroy(string $id)
    {
        JadwalMataPelajaran::where('id', $id)->delete();
    }
}