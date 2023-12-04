<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMataPelajaran extends Model
{
    use HasFactory;

    public $table = "jadwal_mata_pelajarans";
    protected $fillable = [
        'kelas_id',
        'mata_pelajaran_id',
        'hari',
        'jam',
        'tahun_ajaran_id',

    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
