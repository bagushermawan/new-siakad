<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SidebarMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class SidebarMenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();
        $isAdmin = $user->hasRole('admin');
        $listroles = Role::pluck('name')->toArray();

        // Ambil semua menu yang memiliki roles cocok dengan user
        $allMenus = SidebarMenu::where(function ($query) use ($roles) {
            foreach ($roles as $role) {
                $query->orWhere('roles', 'like', '%' . $role . '%');
            }
        })
            ->orderBy('order')
            ->get();

        // Ambil menu utama (bukan submenu) dan isi dengan submenu (children) yang juga sesuai roles
        $mainMenus = $allMenus
            ->where('is_submenu', false)
            ->whereNotNull('group')
            ->map(function ($menu) use ($allMenus) {
                $menu->children = $allMenus->where('parent_id', $menu->id);
                return $menu;
            })
            // Hanya tampilkan menu yang punya anak atau route_name-nya bukan '#'
            ->filter(function ($menu) {
                return $menu->children->isNotEmpty() || $menu->route_name !== '#';
            });

        // Kelompokkan berdasarkan group
        $groupedMenus = $mainMenus
            ->groupBy('group')
            // Hapus group kosong (tidak ada menu valid)
            ->filter(function ($menus) {
                return $menus->isNotEmpty();
            });

        return view('admin.sidebar_menu.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'menus' => $allMenus, // Untuk halaman index
            'sidebarMenus' => $groupedMenus, // Untuk sidebar
            'total_SidebarMenu' => SidebarMenu::count(),
            'parents' => SidebarMenu::where('is_submenu', false)->get(),
            'list_menu' => SidebarMenu::where([['is_submenu', '=', false], ['route_name', '=', '#']])
                ->whereNull('icon')
                ->whereNull('group')
                ->whereNull('parent_id')
                ->get(),
            'listroles' => $listroles,
        ]);
    }

    public function indexAjaxSidebarMenu()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = SidebarMenu::with('parent')->orderBy('order', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.sidebar_menu.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->addColumn('parent_name', function ($row) {
                return $row->parent ? e($row->parent->title) : '<span style="font-style: italic; color: #888;">null</span>';
            })
            ->rawColumns(['parent_name'])
            ->make(true);
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
            'allMenus' => $allMenus,
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_submenu' => 'boolean',
            'parent_id' => 'nullable|integer|exists:sidebar_menus,id',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
        ]);
        if (empty($validated['route_name'])) {
            $validated['route_name'] = '#';
        }
        if (empty($validated['order'])) {
            $maxOrder = SidebarMenu::max('order');
            $validated['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }
        if (empty($validated['roles'])) {
            $validated['roles'] = '';
        }
        $validated['roles'] = $validated['roles'] ? implode(',', $validated['roles']) : null;
        SidebarMenu::create($validated);

        return response()->json(['success' => 'Berhasil menyimpan data']);
    }

    public function edit(string $id)
    {
        $data = SidebarMenu::where('id', $id)->first();

        // Pastikan field 'roles' bukan null atau kosong
        $roles = [];
        if (!empty($data->roles)) {
            $roles = explode(',', $data->roles); // Ubah string jadi array
        }

        // Ganti isi roles dari string jadi array sebelum dikirim ke JS
        $result = $data->toArray();
        $result['roles'] = $roles;
        // dd($result);

        return response()->json(['result' => $result]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_submenu' => 'boolean',
            'parent_id' => 'nullable|exists:sidebar_menus,id',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
        ]);
        if (empty($validated['order'])) {
            $maxOrder = SidebarMenu::max('order');
            $validated['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }
        $validated['roles'] = $validated['roles'] ? implode(',', $validated['roles']) : null;

        SidebarMenu::where('id', $id)->update($validated);

        return response()->json(['success' => 'Berhasil memperbarui data sdbrmn']);
    }

    public function destroy(string $id)
    {
        SidebarMenu::where('id', $id)->delete();
    }

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('sidebar_menus')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
