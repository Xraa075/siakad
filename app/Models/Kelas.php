<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas', // [cite: 11]
        'jurusan_id', // [cite: 11]
        'dosen_nip',    // Dosen Wali [cite: 11]
        'semester', // [cite: 11]
        'jadwal_kuliah_id', // [cite: 11]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas';


    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // Relasi ke Dosen (Dosen Wali)
    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    // Relasi ke Jadwal Kuliah Umum
    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_kuliah_id', 'id');
    }

    // Relasi ke Mahasiswa dalam kelas ini
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id', 'id');
    }
}
