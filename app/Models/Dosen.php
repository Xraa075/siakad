<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip'; // [cite: 5]
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip', // [cite: 5]
        'user_id',
        'nama', // [cite: 5]
        'email_kontak', // Email kontak (bukan untuk login)
        'jurusan_id', // [cite: 5]
        'no_telp', // [cite: 5]
        'isDosenWali', // [cite: 5]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dosens';

    // Relasi kembali ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // Kelas di mana dosen ini menjadi dosen wali
    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'dosen_nip', 'nip');
    }

    // Matakuliah yang diampu sebagai Penanggung Jawab Mata Kuliah (PJMK)
    public function matakuliahsDiajar()
    {
        return $this->hasMany(Matakuliah::class, 'dosen_nip', 'nip');
    }

    // Jadwal di mana dosen ini mengajar sebagai dosen pengajar 1
    public function jadwalMengajarSebagaiPengajar1()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'dosen_nip', 'nip');
    }

    // Jadwal di mana dosen ini mengajar sebagai dosen pengajar 2
    public function jadwalMengajarSebagaiPengajar2()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'dosen_pengajar2_nip', 'nip');
    }

    // Nilai yang diinput oleh dosen ini
    public function nilaiMahasiswas()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'dosen_nip', 'nip');
    }
}
