<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\RiwayatLogin;
use Carbon\Carbon;

class AdminDashboardController extends Controller
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
        $total_santri = User::role('user')->count();
        $total_guru = User::role('guru')->count();
        $total_role = Role::count();
        $total_permission = Permission::count();
        $total_matapelajaran = MataPelajaran::count();

        Carbon::setLocale('id');

        // // Mendapatkan data riwayat login dari users dan wali_santris
        // $data_riwayat_login_users = RiwayatLogin::where('user_id', '!=', Auth::user()->id)
        //     ->where('wali_santri_id', null)
        //     // ->where('updated_at', '>=', Carbon::today())
        //     ->orderBy('status_login', 'DESC')
        //     ->orderBy('updated_at', 'DESC')
        //     ->get();

        // $data_riwayat_login_walis = RiwayatLogin::where('wali_santri_id', '!=', null)
        //     // ->where('updated_at', '>=', Carbon::today())
        //     ->orderBy('status_login', 'DESC')
        //     ->orderBy('updated_at', 'DESC')
        //     ->get();

        $data_riwayat_login = RiwayatLogin::where(function ($query) {
            $query->where('user_id', '!=', Auth::user()->id)
            ->where('wali_santri_id', null);
        })->orWhere('wali_santri_id', '!=', null)
        // ->where('updated_at', '>=', Carbon::today())
        ->orderBy('status_login', 'DESC')
        ->orderBy('updated_at', 'DESC')
        ->get();

        // Alternatif: Mendapatkan role pertama dari user
        // $role = $user->getRoleNames()->first();

        return view('admin.dashboard', [
            'user' => $user,
            'roles' => $roles,
            'total_user' => $total_user,
            'total_santri' => $total_santri,
            'total_guru' => $total_guru,
            'total_wali' => $total_wali,
            'total_role' => $total_role,
            'total_permission' => $total_permission,
            'total_matapelajaran' => $total_matapelajaran,
            'total_all' => $total_all,
            'data_riwayat_login' => $data_riwayat_login,
            // 'data_riwayat_login_users' => $data_riwayat_login_users,
            // 'data_riwayat_login_walis' => $data_riwayat_login_walis,
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
