<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $daftar_permission = Permission::all();

        return view('admin.permission.index', ['roles' => $roles, 'daftar_permission' => $daftar_permission, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $daftar_permission = Permission::all();
        $permission = Permission::get();

        return view('admin.permission.create', [
            'roles' => $roles,
            'daftar_permission' => $daftar_permission,
            'isAdmin' => $isAdmin,
            'permission' => $permission,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        // Proses untuk menyimpan data permission
        $permission = (['name' => $request->input('name')]);

        // Buat 4 permission sekaligus
        $moduleName = strtolower($request->input('name'));
        $actions = ['lihat', 'tambah', 'edit', 'hapus'];

        foreach ($actions as $action) {
            Permission::create(['name' => $action . '-' . $moduleName]);
        }

        // Notifikasi SweetAlert
        $successMessage = 'Role berhasil dibuat';

        return redirect()
        ->route('permission.index')
        ->with('successMessage', $successMessage);
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
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $daftar_permission = Permission::all();

        $permission = Permission::find($id);
        if (!$permission) {
            return abort(404);
        }

        return view('admin.permission.edit', [
            'roles' => $roles,
            'daftar_permission' => $daftar_permission,
            'isAdmin' => $isAdmin,
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()
            ->route('permission.index')
            ->with('success', 'permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        $destroyMessage = 'Role berhasil dihapus';
        return redirect()->route('permission.index')->with('destroyMessage', $destroyMessage);
    }
}
