<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\UserBiasa;
use App\Models\WaliSantri;
use App\Models\RiwayatLogin;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\JadwalMataPelajaran;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Kelas;
use Illuminate\Validation\ValidationException;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        $loggedInUserId = Auth::user()->id;
        $santriId = WaliSantri::where('id', $loggedInUserId)->value('santri_id');

        // Contoh penggunaan di controller atau di mana pun Anda membutuhkannya
        $waliSantri = WaliSantri::with(['santri.kelas:id,name'])->find($loggedInUserId);

        // Mendapatkan data santri
        if ($waliSantri && $waliSantri->santri) {
            $santriData = $waliSantri->santri;

            $nisnSantri = $santriData->nisn ?? 'NISN Tidak Tersedia';
            $nohpSantri = $santriData->nohp ?? 'No HP Tidak Tersedia';
            $emailSantri = $santriData->email ?? 'Email Tidak Tersedia';
            $namaSantri = $santriData->name ?? 'Nama Santri Tidak Tersedia';
            $usernameSantri = $santriData->username ?? 'Username Santri Tidak Tersedia';
            $fotoSantri = $santriData->foto_user ?? '';
            $kelasSantri = $santriData->kelas ? $santriData->kelas->name : 'Kelas Santri Tidak Tersedia';
        } else {
            $nisnSantri = 'NISN Tidak Tersedia';
            $nohpSantri = 'No HP Tidak Tersedia';
            $emailSantri = 'Email Tidak Tersedia';
            $namaSantri = 'Nama Santri Tidak Tersedia';
            $usernameSantri = 'Username Santri Tidak Tersedia';
            $fotoSantri = '';
            $kelasSantri = 'Kelas Santri Tidak Tersedia';
        }

        $waktu_sekarang = Carbon::now();
        Carbon::setLocale('id');
        $format_lengkap = $waktu_sekarang->translatedFormat('l, d F Y');

        // Mendapatkan data riwayat login dari users dan wali_santris
        $data_riwayat_login_users = RiwayatLogin::where('user_id', '!=', $loggedInUserId)
            ->where('wali_santri_id', null)
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'user');
                });
            })
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $data_riwayat_login_walis = RiwayatLogin::where('wali_santri_id', '!=', $loggedInUserId)
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $thaktif = TahunAjaran::where('status', 'aktif')->first();

        // Alternatif: Mendapatkan role pertama dari user
        // $role = $user->getRoleNames()->first();

        return view('user.dashboard', [
            'user' => $user,
            'roles' => $roles,
            'waliSantri' => $waliSantri,
            'namaSantri' => $namaSantri,
            'usernameSantri' => $usernameSantri,
            'nisnSantri' => $nisnSantri,
            'nohpSantri' => $nohpSantri,
            'emailSantri' => $emailSantri,
            'fotoSantri' => $fotoSantri,
            'kelasSantri' => $kelasSantri,
            'thaktif' => $thaktif,
            'santriId' => $santriId,
            'data_riwayat_login_users' => $data_riwayat_login_users,
            'data_riwayat_login_walis' => $data_riwayat_login_walis,
            'waktu_sekarang' => $format_lengkap,
        ]);
    }

    public function getUserRoleCountChartjs()
    {
        $guruCount = User::role('guru')->count();
        $userCount = User::role('user')->count();
        $waliCount = WaliSantri::count();

        return response()->json([
            'series' => [$guruCount, $userCount, $waliCount],
            'labels' => ['Guru', 'User', 'Wali'],
        ]);
    }

    public function dataNilaiForWali()
    {
        $loggedInUserId = Auth::user()->id;

        // Dapatkan ID Santri yang terkait dengan waliSantri yang sedang login
        $santriId = WaliSantri::where('id', $loggedInUserId)->value('santri_id');

        if ($santriId) {
            // Dapatkan kelas dari Santri
            $kelasSantri = User::where('id', $santriId)->value('kelas_id');

            // Dapatkan tahun ajaran yang sedang aktif berdasarkan name
            $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
            $tahunAjaranName = $tahunAjaranAktif->name;

            // Gunakan ID Santri, kelas, dan name tahun ajaran untuk mengambil nilai
            $dataNilai = Nilai::with(['user', 'kelas', 'mataPelajaran', 'tahunAjaran'])
                ->where('user_id', $santriId)
                ->where('kelas_id', $kelasSantri)
                ->whereHas('tahunAjaran', function ($query) use ($tahunAjaranName) {
                    $query->where('name', $tahunAjaranName);
                })
                ->orderBy('tahun_ajaran_id', 'asc')
                ->get();

            return DataTables::of($dataNilai)
                ->addIndexColumn()
                ->addColumn('user_id', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('kelas_id', function ($data) {
                    return $data->kelas->name;
                })
                ->addColumn('mata_pelajaran_id', function ($data) {
                    return optional($data->mataPelajaran)->name ?? 'Tidak Ada Mata Pelajaran';
                })
                ->addColumn('tahun_ajaran_id', function ($data) {
                    $namaTahunAjaran = optional($data->tahunAjaran)->name ?? 'Tidak Ada Nama Tahun Ajaran';
                    $semester = optional($data->tahunAjaran)->semester ?? 'Tidak Ada Semester';

                    return $namaTahunAjaran . ' (' . $semester . ')';
                })
                ->make(true);
        } else {
            // Jika tidak ada ID Santri yang terkait, kembalikan response kosong atau sesuai kebutuhan Anda
            return DataTables::of([])->make(true);
        }
    }

    public function dataNilaiForSantri()
    {
        $loggedInUserId = Auth::user()->id;
        // Dapatkan kelas dari Santri
        $kelasSantri = User::where('id', $loggedInUserId)->value('kelas_id');

        // Dapatkan tahun ajaran yang sedang aktif berdasarkan name
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $tahunAjaranName = $tahunAjaranAktif->name;

        // Gunakan ID Santri, kelas, dan name tahun ajaran untuk mengambil nilai
        $dataNilai = Nilai::with(['user', 'kelas', 'mataPelajaran', 'tahunAjaran'])
            ->where('user_id', $loggedInUserId)
            // ->where('kelas_id', $kelasSantri)
            // ->whereHas('tahunAjaran', function ($query) use ($tahunAjaranName) {
            //     $query->where('name', $tahunAjaranName);
            // })
            ->orderBy('tahun_ajaran_id', 'asc')
            ->get();

        return DataTables::of($dataNilai)
            ->addIndexColumn()
            ->addColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->addColumn('kelas_id', function ($data) {
                return $data->kelas->name;
            })
            ->addColumn('mata_pelajaran_id', function ($data) {
                return optional($data->mataPelajaran)->name ?? 'Tidak Ada Mata Pelajaran';
            })
            ->addColumn('tahun_ajaran_id', function ($data) {
                $namaTahunAjaran = optional($data->tahunAjaran)->name ?? 'Tidak Ada Nama Tahun Ajaran';
                $semester = optional($data->tahunAjaran)->semester ?? 'Tidak Ada Semester';

                return $namaTahunAjaran . ' (' . $semester . ')';
            })
            ->addColumn('tahun_ajaran_semester', function ($data) {
                $semester = optional($data->tahunAjaran)->semester ?? 'Tidak Ada Semester';

                return $semester;
            })
            ->make(true);
    }

    public function dataJadwalPelajaranUser()
    {
        $loggedInUserId = Auth::user()->id;
        $thaktif = TahunAjaran::where('status', 'aktif')->first();
        $waliSantri = WaliSantri::with(['santri.kelas:id'])->find($loggedInUserId);
        $kelasSantri = optional($waliSantri->santri->kelas)->id;

        $data = JadwalMataPelajaran::with(['kelas', 'mataPelajaran', 'tahunAjaran'])
            ->where('kelas_id', $kelasSantri)
            // ->where('tahun_ajaran_id', $thaktif->id)
            ->orderBy('kelas_id', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
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

    // For Select semester genap/ganjil
    public function getTahunAjaranAktifOptions()
    {
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $tahunAjaranOptions = TahunAjaran::where('name', $tahunAjaranAktif->name)->get(['id', 'name', 'semester']);

        return response()->json($tahunAjaranOptions);
    }

    public function getKelasOptions()
    {
        $loggedInUserId = Auth::user()->id;
        // Dapatkan kelas dari Santri
        $kelasSantri = User::where('id', $loggedInUserId)->value('kelas_id');
        $kelasOptions = Kelas::all(['id', 'name']);
        return response()->json(['kelasOptions' => $kelasOptions, 'kelasSantri' => $kelasSantri]);
    }

    public function getTahunAjaranOptions()
    {
        // Mengambil tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
        $tahunAjaranOptions = $tahunAjaranAktif ? $tahunAjaranAktif->name : null;

        // DB::enableQueryLog();
        $allTahunAjaranOptions = DB::table('tahun_ajarans')->select('name')->distinct()->get();
        // dd(DB::getQueryLog());

        return response()->json(['tahunAjaranOptions' => $tahunAjaranOptions, 'allTahunAjaranOptions' => $allTahunAjaranOptions]);
    }

    public function searchSantri(Request $request)
    {
        try {
            $user = Auth::user();
            $roles = $user->getRoleNames();
            $loggedInUserId = $user->id;
            $santriId = WaliSantri::where('id', $loggedInUserId)->value('santri_id');
            $waktu_sekarang = now()->translatedFormat('l, d F Y');

            // Use the validate method directly
            $request->validate([
                'username' => 'required|string',
                'nohp' => 'required|numeric',
            ]);

            $username = $request->input('username');
            $noHp = $request->input('nohp');

            // Perform the search based on username and phone number
            $santri = User::where('username', $username)
                ->where('nohp', $noHp)
                ->first();

            if ($santri) {
                return view('user.connect', compact('santri', 'roles', 'santriId', 'waktu_sekarang'))
                ->with('success', 'Santri ditemukan');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['error' => 'Santri tidak ditemukan']);
            }
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->validator->errors())
                ->with('error', $e->getMessage());
        }
    }

    public function hubungkanSantri(Request $request, $santriId)
    {
        // Mendapatkan objek WaliSantri yang sesuai
        $waliSantri = Auth::user()->id;
        // $wali = WaliSantri::where('id', $waliSantri)->value('id');

        // dd($waliSantri);
        // Memastikan objek WaliSantri ditemukan
        if ($waliSantri) {
            // Mengupdate kolom santri_id
            // $waliSantri->update(['santri_id' => $santriId]);
            WaliSantri::where('id', $waliSantri)->update(['santri_id' => $santriId]);

            return redirect()
                ->route('user.dashboard')
                ->with('success', 'Santri berhasil dihubungkan.');
        } else {
            return redirect()
                ->route('user.dashboard')
                ->with('error', 'Data WaliSantri tidak ditemukan.');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(UserBiasa $userBiasa)
    {
        //
    }

    public function edit(Request $request): View
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        $waktu_sekarang = Carbon::now();
        Carbon::setLocale('id');
        $format_lengkap = $waktu_sekarang->translatedFormat('l, d F Y');
        $kelasOptions = Kelas::all();

        return view('user.edit', [
            'user' => $request->user(),
            'roles' => $roles,
            'kelasOptions' => $kelasOptions,
            'waktu_sekarang' => $format_lengkap,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // Menggunakan user yang sedang login

        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        if ($request->has('kelas_id')) {
            $user->kelas_id = $request->get('kelas_id');
        }
        if ($request->has('nisn')) {
            $user->nisn = $request->get('nisn');
        }
        if ($request->has('nohp')) {
            $user->nohp = $request->get('nohp');
        }

        // Proses gambar jika diunggah
        if ($request->hasFile('foto_user')) {
            // Simpan gambar baru
            $fotoPath = $request->file('foto_user')->store('foto_user', 'public');
            $user->update(['foto_user' => $fotoPath]);
        }

        $user->save();

        return redirect()
            ->back()
            ->with('status', 'profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserBiasa $userBiasa)
    {
        //
    }
}
