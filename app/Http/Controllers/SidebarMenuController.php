<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SidebarMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidebarMenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();
        $isAdmin = $user->hasRole('admin');

        $allMenus = SidebarMenu::where(function ($query) use ($roles) {
            $query->whereNull('roles')->orWhere(function ($q) use ($roles) {
                foreach ($roles as $role) {
                    $q->orWhere('roles', 'like', '%' . $role . '%');
                }
            });
        })
            ->orderBy('order')
            ->get();

        // Untuk sidebar: ambil menu utama (is_submenu=false) yang punya group dan children-nya
        $mainMenus = $allMenus
            ->where('is_submenu', false)
            ->whereNotNull('group')
            ->map(function ($menu) use ($allMenus) {
                $menu->children = $allMenus->where('parent_id', $menu->id);
                return $menu;
            });

        // Group by `group` kolom untuk sidebar
        $groupedMenus = $mainMenus->groupBy('group');

        return view('admin.sidebar_menu.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'menus' => $allMenus, // index
            'sidebarMenus' => $groupedMenus, // sidebar
        ]);
    }

    public function index2()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();
        $isAdmin = $user->hasRole('admin');

        // Ambil semua menu sesuai role
        $allMenus = SidebarMenu::where(function ($query) use ($roles) {
            $query->whereNull('roles')->orWhere(function ($q) use ($roles) {
                foreach ($roles as $role) {
                    $q->orWhere('roles', 'like', '%' . $role . '%');
                }
            });
        })
            ->orderBy('order')
            ->get();

        // Ambil hanya menu utama yang punya group
        $mainMenus = $allMenus
            ->where('is_submenu', false)
            ->whereNotNull('group')
            ->map(function ($menu) use ($allMenus) {
                // Tambahkan children dari allMenus
                $menu->children = $allMenus->where('parent_id', $menu->id);
                return $menu;
            });

        // Group by `group` kolom
        $groupedMenus = $mainMenus->groupBy('group');

        return view('admin.sidebar_menu.index2', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'sidebarMenus' => $groupedMenus,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        $parents = SidebarMenu::where('is_submenu', false)->get();
        return view('admin.sidebar_menu.create', ['roles' => $roles, 'isAdmin' => $isAdmin, 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'is_submenu' => 'boolean',
            'parent_id' => 'nullable|exists:sidebar_menus,id',
            'roles' => 'nullable|string|max:255',
        ]);

        SidebarMenu::create($request->all());

        return redirect()->route('sidebar-menu.index')->with('success', 'Menu berhasil dibuat');
    }

    public function edit(SidebarMenu $sidebarMenu)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        $parents = SidebarMenu::where('is_submenu', false)
            ->where('id', '!=', $sidebarMenu->id) // supaya tidak jadi parent sendiri
            ->get();
        return view('admin.sidebar_menu.edit', ['roles' => $roles, 'isAdmin' => $isAdmin, 'parents' => $parents, 'sidebarMenu' => $sidebarMenu]);
    }

    public function update(Request $request, SidebarMenu $sidebarMenu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'is_submenu' => 'boolean',
            'parent_id' => 'nullable|exists:sidebar_menus,id',
            'roles' => 'nullable|string|max:255',
        ]);

        $sidebarMenu->update($request->all());

        return redirect()->route('sidebar-menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(SidebarMenu $sidebarMenu)
    {
        $sidebarMenu->delete();

        return redirect()->route('sidebar-menu.index')->with('success', 'Menu berhasil dihapus');
    }
}
