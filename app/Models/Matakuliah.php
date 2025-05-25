<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_matakuliah',
        'dosen_nip',
        'jurusan_id',
        'semester',
        'sks',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matakuliahs';


    public function dosenPJMK()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function frsMahasiswas()
    {
        return $this->hasMany(FrsMahasiswa::class, 'matakuliah_id', 'id');
    }

    public function detailJadwalMatakuliah()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'matakuliah_id', 'id');
    }

    public function nilaiMahasiswas()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'matakuliah_id', 'id');
    }
}
