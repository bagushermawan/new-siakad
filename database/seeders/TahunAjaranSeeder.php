<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            $startYear = $faker->numberBetween(2020, 2030);
            $endYear = $startYear + 1;

            DB::table('tahun_ajarans')->insert([
                'name' => "$startYear-$endYear",
                'semester' => $faker->randomElement(['Ganjil', 'Genap']),
                'mulai' => $faker->date,
                'selesai' => $faker->date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
