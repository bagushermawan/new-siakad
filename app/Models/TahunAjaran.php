<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    public $table = "tahun_ajarans";
    protected $fillable = [
        'name',
        'semester',
        'mulai',
        'selesai',

    ];

    public function jadwalMataPelajaran()
    {
        return $this->hasMany(JadwalMataPelajaran::class, 'tahun_ajaran_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
