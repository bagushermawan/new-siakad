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
        Kelas::create(['name' => 'MQS', 'event' => 'ini event kelas MQS']); //shifir baru belajar ngaji 0
        Kelas::create(['name' => '1 Ula', 'event' => 'ini event kelas 1 Ula']); //bisa ngaji (kitab2)
        Kelas::create(['name' => '2 Ula', 'event' => 'ini event kelas 2 Ula']);
        Kelas::create(['name' => '3 Ula', 'event' => 'ini event kelas 3 Ula']);
        Kelas::create(['name' => '4 Ula', 'event' => 'ini event kelas 4 Ula']);
        Kelas::create(['name' => '5 Ula', 'event' => 'ini event kelas 5 Ula']);
        Kelas::create(['name' => '1 Wustho', 'event' => 'ini event kelas 1 Wustho']); //kitab kuning
        Kelas::create(['name' => '2 Wustho', 'event' => 'ini event kelas 2 Wustho']);
    }
}
