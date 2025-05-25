<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMatakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_kuliah_id',
        'matakuliah_id',
        'dosen_nip',
        'dosen_pengajar2_nip',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'semester',
    ];

    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_kuliah_id', 'id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    public function dosenPengajar1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    public function dosenPengajar2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pengajar2_nip', 'nip');
    }
}
