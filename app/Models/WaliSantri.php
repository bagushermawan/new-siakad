<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class WaliSantri extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'wali_santris';
    protected $guard_name = "web";
    protected $user_type;

    protected $fillable = [
        'santri_id',
        'nik',
        'name',
        'username',
        'tanggal_lahir',
        'alamat',
        'nohp',
        'email',
        'password',
        'last_login',
        'foto_user',
    ];

    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function riwayatLogins()
    {
        return $this->hasMany(RiwayatLogin::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
