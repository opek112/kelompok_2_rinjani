<?php

namespace Modules\\Guide\Models;

use Illuminate\Database\Eloquent\Model;

class Pemandu extends Model
{
    protected $table = 'pemandu';

    protected $guarded = ['id'];

    // Relasi ke User (Pemandu ini milik User siapa?)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
