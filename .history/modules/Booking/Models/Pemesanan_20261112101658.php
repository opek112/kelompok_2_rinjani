<?php

namespace Modules\\Booking\\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function pemandu()
    {
        return $this->belongsTo(Pemandu::class, 'pemandu_id');
    }
}
