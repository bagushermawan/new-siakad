<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\WaliSantri;


class WaliSantriFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $santri_ids = User::whereHas('roles', function ($query) {$query->where('name', 'user');})->pluck('id')->toArray();
        $santri_id = $this->faker->randomElement($santri_ids);
        $name = $this->faker->name();
        $nohp = $this->faker->numerify('############');
        $email = $this->faker->unique()->safeEmail;
        $username = $this->faker->unique()->name;
        $tanggal_lahir = $this->faker->dateTimeBetween('-80 years', '-42 years')->format('Y-m-d');

        // Membuat user baru
        $wali = WaliSantri::create([
            'santri_id' => $santri_id,
            'name' => $name,
            'nohp' => $nohp,
            'email' => $email,
            'username' => $username,
            'tanggal_lahir' => $tanggal_lahir,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);

        $wali->assignRole('wali santri');

        return [
            'santri_id' => $wali->santri_id,
            'name' => $wali->name,
            'nohp' => $wali->nohp,
            'username' => $wali->username,
            'tanggal_lahir' => $wali->tanggal_lahir,
            'email' => $wali->email,
            'email_verified_at' => $wali->email_verified_at,
            'password' => $wali->password,
            'remember_token' => $wali->remember_token,
        ];
    }
}
