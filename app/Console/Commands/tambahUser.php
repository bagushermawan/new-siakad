<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;


class tambahUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tambah:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah tambah user melalui artisan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input['name']=$this->ask('Masukkan nama');
        $input['username']=$this->ask('Masukkan username');
        $input['email']=$this->ask('Masukkan email');
        $input['password']=$this->secret('Masukkan password');
        $input['password']=Hash::make($input['password']);
        $input['email_verified_at'] = Carbon::now();
        $user = User::create($input);
        $user->assignRole('admin');
        $this->info('Perintah tambah user selesai');
    }
}
