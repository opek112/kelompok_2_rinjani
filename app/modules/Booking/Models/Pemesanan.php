<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Guide\Models\Pemandu;
use Modules\Identity\Models\User;
use Modules\Payment\Models\Pembayaran;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'total_hari' => 'integer',
            'total_tagihan' => 'float',
            'kehadiran_pemandu_dikonfirmasi' => 'boolean',
            'waktu_serah_terima' => 'datetime',
            'waktu_konfirmasi_pemandu' => 'datetime',
        ];
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function pemandu()
    {
        return $this->belongsTo(Pemandu::class, 'pemandu_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemPemesanan::class, 'pemesanan_id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id');
    }
}
