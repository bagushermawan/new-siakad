<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $table = "users";
    protected $user_type;
    protected $fillable = [
        'name',
        'nisn',
        'nuptk',
        'nohp',
        'username',
        'tanggal_lahir',
        'email',
        'password',
        'kelas_id',
        'email_verified_at',
        'last_login',
        'foto_user',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function waliSantri()
    {
        return $this->hasOne(WaliSantri::class, 'santri_id');
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
