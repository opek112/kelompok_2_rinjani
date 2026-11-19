<?php

namespace Modules\Rental\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;

/**
 * Notifikasi operasional toko rental yang diturunkan dari data pesanan,
 * stok, dan status toko. Status baca disimpan pada kolom notifikasi_dibaca.
 */
class NotifikasiToko
{
    /**
     * @return Collection<int, array{id: string, jenis: string, judul: string, pesan: string, waktu: Carbon, waktu_relatif: string, url: string, ikon: string, tone: string, label: string}>
     */
    public static function daftar(TokoRental $toko): Collection
    {
        $daftar = collect();

        $pesanan = Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->whereIn('status', ['paid', 'completed'])
            ->with(['items.peralatan'])
            ->latest('updated_at')
            ->take(12)
            ->get();

        foreach ($pesanan as $satu) {
            $labelPos = $satu->items
                ->map(fn ($item) => $item->peralatan?->pos)
                ->filter()
                ->first() ?: ($toko->lokasi_pos ?: 'Sembalun');

            if ($satu->status === 'paid' && $satu->waktu_serah_terima === null) {
                $daftar->push(self::buat(
                    id: 'pesanan-'.$satu->id,
                    jenis: 'pesanan',
                    judul: 'Pesanan Baru Masuk',
                    pesan: $satu->nama_ketua.' menyewa '.$satu->items->sum('jumlah').' unit alat untuk '
                        .$satu->tanggal_mulai->translatedFormat('d').'–'.$satu->tanggal_selesai->translatedFormat('d M Y').'. Segera siapkan.',
                    waktu: $satu->updated_at,
                    url: route('rental.orders', ['tab' => 'akan-datang', 'q' => $satu->kode_pemesanan]),
                    ikon: 'fa-receipt',
                    tone: 'orange',
                    label: 'Siap Diambil di Pos '.$labelPos,
                ));
            }

            if ($satu->status === 'paid' && $satu->waktu_serah_terima !== null && $satu->tanggal_selesai->lt(today())) {
                $hari = (int) $satu->tanggal_selesai->diffInDays(today());

                $daftar->push(self::buat(
                    id: 'terlambat-'.$satu->id,
                    jenis: 'pengembalian',
                    judul: 'Pengembalian Terlambat',
                    pesan: 'Pesanan '.$satu->kode_pemesanan.' terlambat '.$hari.' hari. Hubungi pemesan '.$satu->nama_ketua.'.',
                    waktu: $satu->tanggal_selesai->copy()->endOfDay(),
                    url: route('rental.returns.show', $satu),
                    ikon: 'fa-clock-rotate-left',
                    tone: 'red',
                    label: 'Catat Pengembalian',
                ));
            }

            if ($satu->status === 'paid' && $satu->waktu_serah_terima !== null) {
                $daftar->push(self::buat(
                    id: 'disewa-'.$satu->id,
                    jenis: 'pesanan',
                    judul: 'Alat Sedang Disewa',
                    pesan: $satu->nama_ketua.' menerima '.$satu->items->sum('jumlah').' unit alat. Pengembalian '
                        .$satu->tanggal_selesai->translatedFormat('d M Y').'.',
                    waktu: $satu->waktu_serah_terima,
                    url: route('rental.returns.show', $satu),
                    ikon: 'fa-tent',
                    tone: 'sky',
                    label: 'Jadwal Kembali',
                ));
            }
        }

        Peralatan::query()
            ->where('toko_rental_id', $toko->id)
            ->where('jumlah_stok', '<=', max(1, (int) $toko->batas_stok_minimum))
            ->orderBy('jumlah_stok')
            ->take(4)
            ->get()
            ->each(function (Peralatan $alat) use ($daftar, $toko): void {
                $daftar->push(self::buat(
                    id: 'stok-'.$alat->id,
                    jenis: 'stok',
                    judul: 'Stok Alat Rendah',
                    pesan: $alat->nama.' tersisa '.$alat->jumlah_stok.' unit. Pertimbangkan restock.',
                    waktu: $alat->updated_at ?? now(),
                    url: route('rental.equipment.edit', $alat),
                    ikon: 'fa-boxes-stacked',
                    tone: 'amber',
                    label: 'Batas Minimum: '.(int) $toko->batas_stok_minimum.' Unit',
                ));
            });

        $daftar->push(self::buat(
            id: 'toko-'.$toko->id.'-'.$toko->status,
            jenis: 'verifikasi',
            judul: $toko->status === 'active' ? 'Akun Toko Terverifikasi' : 'Menunggu Verifikasi Toko',
            pesan: $toko->status === 'active'
                ? 'Toko '.$toko->nama_toko.' telah diverifikasi admin dan tampil di katalog publik.'
                : 'Pendaftaran toko '.$toko->nama_toko.' sedang ditinjau tim verifikasi TNGR.',
            waktu: $toko->updated_at ?? now(),
            url: route('rental.verification'),
            ikon: 'fa-circle-check',
            tone: 'emerald',
            label: $toko->status === 'active' ? 'Mitra Resmi TNGR' : 'Estimasi 1×24 Jam',
        ));

        return $daftar
            ->sortByDesc(fn (array $item) => $item['waktu']->getTimestamp())
            ->values();
    }

    public static function jumlahBelumDibaca(TokoRental $toko): int
    {
        $dibaca = collect($toko->notifikasi_dibaca ?? [])->all();

        return self::daftar($toko)
            ->reject(fn (array $item) => in_array($item['id'], $dibaca, true))
            ->count();
    }

    public static function tandai(TokoRental $toko, ?string $id = null): void
    {
        $dibaca = collect($toko->notifikasi_dibaca ?? []);

        $idBaru = $id === null
            ? self::daftar($toko)->pluck('id')
            : collect([$id]);

        $toko->update([
            'notifikasi_dibaca' => $dibaca->merge($idBaru)->unique()->values()->all(),
        ]);
    }

    /**
     * @return array{id: string, jenis: string, judul: string, pesan: string, waktu: Carbon, waktu_relatif: string, url: string, ikon: string, tone: string, label: string}
     */
    private static function buat(
        string $id,
        string $jenis,
        string $judul,
        string $pesan,
        CarbonInterface $waktu,
        string $url,
        string $ikon,
        string $tone,
        string $label,
    ): array {
        $saat = Carbon::parse($waktu);

        return [
            'id' => $id,
            'jenis' => $jenis,
            'judul' => $judul,
            'pesan' => $pesan,
            'waktu' => $saat,
            'waktu_relatif' => $saat->locale('id')->diffForHumans(),
            'url' => $url,
            'ikon' => $ikon,
            'tone' => $tone,
            'label' => $label,
        ];
    }
}
