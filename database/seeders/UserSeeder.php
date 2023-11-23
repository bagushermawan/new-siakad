<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::create([
        //     'name' => 'her',
        //     'username' => 'her',
        //     'email' => 'her@her.com',
        //     'password' => bcrypt('her')
        // ]);
        // $admin->assignRole('admin');


        $penulis = User::create([
            'name' => 'penulis',
            'username' => 'penulis',
            'email' => 'penulis@penulis.com',
            'password' => bcrypt('penulis'),
            'email_verified_at' => Carbon::now()
        ]);

        $penulis->assignRole('penulis');
    }
}
