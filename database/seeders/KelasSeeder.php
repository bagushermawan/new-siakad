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
        Kelas::create(['name' => '1A', 'event' => 'ini event kelas 1A']);
        Kelas::create(['name' => '1B', 'event' => 'ini event kelas 1b']);
        Kelas::create(['name' => '2A', 'event' => 'ini event kelas 2A']);
        Kelas::create(['name' => '2B', 'event' => 'ini event kelas 2b']);
        Kelas::create(['name' => '3A', 'event' => 'ini event kelas 3A']);
        Kelas::create(['name' => '3B', 'event' => 'ini event kelas 3b']);
        Kelas::create(['name' => '4A', 'event' => 'ini event kelas 4A']);
        Kelas::create(['name' => '4B', 'event' => 'ini event kelas 4b']);
        Kelas::create(['name' => '5A', 'event' => 'ini event kelas 5A']);
        Kelas::create(['name' => '5B', 'event' => 'ini event kelas 5b']);
        Kelas::create(['name' => '6A', 'event' => 'ini event kelas 6a']);
        Kelas::create(['name' => '6B', 'event' => 'ini event kelas 6b']);
    }
}
