<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePondok extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pondok',
        'kepala_pondok',
        'alamat',
        'telepon',
        'email',
        'deskripsi',
        'visi_misi',
        'foto_pondok',
    ];
}
