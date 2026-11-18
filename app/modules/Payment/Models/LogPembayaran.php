<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class LogPembayaran extends Model
{
    protected $table = 'log_pembayaran';

    protected $guarded = ['id'];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }
}
