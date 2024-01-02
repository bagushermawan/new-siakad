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
        $total_user = User::count();
        $total_wali = WaliSantri::count();
        $total_all = $total_user + $total_wali;
        $total_role = Role::count();
        $total_permission = Permission::count();
        $total_matapelajaran = MataPelajaran::count();

        // Mendapatkan data riwayat login dari users dan wali_santris
        $data_riwayat_login_users = RiwayatLogin::where('user_id', '!=', Auth::user()->id)
            ->where('wali_santri_id', null)
            // ->where('updated_at', '>=', Carbon::today())
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $data_riwayat_login_walis = RiwayatLogin::where('wali_santri_id', '!=', null)
            // ->where('updated_at', '>=', Carbon::today())
            ->orderBy('status_login', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        // Alternatif: Mendapatkan role pertama dari user
        // $role = $user->getRoleNames()->first();

        return view('user.dashboard', [
            'user' => $user,
            'roles' => $roles,
            'total_user' => $total_user,
            'total_role' => $total_role,
            'total_permission' => $total_permission,
            'total_matapelajaran' => $total_matapelajaran,
            'total_all' => $total_all,
            'data_riwayat_login_users' => $data_riwayat_login_users,
            'data_riwayat_login_walis' => $data_riwayat_login_walis,
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
