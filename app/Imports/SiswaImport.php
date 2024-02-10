<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Kelas;
use Faker\Factory as Faker;

class SiswaImport implements ToModel
{
    use HasRoles;
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function model(array $row)
    {
        $kelas_ids = Kelas::pluck('id')->toArray();
        $kelas_id = $this->faker->randomElement($kelas_ids);
        $user = new User([
            'nisn' => $row[0],
            'tanggal_lahir' => $row[1],
            'name' => $row[2],
            'username' => $row[3],
            'email' => $row[4],
            'nis' => $row[5],
            'kelas_id' => $kelas_id,
        ]);

        // Simpan user
        $user->save();

        // Setelah menyimpan user, berikan peran 'user'
        $user->assignRole('user');

        return $user;
    }
}
