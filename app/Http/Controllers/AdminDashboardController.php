<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $total_role = Role::count();
        $total_permission = Permission::count();
        $total_matapelajaran = MataPelajaran::count();
        // Alternatif: Mendapatkan role pertama dari user
        // $role = $user->getRoleNames()->first();

        return view('admin.dashboard', ['roles' => $roles, 'total_user' => $total_user, 'total_role' => $total_role, 'total_permission' => $total_permission, 'total_matapelajaran'=> $total_matapelajaran]);
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
