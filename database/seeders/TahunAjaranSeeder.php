<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunAjaran::create(['tahun' => '2021-2022']);
        TahunAjaran::create(['tahun' => '2022-2023']);
        TahunAjaran::create(['tahun' => '2023-2024']);
        TahunAjaran::create(['tahun' => '2023-2024']);
    }
}
