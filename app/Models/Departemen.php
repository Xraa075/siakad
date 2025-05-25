<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_departemen',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departemens';


    public function jurusans()
    {
        return $this->hasMany(Jurusan::class, 'departemen_id', 'id');
    }
}
