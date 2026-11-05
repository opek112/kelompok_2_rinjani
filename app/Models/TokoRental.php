<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokoRental extends Model
{
    protected $table = 'toko_rental';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
