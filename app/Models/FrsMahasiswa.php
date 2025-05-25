<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrsMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_nrp',
        'matakuliah_id',
        'semester',
        'status',
        'tanggal_pengajuan',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frs_mahasiswas';


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }
}
