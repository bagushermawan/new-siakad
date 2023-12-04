<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            ['name' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['name' => 'Matematika'],
            ['name' => 'Bahasa Indonesia'],
            ['name' => 'Ilmu Pengetahuan Alam'],
            ['name' => 'Ilmu Pengetahuan Sosial'],
            ['name' => 'Bahasa Arab'],
            ['name' => 'Bahasa Inggris'],
            ['name' => "Al-Qur'an Hadits"],
            ['name' => 'Akidah Akhlah'],
            ['name' => 'Fiqih'],
            ['name' => 'Sejarah Kebudayaan Islam'],
            ['name' => 'Penjaskes'],
            ['name' => 'Seni Budaya dan Prakarya'],
            ['name' => 'Bahasa Jawa'],
            ['name' => 'Bahasa Inggris'],
            // ['name' => 'tes1'],
            // ['name' => 'tes2'],
            // ['name' => 'tes3'],
            // ['name' => 'tes4'],
            // ['name' => 'tes5'],
            // ['name' => 'tes6'],
            // ['name' => 'tes7'],
            // ['name' => 'tes8'],
            // ['name' => 'tes9'],
        ];

        foreach ($mapel as $mapels) {
            MataPelajaran::create($mapels);
        }
    }
}
