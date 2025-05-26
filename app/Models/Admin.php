<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username_admin',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
