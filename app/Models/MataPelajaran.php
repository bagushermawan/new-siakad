<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    public $table = "mata_pelajarans";
    protected $fillable = [
        'name',

    ];

    public function jadwalMataPelajaran()
    {
        return $this->hasMany(JadwalMataPelajaran::class, 'matapelajaran_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
