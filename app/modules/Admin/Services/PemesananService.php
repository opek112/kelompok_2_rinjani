<?php

namespace Modules\Admin\Services;
use Modules\Payment\Models\Pembayaran;
use Modules\Booking\Models\Pemesanan;

use Illuminate\Support\Facades\DB;

class PemesananService
{
    public function tandaiLunas(Pembayaran $pembayaran)
    {
        DB::transaction(function () use ($pembayaran) {
            // 1. Ubah status pesanan menjadi paid
            $pemesanan = $pembayaran->pemesanan;
            $pemesanan->update(['status' => 'paid']);

            // 2. Ubah status pembayaran menjadi settlement (jika belum)
            $pembayaran->update(['status_pembayaran' => 'settlement', 'dibayar_pada' => now()]);

            // 3. Kunci jadwal pemandu (contoh logika sederhana)
            // Nanti bisa ditambahkan query ke tabel ketersediaan_pemandu

            // 4. Potong stok rental (contoh logika sederhana)
            // Nanti bisa ditambahkan query ke tabel peralatan

            // 5. E-Voucher otomatis aktif (bisa dengan mengubah status atau generate QR)
        });
    }
}
