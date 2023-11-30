<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
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


        $guru = User::create([
            'name' => 'guru',
            'username' => 'guru',
            'email' => 'guru@guru.com',
            'password' => bcrypt('guru'),
            'email_verified_at' => Carbon::now()
        ]);
        

        $guru->assignRole('guru');
    }
}
