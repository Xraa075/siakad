<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jadwal', // [cite: 8]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_kuliahs'; // Nama tabel eksplisit


    // Relasi ke Detail Jadwal Matakuliah
    public function detailJadwalMatakuliah()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'jadwal_kuliah_id', 'id');
    }

    // Relasi ke Kelas yang menggunakan jadwal ini
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jadwal_kuliah_id', 'id');
    }
}
