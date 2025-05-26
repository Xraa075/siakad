<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrsMahasiswa extends Model
{
    protected $table = 'frs_mahasiswas'; // pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'mahasiswa_nrp',
        'matakuliah_id',
        'semester',
        'status',
        'status_ambil',
        'tanggal_pengajuan',
        'available',
    ];

    // Relasi ke mahasiswa (NRP digunakan sebagai foreign key)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }

    // Relasi ke mata kuliah
    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
