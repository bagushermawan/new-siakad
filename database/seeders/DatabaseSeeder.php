<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TahunAjaranSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(MataPelajaranSeeder::class);
        $this->call(JadwalMataPelajaranSeeder::class);


        // User::factory(111)->create();
        // User::factory(15)->create();
    }
}
