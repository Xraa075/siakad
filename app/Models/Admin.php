<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username_admin', // [cite: 1]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';


    // Relasi kembali ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
