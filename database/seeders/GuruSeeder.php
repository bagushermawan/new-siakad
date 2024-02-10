<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
use App\Models\User;

class GuruSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {
        $guruData = [
            'Qoimuddin',
            'Fatturozi S.PD.I',
            'Haji Hamidin Numariz Al-Hafid',
            'Muhammad Toyyib',
            'Muhammad Mundir S.Si',
            'Hasim Syafi\'i S.PD.I',
            'Ikhwana S.PD.I',
            'Muhammad Syahri S.PD.I',
            'Jamil Fuadi S.Ag',
            'Habib Syaiful Rohman Al-Hadad M.HI',
            'Abdul Mujib S.Ei',
            'Ustad Shofiuddin',
            'Ustadzah Syarifah S.PD',
            'Ustad Abdul Aziz',
            'Ustadzah Dinah Fahiroh',
            'Ustad Samsul Arifin S.PD',
            'Ustad Khusairi',
        ];

        foreach ($guruData as $namaGuru) {
            $namaGuruTanpaTitik = str_replace('.', '', $namaGuru);
            $username = strtolower(str_replace(' ', '', $namaGuruTanpaTitik));
            $email = $username . '@gmail.com';
            $nuptk = $this->faker->numerify('################');
            $nohp = $this->faker->numerify('###########');
            $tanggal_lahir = $this->faker->dateTimeBetween('-80 years', '-42 years')->format('Y-m-d');

            $guru = User::create([
                'nuptk' => $nuptk,
                'name' => $namaGuru,
                'username' => $username,
                'tanggal_lahir' => $tanggal_lahir,
                'nohp' => $nohp,
                'email' => $email,
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now(),
            ]);

            // Assuming you are using Spatie's Laravel Permission package
            $guru->assignRole('guru');
        }
    }
}
