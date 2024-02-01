<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kelas;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $this->faker = FakerFactory::create('id_ID');

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $name = "$firstName $lastName";
        $nisn = $this->faker->numerify('##########');
        $nuptk = $this->faker->numerify('################');
        $nohp = $this->faker->numerify('############');
        $nameParts = explode(' ', $name);
        $randomString = Str::random(1);
        $email = strtolower(str_replace(' ', '.', $name)) . '@gmail.com';
        $username = strtolower(str_replace(' ', '', $name));
        $kelas_ids = Kelas::pluck('id')->toArray();
        $kelas_id = $this->faker->randomElement($kelas_ids);

        // Membuat user baru
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'nisn' => $nisn,
            'nohp' => $nohp,
            'email' => $email,
            'kelas_id' => $kelas_id,
            'email_verified_at' => now(),
            'password' =>  Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);

        // Ganti role disini
        $user->assignRole('user');

        return [
            'name' => $user->name,
            'username' => $user->username,
            'nisn' => $user->nisn,
            'nohp' => $user->nohp,
            'email' => $user->email,
            'kelas_id' => $user->kelas_id,
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
