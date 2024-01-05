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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan instance dari user yang sedang login
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();

        $loggedInUserId = Auth::user()->id;
        // dd($loggedInUserId);

        // Contoh penggunaan di controller atau di mana pun Anda membutuhkannya
        $waliSantri = WaliSantri::with(['santri' => function ($query) {
            $query->select('id', 'nisn', 'name', 'username', 'nohp', 'email', 'foto_user');
        }])->find($loggedInUserId);
        // Mendapatkan data santri
        if ($waliSantri && $waliSantri->santri) {
            $santriData = $waliSantri->santri;

            $nisnSantri = $santriData->nisn ?? 'NISN Tidak Tersedia';
            $nohpSantri = $santriData->nohp ?? 'No HP Tidak Tersedia';
            $emailSantri = $santriData->email ?? 'Email Tidak Tersedia';
            $namaSantri = $santriData->name ?? 'Nama Santri Tidak Tersedia';
            $usernameSantri = $santriData->username ?? 'Username Santri Tidak Tersedia';
            $fotoSantri = $santriData->foto_user ?? 'Foto Santri Tidak Tersedia';
        } else {
            $nisnSantri = 'NISN Tidak Tersedia';
            $nohpSantri = 'No HP Tidak Tersedia';
            $emailSantri = 'Email Tidak Tersedia';
            $namaSantri = 'Nama Santri Tidak Tersedia';
            $usernameSantri = 'Username Santri Tidak Tersedia';
            $fotoSantri = 'Foto Santri Tidak Tersedia';
        }

        $waktu_sekarang = Carbon::now();
        Carbon::setLocale('id');
        $format_lengkap = $waktu_sekarang->translatedFormat('l, d F Y');

        // Mendapatkan data riwayat login dari users dan wali_santris
        $data_riwayat_login_users = RiwayatLogin::where('user_id', '!=', $loggedInUserId)
            ->where('wali_santri_id', null)
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $data_riwayat_login_walis = RiwayatLogin::where('wali_santri_id', '!=', $loggedInUserId)
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserBiasa $userBiasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserBiasa $userBiasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserBiasa $userBiasa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserBiasa $userBiasa)
    {
        //
    }
}
