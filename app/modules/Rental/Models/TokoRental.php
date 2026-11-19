<?php

namespace Modules\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Identity\Models\User;

class TokoRental extends Model
{
    protected $table = 'toko_rental';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'notifikasi' => 'array',
            'auto_tutup_kosong' => 'boolean',
            'tutup_hari_libur' => 'boolean',
            'aktif' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peralatan(): HasMany
    {
        return $this->hasMany(Peralatan::class, 'toko_rental_id');
    }

    public function inisial(): string
    {
        return mb_strtoupper(mb_substr($this->nama_toko ?? 'RT', 0, 2));
    }

    public function rekeningLengkap(): bool
    {
        return filled($this->nama_bank) && filled($this->nomor_rekening) && filled($this->nama_pemilik_rekening);
    }
}
