<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatLogin extends Model
{
    use HasFactory;

    protected $table = 'riwayat_logins';
    protected $fillable = [
        'user_id',
        'wali_santri_id',
        'status_login'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waliSantri()
    {
        return $this->belongsTo(WaliSantri::class);
    }

}
