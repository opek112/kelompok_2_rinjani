<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Models\Pemesanan;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'nominal' => 'float',
            'kedaluwarsa_pada' => 'datetime',
            'dibayar_pada' => 'datetime',
        ];
    }

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
