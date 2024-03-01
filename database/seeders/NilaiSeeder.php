<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nilai;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        // Sesuaikan jumlah data yang ingin Anda hasilkan
        $jumlahData = 1000;

        // Memanggil factory dan membuat data sebanyak $jumlahData
        Nilai::factory($jumlahData)->create();
    }
}
