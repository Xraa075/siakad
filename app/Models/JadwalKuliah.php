<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jadwal',
    ];

    public function jadwalMatakuliahs()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'jadwal_kuliah_id', 'id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jadwal_kuliah_id', 'id');
    }
}
