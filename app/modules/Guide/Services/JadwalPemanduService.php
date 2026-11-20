<?php

namespace Modules\Guide\Services;

use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Ketersediaan;

class JadwalPemanduService
{
    /**
     * Kunci seluruh tanggal pesanan pada kalender pemandu.
     */
    public static function kunci(Pemesanan $pemesanan): void
    {
        if ($pemesanan->pemandu_id === null) {
            return;
        }

        for ($hari = $pemesanan->tanggal_mulai->copy(); $hari->lte($pemesanan->tanggal_selesai); $hari->addDay()) {
            Ketersediaan::updateOrCreate(
                ['pemandu_id' => $pemesanan->pemandu_id, 'tanggal' => $hari->toDateString()],
                ['status' => 'booked', 'pemesanan_id' => $pemesanan->id],
            );
        }
    }

    /**
     * Lepaskan tanggal yang sebelumnya dikunci pesanan ini.
     */
    public static function lepas(Pemesanan $pemesanan): void
    {
        Ketersediaan::query()
            ->where('pemesanan_id', $pemesanan->id)
            ->where('status', 'booked')
            ->update(['status' => 'available', 'pemesanan_id' => null]);
    }
}
