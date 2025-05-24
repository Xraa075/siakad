<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMatakuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_kuliah_id', // [cite: 9]
        'matakuliah_id', // [cite: 9]
        'dosen_nip',          // Dosen Pengajar 1 [cite: 9]
        'dosen_pengajar2_nip', // [cite: 9]
        'hari', // [cite: 9]
        'jam_mulai', // [cite: 9]
        'jam_selesai', // [cite: 9]
        'ruangan', // [cite: 9]
        'semester', // [cite: 9]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_matakuliahs';


    // Relasi ke Jadwal Kuliah (Header)
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

    // Relasi ke Dosen Pengajar 2
    public function dosenPengajar2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pengajar2_nip', 'nip');
    }
}
