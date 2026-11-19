<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Booking\Models\Pemesanan;
use Modules\Payment\Models\Pembayaran;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;

class RentalPartnerDemoSeeder extends Seeder
{
    public function run(): void
    {
        $toko = TokoRental::query()->where('nama_toko', 'Rinjani Outdoor')->first();

        if ($toko === null) {
            return;
        }

        $tambahan = [
            ['nama' => 'Matras Gulung Foam', 'kategori' => 'Matras', 'tarif' => 15000, 'stok' => 25],
            ['nama' => 'Alat Masak Portable', 'kategori' => 'Alat Masak', 'tarif' => 30000, 'stok' => 8],
            ['nama' => 'Carrier 60L Expedition', 'kategori' => 'Carrier', 'tarif' => 50000, 'stok' => 10],
        ];

        foreach ($tambahan as $item) {
            Peralatan::updateOrCreate(
                ['nama' => $item['nama'], 'toko_rental_id' => $toko->id],
                [
                    'kategori' => $item['kategori'],
                    'pos' => 'Sembalun',
                    'deskripsi' => 'Perlengkapan andalan Rinjani Outdoor, dicek kelengkapannya sebelum diserahkan.',
                    'tarif_harian' => $item['tarif'],
                    'jumlah_stok' => $item['stok'],
                    'rating' => 4.8,
                    'jumlah_ulasan' => 12,
                    'sorotan' => false,
                ],
            );
        }

        $pesananContoh = [
            [
                'kode' => 'RJN-2026-0101',
                'nama' => 'Andi Pratama',
                'email' => 'andi.pratama@example.com',
                'telepon' => '081234567890',
                'mulai' => today()->addDays(2),
                'hari' => 3,
                'status' => 'paid',
                'serah_terima' => null,
                'alat' => [['Tenda Dome 4P', 2], ['Sleeping Bag', 2]],
            ],
            [
                'kode' => 'RJN-2026-0102',
                'nama' => 'Sarah Wijaya',
                'email' => 'sarah.wijaya@example.com',
                'telepon' => '081398765432',
                'mulai' => today()->subDay(),
                'hari' => 4,
                'status' => 'paid',
                'serah_terima' => now()->subDay(),
                'alat' => [['Matras Gulung Foam', 3], ['Carrier 60L Expedition', 1]],
            ],
            [
                'kode' => 'RJN-2026-0103',
                'nama' => 'Budi Hartono',
                'email' => 'budi.hartono@example.com',
                'telepon' => '081211112222',
                'mulai' => today()->subDays(10),
                'hari' => 3,
                'status' => 'completed',
                'serah_terima' => now()->subDays(10),
                'alat' => [['Alat Masak Portable', 2]],
            ],
        ];

        foreach ($pesananContoh as $data) {
            $mulai = $data['mulai'];
            $selesai = $mulai->copy()->addDays($data['hari'] - 1);

            $subtotal = 0;

            foreach ($data['alat'] as [$nama, $jumlah]) {
                $alat = Peralatan::query()
                    ->where('toko_rental_id', $toko->id)
                    ->where('nama', $nama)
                    ->first();

                if ($alat !== null) {
                    $subtotal += $alat->tarif_harian * $jumlah * $data['hari'];
                }
            }

            $pesanan = Pemesanan::updateOrCreate(
                ['kode_pemesanan' => $data['kode']],
                [
                    'nama_ketua' => $data['nama'],
                    'email_ketua' => $data['email'],
                    'telepon_ketua' => $data['telepon'],
                    'nik_ketua' => '5201'.str_pad((string) random_int(0, 999999999999), 12, '0', STR_PAD_LEFT),
                    'tanggal_mulai' => $mulai->toDateString(),
                    'tanggal_selesai' => $selesai->toDateString(),
                    'total_hari' => $data['hari'],
                    'total_tagihan' => $subtotal + 5000,
                    'status' => $data['status'],
                    'waktu_serah_terima' => $data['serah_terima'],
                ],
            );

            ItemPemesanan::query()->where('pemesanan_id', $pesanan->id)->delete();

            foreach ($data['alat'] as [$nama, $jumlah]) {
                $alat = Peralatan::query()
                    ->where('toko_rental_id', $toko->id)
                    ->where('nama', $nama)
                    ->first();

                if ($alat === null) {
                    continue;
                }

                $pesanan->items()->create([
                    'peralatan_id' => $alat->id,
                    'jumlah' => $jumlah,
                    'tarif_per_hari_snapshot' => $alat->tarif_harian,
                    'subtotal' => $alat->tarif_harian * $jumlah * $data['hari'],
                ]);
            }

            Pembayaran::updateOrCreate(
                ['pemesanan_id' => $pesanan->id],
                [
                    'referensi_pembayaran' => 'TRX-'.$data['kode'],
                    'nominal' => $pesanan->total_tagihan,
                    'status_pembayaran' => $data['status'] === 'paid' || $data['status'] === 'completed' ? 'settlement' : 'pending',
                    'kedaluwarsa_pada' => $mulai->copy()->subDay()->endOfDay(),
                    'dibayar_pada' => $data['status'] === 'paid' || $data['status'] === 'completed' ? $mulai->copy()->subDay() : null,
                ],
            );
        }
    }
}
