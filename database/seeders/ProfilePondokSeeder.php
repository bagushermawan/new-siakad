<?php

namespace Database\Seeders;

use App\Models\ProfilePondok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilePondokSeeder extends Seeder
{
    public function run(): void
    {
        ProfilePondok::create([
            'nama_pondok' => 'Darunnajah',
            'kepala_pondok' => 'headddd',
        ]);
    }
}
