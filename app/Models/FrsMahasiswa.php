<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrsMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_nrp', // [cite: 7]
        'matakuliah_id', // [cite: 7]
        'semester', // [cite: 7]
        'status', // [cite: 7]
        'tanggal_pengajuan', // [cite: 7]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frs_mahasiswas';


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
}
