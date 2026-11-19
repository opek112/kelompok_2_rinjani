<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Rental\Models\PengembalianPeralatan;
use Modules\Rental\Models\Peralatan;

class ItemPemesanan extends Model
{
    protected $table = 'item_pemesanan';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tarif_per_hari_snapshot' => 'float',
            'subtotal' => 'float',
        ];
    }

    public function peralatan(): BelongsTo
    {
        return $this->belongsTo(Peralatan::class, 'peralatan_id');
    }

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(PengembalianPeralatan::class, 'item_pemesanan_id');
    }
}
