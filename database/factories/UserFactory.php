<?php

namespace Database\Factories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();
        $nameParts = explode(' ', $name);
        $randomString = Str::random(1);
        $email = strtolower(str_replace(' ', '.', $name)) . '_' . $randomString . '@mail.com';
        // Membuat user baru
        $user = User::create([
            'name' => $name,
            'username' => $nameParts[0] . $randomString, // Menggunakan bagian pertama dari nama sebagai username
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);

        // Menetapkan role 'user' untuk user yang baru dibuat
        $user->assignRole('user');

        return [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
