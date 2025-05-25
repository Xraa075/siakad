<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
        'dosen_nip',
        'semester',
        'jadwal_kuliah_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas';


    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }


    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_kuliah_id', 'id');
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id', 'id');
    }
}
