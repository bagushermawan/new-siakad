<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    public $table = "kelas";
    protected $fillable = [
        'name',
        'walikelas_id',

    ];


    // Relasi ke User untuk mendapatkan wali kelas
    public function walikelas()
    {
        return $this->belongsTo(User::class, 'walikelas_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
