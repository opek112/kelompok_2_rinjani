<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\PengaturanPlatform;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Ketersediaan;
use Modules\Guide\Models\Pemandu;
use Modules\Identity\Models\User;
use Modules\Payment\Models\Pembayaran;

class GuideDemoSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'guide@rinjaniguide.com',
                'no_telepon' => '081234500011',
                'nomor_lisensi' => 'APGI-2021-0187',
                'tarif_harian' => 450000,
                'bahasa' => ['Indonesia', 'Inggris'],
                'rute' => ['Sembalun', 'Senaru', 'Torean'],
                'bio' => 'Pemandu bersertifikat APGI dengan 8 tahun pengalaman mendampingi pendakian jalur Sembalun dan Senaru.',
                'status' => 'active',
                'nama_bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Budi Santoso',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.guide@rinjaniguide.com',
                'no_telepon' => '081234500022',
                'nomor_lisensi' => 'APGI-2022-0314',
                'tarif_harian' => 500000,
                'bahasa' => ['Indonesia', 'Inggris', 'Mandarin'],
                'rute' => ['Senaru', 'Sembalun'],
                'bio' => 'Spesialis jalur Senaru dengan pengalaman mendampingi rombongan keluarga dan pendaki pemula.',
                'status' => 'active',
                'nama_bank' => 'Mandiri',
                'nomor_rekening' => '9876543210',
                'nama_pemilik_rekening' => 'Siti Nurhaliza',
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.guide@rinjaniguide.com',
                'no_telepon' => '081234500033',
                'nomor_lisensi' => 'APGI-2023-0450',
                'tarif_harian' => 400000,
                'bahasa' => ['Indonesia'],
                'rute' => ['Torean', 'Sembalun'],
                'bio' => 'Pemandu muda spesialis jalur Torean, fokus pada keamanan dan logistik rombongan kecil.',
                'status' => 'active',
                'nama_bank' => 'BRI',
                'nomor_rekening' => '5556667778',
                'nama_pemilik_rekening' => 'Ahmad Fauzi',
            ],
            [
                'nama' => 'Hendra Gunawan',
                'email' => 'hendra.guide@rinjaniguide.com',
                'no_telepon' => '081234500044',
                'nomor_lisensi' => 'APGI-2026-0001',
                'tarif_harian' => 350000,
                'bahasa' => ['Indonesia'],
                'rute' => ['Sembalun'],
                'bio' => 'Calon pemandu yang sedang menunggu verifikasi admin RinjaniGuide.',
                'status' => 'pending',
                'nama_bank' => 'BNI',
                'nomor_rekening' => '1112223334',
                'nama_pemilik_rekening' => 'Hendra Gunawan',
            ],
        ];

        $utama = null;

        foreach ($daftar as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'no_telepon' => $data['no_telepon'],
                    'password' => Hash::make('password123'),
                    'peran' => 'guide',
                    'email_verified_at' => now(),
                ],
            );

            $user->forceFill(['email_verified_at' => now()])->save();

            $pemandu = Pemandu::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nomor_lisensi' => $data['nomor_lisensi'],
                    'bahasa' => implode(', ', $data['bahasa']),
                    'tarif_harian' => $data['tarif_harian'],
                    'bio' => $data['bio'],
                    'info_rekening_bank' => $data['nama_bank'].' - '.$data['nomor_rekening'].' - '.$data['nama_pemilik_rekening'],
                    'nama_bank' => $data['nama_bank'],
                    'nomor_rekening' => $data['nomor_rekening'],
                    'nama_pemilik_rekening' => $data['nama_pemilik_rekening'],
                    'status' => $data['status'],
                ],
            );

            $pemandu->rutes()->delete();

            foreach ($data['rute'] as $rute) {
                $pemandu->rutes()->create(['rute' => $rute]);
            }

            if ($pemandu->status === 'active') {
                $this->isiKetersediaan($pemandu);
                $utama = $utama ?? $pemandu;
            }
        }

        if ($utama !== null) {
            $this->buatPenugasan($utama);
        }
    }

    /**
     * Tandai kalender 30 hari ke depan: Minggu libur, sisanya tersedia.
     */
    private function isiKetersediaan(Pemandu $pemandu): void
    {
        for ($i = 0; $i < 30; $i++) {
            $tanggal = today()->addDays($i);

            Ketersediaan::updateOrCreate(
                ['pemandu_id' => $pemandu->id, 'tanggal' => $tanggal->toDateString()],
                [
                    'status' => $tanggal->isSunday() ? 'off' : 'available',
                    'pemesanan_id' => null,
                ],
            );
        }
    }

    /**
     * Penugasan contoh: satu menunggu serah terima, satu sedang berjalan, satu selesai.
     */
    private function buatPenugasan(Pemandu $pemandu): void
    {
        $contoh = [
            [
                'kode' => 'RJN-GUIDE-0001',
                'nama' => 'Andi Pratama',
                'email' => 'andi.pratama@example.com',
                'telepon' => '081234567890',
                'mulai' => today()->addDays(3),
                'hari' => 3,
                'status' => 'paid',
                'konfirmasi' => false,
            ],
            [
                'kode' => 'RJN-GUIDE-0002',
                'nama' => 'Sarah Wijaya',
                'email' => 'sarah.wijaya@example.com',
                'telepon' => '081398765432',
                'mulai' => today()->subDay(),
                'hari' => 3,
                'status' => 'paid',
                'konfirmasi' => true,
            ],
            [
                'kode' => 'RJN-GUIDE-0003',
                'nama' => 'Budi Hartono',
                'email' => 'budi.hartono@example.com',
                'telepon' => '081211112222',
                'mulai' => today()->subDays(20),
                'hari' => 3,
                'status' => 'completed',
                'konfirmasi' => true,
            ],
        ];

        $persen = PengaturanPlatform::getKomisi();

        foreach ($contoh as $data) {
            /** @var Carbon $mulai */
            $mulai = $data['mulai'];
            $selesai = $mulai->copy()->addDays($data['hari'] - 1);
            $biaya = (float) $pemandu->tarif_harian * $data['hari'];
            $komisi = round($biaya * $persen / 100, 2);

            $pesanan = Pemesanan::updateOrCreate(
                ['kode_pemesanan' => $data['kode']],
                [
                    'pemandu_id' => $pemandu->id,
                    'rute' => $pemandu->ruteList()[0] ?? 'Sembalun',
                    'nama_ketua' => $data['nama'],
                    'email_ketua' => $data['email'],
                    'telepon_ketua' => $data['telepon'],
                    'nik_ketua' => '5201'.str_pad((string) random_int(0, 999999999999), 12, '0', STR_PAD_LEFT),
                    'tanggal_mulai' => $mulai->toDateString(),
                    'tanggal_selesai' => $selesai->toDateString(),
                    'total_hari' => $data['hari'],
                    'biaya_pemandu_snapshot' => $biaya,
                    'persentase_komisi' => $persen,
                    'nominal_komisi' => $komisi,
                    'total_tagihan' => $biaya,
                    'status' => $data['status'],
                    'kehadiran_pemandu_dikonfirmasi' => $data['konfirmasi'],
                    'waktu_konfirmasi_pemandu' => $data['konfirmasi'] ? $mulai->copy()->startOfDay()->addHours(7) : null,
                    'waktu_serah_terima' => $data['konfirmasi'] ? $mulai->copy()->startOfDay()->addHours(7) : null,
                ],
            );

            Pembayaran::updateOrCreate(
                ['pemesanan_id' => $pesanan->id],
                [
                    'referensi_pembayaran' => 'TRX-'.$data['kode'],
                    'nominal' => $biaya,
                    'status_pembayaran' => 'settlement',
                    'kedaluwarsa_pada' => $mulai->copy()->subDay()->endOfDay(),
                    'dibayar_pada' => $mulai->copy()->subDay(),
                ],
            );

            for ($hari = $mulai->copy(); $hari->lte($selesai); $hari->addDay()) {
                Ketersediaan::updateOrCreate(
                    ['pemandu_id' => $pemandu->id, 'tanggal' => $hari->toDateString()],
                    ['status' => 'booked', 'pemesanan_id' => $pesanan->id],
                );
            }
        }
    }
}
