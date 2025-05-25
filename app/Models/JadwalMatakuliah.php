<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMatakuliah extends Model
{
    use HasFactory;

    // Jika nama tabel Anda 'jadwal_matakuliahs' atau 'jadwalmatakuliahs' (plural), tidak perlu $table.
    // Jika nama tabelnya 'jadwal_matakuliah', maka:
    // protected $table = 'jadwal_matakuliah';

    protected $fillable = [
        'jadwal_kuliah_id',
        'matakuliah_id',
        'dosen_nip', // Dosen Pengajar 1
        'dosen_pengajar2_nip', // Dosen Pengajar 2 (opsional)
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'semester', // Semester pelaksanaan matakuliah ini dalam jadwal tersebut
    ];

    // Relasi ke JadwalKuliah (induk)
    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_kuliah_id', 'id');
    }

    // Relasi ke Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    // Relasi ke Dosen Pengajar 1
    public function dosenPengajar1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    // Relasi ke Dosen Pengajar 2 (opsional)
    public function dosenPengajar2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pengajar2_nip', 'nip');
    }
}
