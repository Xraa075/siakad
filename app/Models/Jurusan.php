<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jurusan',
        'departemen_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jurusans';

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }

    public function dosens()
    {
        return $this->hasMany(Dosen::class, 'jurusan_id', 'id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'id');
    }

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class, 'jurusan_id', 'id');
    }
}
