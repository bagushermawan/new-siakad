<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models;
use App\Models\WaliSantri;

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
        $this->call(EkskulSeeder::class);
        $this->call(JadwalMataPelajaranSeeder::class);
        $this->call(ProfilePondokSeeder::class);
        $this->call(GuruSeeder::class);

        // User::factory(601)->create();
        // $this->call(NilaiSeeder::class);

    }
}
