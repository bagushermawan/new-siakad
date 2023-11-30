<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create(['name' => '1A']);
        Kelas::create(['name' => '1B']);
        Kelas::create(['name' => '2A']);
        Kelas::create(['name' => '2B']);
        Kelas::create(['name' => '3A']);
        Kelas::create(['name' => '3B']);
        Kelas::create(['name' => '4B']);
        Kelas::create(['name' => '4B']);
        Kelas::create(['name' => '5A']);
        Kelas::create(['name' => '5B']);
    }
}
