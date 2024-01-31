<?php

namespace Database\Seeders;

use App\Models\WaliSantri;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WaliSantriSeeder extends Seeder
{
    public function run(): void
    {
        WaliSantri::factory(22)->create();
    }
}
