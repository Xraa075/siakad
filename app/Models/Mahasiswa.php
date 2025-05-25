<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nrp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nrp',
        'user_id',
        'nama',
        'email_kontak',
        'kelas_id',
        'semester',
        'no_telp',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswas';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function frs()
    {
        return $this->hasMany(FrsMahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }

    public function nilai()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }
}
