<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_matakuliah', // [cite: 13]
        'dosen_nip',       // Dosen PJMK (Penanggung Jawab Mata Kuliah) [cite: 13]
        'jurusan_id', // [cite: 13]
        'semester', // [cite: 13]
        'sks', // [cite: 13]
    ];
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matakuliahs';


    // Relasi ke Dosen (PJMK)
    public function dosenPJMK()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // Relasi ke FRS Mahasiswa yang mengambil matakuliah ini
    public function frsMahasiswas()
    {
        return $this->hasMany(FrsMahasiswa::class, 'matakuliah_id', 'id');
    }

    // Relasi ke Jadwal Matakuliah
    public function detailJadwalMatakuliah()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'matakuliah_id', 'id');
    }

    // Relasi ke Nilai Mahasiswa untuk matakuliah ini
    public function nilaiMahasiswas()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'matakuliah_id', 'id');
    }
}
