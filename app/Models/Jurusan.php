<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jurusan', // [cite: 10]
        'departemen_id', // [cite: 10]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jurusans';


    // Relasi kembali ke Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }

    // Relasi ke Dosen
    public function dosens()
    {
        return $this->hasMany(Dosen::class, 'jurusan_id', 'id');
    }

    // Relasi ke Kelas
    public function kelas() // Menggunakan nama singular karena "kelas" bisa merujuk ke banyak kelas
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'id');
    }

    // Relasi ke Matakuliah
    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class, 'jurusan_id', 'id');
    }
}
