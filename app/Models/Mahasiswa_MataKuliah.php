<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;

class Mahasiswa_MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_matakuliah';
    protected $fillable = [
        'mhs_id',
        'mk_id',
        'nilai',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class);
    }
}
