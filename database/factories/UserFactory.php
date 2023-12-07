<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;



    public function definition(): array
    {

        $name = $this->faker->name();
        $nisn = $this->faker->numerify('##########');
        $nuptk = $this->faker->numerify('################');
        $nohp = $this->faker->numerify('############');
        $nameParts = explode(' ', $name);
        $randomString = Str::random(1);
        // $email = strtolower(str_replace(' ', '.', $name)) . '_' . $randomString . '@mail.com';
        $email = $this->faker->unique()->safeEmail;
        $username = $this->faker->unique()->name;
        $kelas_id= $this->faker->numberBetween(1, 10);

        // Membuat user baru
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'nisn' => $nisn,
            'nuptk' => $nuptk,
            'nohp' => $nohp,
            'email' => $email,
            // 'kelas_id' => $kelas_id,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);

        // Ganti role disini
        $user->assignRole('guru');

        return [
            'name' => $user->name,
            'username' => $user->username,
            'nisn' => $user->nisn,
            'nuptk' => $user->nuptk,
            'nohp' => $user->nohp,
            'username' => $user->username,
            'email' => $user->email,
            // 'kelas_id' => $user->kelas_id,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
        ];
    }


    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
