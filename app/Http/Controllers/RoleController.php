<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $daftar_role = Role::all();

        return view('admin.role.index', ['roles' => $roles, 'daftar_role' => $daftar_role, 'isAdmin' => $isAdmin]);
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
        $daftar_role = Role::all();
        $permission = Permission::get();

        return view('admin.role.create', [
            'roles' => $roles,
            'daftar_role' => $daftar_role,
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
            'name' => 'required|unique:roles,name',
            'permission' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        // Memastikan bahwa permission tidak null sebelum melakukan syncPermissions
        if ($request->has('permission')) {
            $role->syncPermissions($request->input('permission'));
        }

        // Notifikasi SweetAlert
        $successMessage = 'Role berhasil dibuat';

        return redirect()
        ->route('role.index')
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
        $daftar_role = Role::all();

        $role = Role::find($id);
        if (!$role) {
            return abort(404);
        }

        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.role.edit', [
            'roles' => $roles,
            'daftar_role' => $daftar_role,
            'isAdmin' => $isAdmin,
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'nullable|array',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // Memastikan bahwa permission tidak null sebelum melakukan syncPermissions
        if ($request->has('permission')) {
            $role->syncPermissions($request->input('permission'));
        }

        $updateMessage = 'Role berhasil diupdate';

        return redirect()
            ->route('role.index')
            ->with('updateMessage', $updateMessage);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findById($id);

        if (!$role) {
            return redirect()->route('role.index')->with('error', 'Role not found');
        }

        // Hapus role
        $role->delete();
        $destroyMessage = 'Role berhasil dihapus';

        return redirect()->route('role.index')->with('destroyMessage', $destroyMessage);
    }
}
