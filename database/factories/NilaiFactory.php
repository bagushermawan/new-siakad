<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Nilai;
use App\Models\User;

class NilaiFactory extends Factory
{
    protected $model = Nilai::class;

    public function definition(): array
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->inRandomOrder()
            ->first()->id;
        $mataPelajaranId = MataPelajaran::inRandomOrder()->first()->id;
        $kelas = Kelas::inRandomOrder()->first()->id;
        $tahunajaran = TahunAjaran::inRandomOrder()->first()->id;

        return [
            'user_id' => $user,
            'mata_pelajaran_id' => $mataPelajaranId,
            'kelas_id' => $kelas,
            'tahun_ajaran_id' => $tahunajaran,
            'nilai' => $this->faker->randomNumber(2, true),
        ];
    }
}
