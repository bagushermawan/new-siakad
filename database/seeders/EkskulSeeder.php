<?php

namespace Database\Seeders;

use App\Models\Ekskul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkskulSeeder extends Seeder
{

    public function run(): void
    {
        Ekskul::create(['name' => 'Pramuka']);
        Ekskul::create(['name' => 'Pekan Olahraga']);
        Ekskul::create(['name' => 'Organisasi Santri']);
        Ekskul::create(['name' => 'Keterampilan Keputrian']);
        Ekskul::create(['name' => 'Seni dan Keterampilan']);
    }
}
