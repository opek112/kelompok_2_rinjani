<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Payment\Models\Pembayaran;
use Modules\Booking\Models\Pemesanan;
use Carbon\Carbon;

class ExpirePendingOrders extends Command
{
    // Nama command yang akan dipanggil oleh scheduler
    protected $signature = 'orders:expire';

    // Deskripsi command
    protected $description = 'Mengubah status pesanan menjadi expired jika melewati batas waktu pembayaran (15 menit)';

    public function handle()
    {
        $this->info('Memulai pengecekan pesanan kadaluwarsa...');

        // 1. Cari pembayaran yang statusnya 'pending' dan sudah lewat waktu kedaluwarsa
        $pembayaranKedaluwarsa = Pembayaran::where('status_pembayaran', 'pending')
            ->where('kedaluwarsa_pada', '<', Carbon::now())
            ->get();

        if ($pembayaranKedaluwarsa->isEmpty()) {
            $this->info('Tidak ada pesanan yang kedaluwarsa.');
            return;
        }

        $count = 0;

        foreach ($pembayaranKedaluwarsa as $pembayaran) {
            // 2. Ubah status pembayaran menjadi 'expire'
            $pembayaran->update([
                'status_pembayaran' => 'expire',
            ]);

            // 3. Ubah status pemesanan terkait menjadi 'expired'
            $pemesanan = $pembayaran->pemesanan;
            if ($pemesanan) {
                $pemesanan->update([
                    'status' => 'expired',
                ]);

                // TODO: Di sini kamu bisa menambahkan logika untuk 
                // melepas slot pemandu (update tabel ketersediaan_pemandu)
                // dan mengembalikan stok rental jika ada.
            }

            $count++;
        }

        $this->info("Berhasil mengubah {$count} pesanan menjadi expired.");
    }
}