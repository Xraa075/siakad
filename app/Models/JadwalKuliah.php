<?php
// app/Models/JadwalKuliah.php (atau Jadwalkuliah.php)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    // Jika nama tabel Anda adalah 'jadwal_kuliahs' (plural dari JadwalKuliah),
    // Anda tidak perlu mendefinisikan $table secara eksplisit.
    // Jika nama tabelnya 'jadwal_kuliah', maka:
    // protected $table = 'jadwal_kuliah';

    protected $fillable = [
        'nama_jadwal',
    ];

    public function jadwalMatakuliahs()
    {
        return $this->hasMany(JadwalMatakuliah::class, 'jadwal_kuliah_id', 'id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jadwal_kuliah_id', 'id');
    }
}
