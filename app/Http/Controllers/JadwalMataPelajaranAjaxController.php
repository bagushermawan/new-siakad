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
use Illuminate\Support\Facades\DB;

class JadwalMataPelajaranAjaxController extends Controller
{
    public function getKelasOptions()
    {
        $kelasOptions = Kelas::all(['id', 'name']);
        return response()->json($kelasOptions);
    }

    public function getTahunAjaranOptions()
    {
        $tahunAjaranOptions = TahunAjaran::all(['id', 'name', 'semester']);
        return response()->json($tahunAjaranOptions);
    }
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
        $total_jadwal = JadwalMataPelajaran::count();

        return view('admin.jadwalmatapelajaran.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'kelas' => $kelas,
            'matpel' => $matpel,
            'tahunajaran' => $tahunajaran,
            'total_jadwal' => $total_jadwal,
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
                // Pastikan properti yang diakses benar-benar ada sebelum mengaksesnya
                return optional($data->kelas)->name ?? 'Kelas tidak tersedia';
            })
            ->addColumn('mata_pelajaran_id', function ($data) {
                // Pastikan properti yang diakses benar-benar ada sebelum mengaksesnya
                return optional($data->mataPelajaran)->name ?? 'Mata Pelajaran tidak tersedia';
            })
            ->addColumn('tahun_ajaran_id', function ($data) {
                $tahunAjaran = $data->tahunAjaran;

                if ($tahunAjaran) {
                    // Pastikan properti yang diakses benar-benar ada sebelum mengaksesnya
                    $namaTahunAjaran = optional($tahunAjaran)->name ?? 'Tidak Ada Nama Tahun Ajaran';
                    $semester = optional($tahunAjaran)->semester ?? 'Tidak Ada Semester';

                    return $namaTahunAjaran . ' (' . $semester . ')';
                } else {
                    return 'Tahun Ajaran tidak tersedia';
                }
            })
            ->make(true);
    }

    public function getKelasData()
    {
        $kelas = Kelas::all();

        return response()->json(['data' => $kelas]);
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

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('jadwal_mata_pelajarans')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
