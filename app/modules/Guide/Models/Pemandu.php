<?php

namespace Modules\Guide\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;

class Pemandu extends Model
{
    protected $table = 'pemandu';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tarif_harian' => 'float',
        ];
    }

    // Relasi ke User (Pemandu ini milik User siapa?)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rutes(): HasMany
    {
        return $this->hasMany(RutePemandu::class, 'pemandu_id');
    }

    public function ketersediaan(): HasMany
    {
        return $this->hasMany(Ketersediaan::class, 'pemandu_id');
    }

    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'pemandu_id');
    }

    /**
     * Daftar bahasa disimpan sebagai teks dipisah koma.
     *
     * @return array<int, string>
     */
    public function bahasaList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->bahasa))));
    }

    /**
     * @return array<int, string>
     */
    public function ruteList(): array
    {
        return $this->rutes->pluck('rute')->all();
    }

    public function inisial(): string
    {
        $nama = trim((string) ($this->user->nama ?? 'Pemandu'));
        $kata = preg_split('/\s+/', $nama) ?: [];
        $inisial = '';

        foreach (array_slice($kata, 0, 2) as $bagian) {
            $inisial .= mb_strtoupper(mb_substr($bagian, 0, 1));
        }

        return $inisial !== '' ? $inisial : 'PM';
    }
}
