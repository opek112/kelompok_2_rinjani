<?php

namespace Modules\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Models\ItemPemesanan;

class PengembalianPeralatan extends Model
{
    protected $table = 'pengembalian_peralatan';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'jumlah_baik' => 'integer',
            'jumlah_rusak' => 'integer',
            'jumlah_hilang' => 'integer',
            'denda' => 'float',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemPemesanan::class, 'item_pemesanan_id');
    }

    public function jumlahKembali(): int
    {
        return $this->jumlah_baik + $this->jumlah_rusak + $this->jumlah_hilang;
    }
}
