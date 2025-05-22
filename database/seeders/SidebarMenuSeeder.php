<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SidebarMenu;

class SidebarMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Group: Menu
        SidebarMenu::create([
            'title' => 'Menu',
            'route_name' => '#',
            'icon' => null,
            'group' => null,
            'order' => 0,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        // Dashboard menu
        SidebarMenu::create([
            'title' => 'Dashboard',
            'route_name' => 'admin.dashboard',
            'icon' => 'bi bi-grid-fill',
            'group' => 'Menu',
            'order' => 1,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => 'admin,guru',
        ]);

        // Group: Pages
        SidebarMenu::create([
            'title' => 'Pages',
            'route_name' => '#',
            'icon' => null,
            'group' => null,
            'order' => 1,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        // Users parent menu under Pages
        $usersParent = SidebarMenu::create([
            'title' => 'Users',
            'route_name' => '#',
            'icon' => 'bi bi-people-fill',
            'group' => 'Pages',
            'order' => 2,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => 'admin,guru',
        ]);

        // Submenus for Users
        SidebarMenu::insert([
            [
                'title' => 'All Users',
                'route_name' => 'admin.user.index',
                'icon' => null,
                'group' => null,
                'order' => 1,
                'is_submenu' => true,
                'parent_id' => $usersParent->id,
                'roles' => 'admin',
            ],
            [
                'title' => 'Guru',
                'route_name' => 'guru.index',
                'icon' => null,
                'group' => null,
                'order' => 2,
                'is_submenu' => true,
                'parent_id' => $usersParent->id,
                'roles' => 'admin,guru',
            ],
            [
                'title' => 'Santri',
                'route_name' => 'siswa.index',
                'icon' => null,
                'group' => null,
                'order' => 3,
                'is_submenu' => true,
                'parent_id' => $usersParent->id,
                'roles' => 'admin,guru',
            ],
            [
                'title' => 'Wali Santri',
                'route_name' => 'wali.index',
                'icon' => null,
                'group' => null,
                'order' => 4,
                'is_submenu' => true,
                'parent_id' => $usersParent->id,
                'roles' => 'admin',
            ],
        ]);

        // Other individual pages
        SidebarMenu::create([
            'title' => 'Prestasi',
            'route_name' => 'prestasi.index',
            'icon' => 'bi bi-award-fill',
            'group' => 'Pages',
            'order' => 3,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        SidebarMenu::create([
            'title' => 'Kelas',
            'route_name' => 'kelas.index',
            'icon' => 'bi bi-person-video2',
            'group' => 'Pages',
            'order' => 4,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        // Pelajaran parent menu
        $pelajaranParent = SidebarMenu::create([
            'title' => 'Pelajaran',
            'route_name' => '#',
            'icon' => 'bi bi-book-half',
            'group' => 'Pages',
            'order' => 5,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        // Submenus Pelajaran
        SidebarMenu::insert([
            [
                'title' => 'Ekstrakulikuler',
                'route_name' => 'ekskul.index',
                'icon' => null,
                'group' => null,
                'order' => 1,
                'is_submenu' => true,
                'parent_id' => $pelajaranParent->id,
                'roles' => null,
            ],
            [
                'title' => 'Mata Pelajaran',
                'route_name' => 'matapelajaran.index',
                'icon' => null,
                'group' => null,
                'order' => 2,
                'is_submenu' => true,
                'parent_id' => $pelajaranParent->id,
                'roles' => null,
            ],
            [
                'title' => 'Jadwal Mata Pelajaran',
                'route_name' => 'jadwalmatapelajaran.index',
                'icon' => null,
                'group' => null,
                'order' => 3,
                'is_submenu' => true,
                'parent_id' => $pelajaranParent->id,
                'roles' => null,
            ],
            [
                'title' => 'Tahun Ajaran',
                'route_name' => 'tahunajaran.index',
                'icon' => null,
                'group' => null,
                'order' => 4,
                'is_submenu' => true,
                'parent_id' => $pelajaranParent->id,
                'roles' => null,
            ],
        ]);

        SidebarMenu::create([
            'title' => 'Nilai',
            'route_name' => 'nilai.index',
            'icon' => 'bi bi-list-ol',
            'group' => 'Pages',
            'order' => 6,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => null,
        ]);

        // Group: Administrator
        SidebarMenu::create([
            'title' => 'Administrator',
            'route_name' => '#',
            'icon' => null,
            'group' => null,
            'order' => 1,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => 'admin',
        ]);

        SidebarMenu::create([
            'title' => 'Profile Pondok',
            'route_name' => 'profilepondok.index',
            'icon' => 'fas fa-school',
            'group' => 'Administrator',
            'order' => 2,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => 'admin',
        ]);

        // Roles & Permission parent menu
        $rolesParent = SidebarMenu::create([
            'title' => 'Roles & Permission',
            'route_name' => '#',
            'icon' => 'bi bi-key-fill',
            'group' => 'Administrator',
            'order' => 3,
            'is_submenu' => false,
            'parent_id' => null,
            'roles' => 'admin',
        ]);

        // Submenus Roles & Permission
        SidebarMenu::insert([
            [
                'title' => 'Roles',
                'route_name' => 'role.index',
                'icon' => null,
                'group' => null,
                'order' => 1,
                'is_submenu' => true,
                'parent_id' => $rolesParent->id,
                'roles' => 'admin',
            ],
            [
                'title' => 'Permission',
                'route_name' => 'permission.index',
                'icon' => null,
                'group' => null,
                'order' => 2,
                'is_submenu' => true,
                'parent_id' => $rolesParent->id,
                'roles' => 'admin',
            ],
        ]);
    }
}
