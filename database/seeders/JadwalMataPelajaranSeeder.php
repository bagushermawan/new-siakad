<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalMataPelajaran;

class JadwalMataPelajaranSeeder extends Seeder
{

    public function run(): void
    {
        // Sesuaikan jumlah data yang ingin Anda hasilkan
        $jumlahData = 50;

        // Memanggil factory dan membuat data sebanyak $jumlahData
        JadwalMataPelajaran::factory($jumlahData)->create();
    }
}
