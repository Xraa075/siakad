<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'user_id',
        'nama',
        'email_kontak',
        'jurusan_id',
        'no_telp',
        'isDosenWali',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dosens';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'dosen_nip', 'nip');
    }

    public function matakuliahPJMK()
    {
        return $this->hasMany(Matakuliah::class, 'dosen_nip', 'nip');
    }

    // Nilai yang diinput oleh dosen ini
    public function nilaiMahasiswas()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'dosen_nip', 'nip');
    }
}
