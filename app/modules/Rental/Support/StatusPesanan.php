<?php

namespace Modules\Rental\Support;

use Modules\Booking\Models\Pemesanan;

class StatusPesanan
{
    public const TAB = ['akan-datang', 'disewa', 'selesai'];

    /**
     * Tahapan pesanan dari sudut pandang toko rental.
     *
     * @return array{kode: string, label: string, tone: string, catatan: string}
     */
    public static function tahap(Pemesanan $pesanan): array
    {
        if ($pesanan->status === 'completed') {
            return [
                'kode' => 'selesai',
                'label' => 'Selesai',
                'tone' => 'slate',
                'catatan' => 'Alat sudah kembali ke toko.',
            ];
        }

        if (in_array($pesanan->status, ['expired', 'cancelled'], true)) {
            return [
                'kode' => 'batal',
                'label' => 'Dibatalkan',
                'tone' => 'red',
                'catatan' => 'Pesanan tidak dilanjutkan.',
            ];
        }

        if ($pesanan->status === 'pending') {
            return [
                'kode' => 'menunggu-bayar',
                'label' => 'Menunggu Pembayaran',
                'tone' => 'amber',
                'catatan' => 'Belum ada pembayaran masuk.',
            ];
        }

        if ($pesanan->waktu_serah_terima === null) {
            return [
                'kode' => 'siap-diserahkan',
                'label' => 'Siap Diserahkan',
                'tone' => 'emerald',
                'catatan' => 'Siapkan alat lalu konfirmasi serah terima.',
            ];
        }

        if ($pesanan->tanggal_selesai->lt(today())) {
            return [
                'kode' => 'terlambat',
                'label' => 'Terlambat',
                'tone' => 'amber',
                'catatan' => 'Lewat tanggal kembali, segera hubungi pemesan.',
            ];
        }

        return [
            'kode' => 'disewa',
            'label' => 'Sedang Disewa',
            'tone' => 'sky',
            'catatan' => 'Alat sedang dibawa pendaki.',
        ];
    }

    /**
     * Tab pesanan tempat sebuah pesanan ditampilkan.
     */
    public static function tab(Pemesanan $pesanan): string
    {
        if (in_array($pesanan->status, ['completed', 'expired', 'cancelled'], true)) {
            return 'selesai';
        }

        return $pesanan->waktu_serah_terima === null ? 'akan-datang' : 'disewa';
    }
}
