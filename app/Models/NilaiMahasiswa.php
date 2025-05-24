<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_nrp', // [cite: 15]
        'matakuliah_id', // [cite: 15]
        'dosen_nip', // [cite: 15]
        'nilai_uts', // [cite: 15]
        'nilai_uas', // [cite: 15]
        'nilai_tugas', // [cite: 15]
        'nilai_akhir', // [cite: 15]
        'grade', // [cite: 15]
        'semester', // [cite: 15]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nilai_mahasiswas';


    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }

    // Relasi ke Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    // Relasi ke Dosen yang menginput nilai
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'nip');
    }
}
