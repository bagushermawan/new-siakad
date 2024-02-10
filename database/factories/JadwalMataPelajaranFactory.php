<?php

namespace Database\Factories;

use App\Models\Ekskul;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\JadwalMataPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;


class JadwalMataPelajaranFactory extends Factory
{
    protected $model = JadwalMataPelajaran::class;

    public function definition(): array
    {
        $kelasId = Kelas::inRandomOrder()->first()->id;
        $tahunAjaranId = TahunAjaran::inRandomOrder()->first()->id;

        // Mendapatkan ID ekskul untuk jadwal ekskul pada hari Sabtu
        $ekskulId = null;
        $hari = $this->faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
        if ($hari === 'Sabtu') {
            $ekskulId = Ekskul::inRandomOrder()->first()->id;
        } else {
            // Mendapatkan ID mata pelajaran untuk jadwal mata pelajaran pada hari Senin-Jumat
            $mataPelajaranId = MataPelajaran::inRandomOrder()->first()->id;
        }

        return [
            'kelas_id' => $kelasId,
            'mata_pelajaran_id' => $mataPelajaranId ?? null,
            'ekskul_id' => $ekskulId,
            'hari' => $hari,
            'jam' => $this->faker->dateTimeBetween('07:00', '13:00')->format('H:00'),
            'tahun_ajaran_id' => $tahunAjaranId,
        ];
    }
}
