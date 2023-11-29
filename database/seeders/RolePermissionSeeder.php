<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'lihat-user']);
        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'hapus-user']);

        Permission::create(['name' => 'lihat-kelas']);
        Permission::create(['name' => 'tambah-kelas']);
        Permission::create(['name' => 'edit-kelas']);
        Permission::create(['name' => 'hapus-kelas']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'guru']);
        Role::create(['name' => 'user']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('lihat-user');
        $roleAdmin->givePermissionTo('tambah-user');
        $roleAdmin->givePermissionTo('edit-user');
        $roleAdmin->givePermissionTo('hapus-user');

        $rolePenulis = Role::findByName('guru');
        $rolePenulis->givePermissionTo('lihat-kelas');
        $rolePenulis->givePermissionTo('tambah-kelas');
        $rolePenulis->givePermissionTo('edit-kelas');
        $rolePenulis->givePermissionTo('hapus-kelas');
    }
}
