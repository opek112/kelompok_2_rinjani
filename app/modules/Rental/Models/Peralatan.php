<?php

namespace Modules\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peralatan extends Model
{
    protected $table = 'peralatan';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tarif_harian' => 'float',
            'rating' => 'float',
            'galeri' => 'array',
            'sorotan' => 'boolean',
        ];
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(TokoRental::class, 'toko_rental_id');
    }

    /**
     * Foto utama alat. Galeri diisi dari seeder, dengan foto kategori sebagai cadangan.
     */
    public function fotoUtama(): string
    {
        return $this->path_gambar ?: $this->fotoKategori();
    }

    /**
     * @return array<int, string>
     */
    public function galeriFoto(): array
    {
        $galeri = collect($this->galeri ?? [])
            ->filter()
            ->values()
            ->all();

        if ($galeri === []) {
            $galeri = [$this->fotoUtama()];
        }

        return $galeri;
    }

    public function fotoKategori(): string
    {
        return match ($this->kategori) {
            'Tenda' => 'https://images.unsplash.com/photo-1504280387966-2b87855d93af?q=80&w=900&auto=format&fit=crop',
            'Sleeping Bag' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=900&auto=format&fit=crop',
            'Matras' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=900&auto=format&fit=crop',
            'Alat Masak' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=900&auto=format&fit=crop',
            'Carrier' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=900&auto=format&fit=crop',
            default => 'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=900&auto=format&fit=crop',
        };
    }

    public function labelStok(): string
    {
        return $this->jumlah_stok.' unit';
    }
}
