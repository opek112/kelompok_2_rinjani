<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\Rupiah;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * FR-REN-05 — rekap pendapatan sewa per periode (setelah komisi)
 * dan mutasi inventaris alat keluar-masuk.
 */
class PartnerReportController extends PartnerController
{
    public function index(Request $request): View
    {
        $toko = $this->toko($request);
        [$bulan, $tahun] = $this->periode($request);

        $laporan = $this->laporan($toko, $bulan, $tahun);

        return view('rental.partner.reports', [
            'toko' => $toko,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'laporan' => $laporan,
            'daftarBulan' => $this->daftarBulan(),
            'daftarTahun' => range((int) now()->year, (int) now()->year - 3),
            'sedangDikemas' => $laporan['perluTindakan'],
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $toko = $this->toko($request);
        [$bulan, $tahun] = $this->periode($request);

        $laporan = $this->laporan($toko, $bulan, $tahun);
        $namaBerkas = 'rekap-pendapatan-'.str($toko->nama_toko)->slug().'-'.$tahun.'-'.str_pad((string) $bulan, 2, '0', STR_PAD_LEFT).'.csv';

        return response()->streamDownload(function () use ($laporan): void {
            $keluaran = fopen('php://output', 'w');

            fputcsv($keluaran, ['Tanggal Mulai', 'Tanggal Selesai', 'Kode Pesanan', 'Pemesan', 'Jumlah Unit', 'Pendapatan Kotor', 'Komisi', 'Pendapatan Bersih']);

            foreach ($laporan['riwayat'] as $baris) {
                fputcsv($keluaran, [
                    $baris['mulai'],
                    $baris['selesai'],
                    $baris['kode'],
                    $baris['pemesan'],
                    $baris['unit'],
                    (int) $baris['kotor'],
                    (int) $baris['komisi'],
                    (int) $baris['bersih'],
                ]);
            }

            fputcsv($keluaran, []);
            fputcsv($keluaran, ['Total Kotor', (int) $laporan['kotor']]);
            fputcsv($keluaran, ['Total Komisi', (int) $laporan['komisi']]);
            fputcsv($keluaran, ['Total Bersih', (int) $laporan['bersih']]);

            fclose($keluaran);
        }, $namaBerkas, ['Content-Type' => 'text/csv']);
    }

    /**
     * @return array{0: int, 1: int}
     */
    private function periode(Request $request): array
    {
        $bulan = (int) $request->integer('bulan', (int) now()->month);
        $tahun = (int) $request->integer('tahun', (int) now()->year);

        $bulan = max(1, min(12, $bulan));
        $tahun = max(2000, min((int) now()->year + 1, $tahun));

        return [$bulan, $tahun];
    }

    /**
     * @return array<string, mixed>
     */
    private function laporan(TokoRental $toko, int $bulan, int $tahun): array
    {
        $awal = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $akhir = $awal->copy()->endOfMonth();

        $pesanan = $this->pesananPeriode($toko, $awal, $akhir);

        $riwayat = $pesanan->map(fn (Pemesanan $satu) => $this->barisPendapatan($toko, $satu));

        $kotor = (float) $riwayat->sum('kotor');
        $komisi = (float) $riwayat->sum('komisi');

        $sebelumnya = $this->pesananPeriode(
            $toko,
            $awal->copy()->subMonthNoOverflow()->startOfMonth(),
            $awal->copy()->subMonthNoOverflow()->endOfMonth(),
        );
        $kotorSebelumnya = (float) $sebelumnya->sum(fn (Pemesanan $satu) => $this->barisPendapatan($toko, $satu)['kotor']);

        $mulaiGrafik = $awal->copy()->subMonthsNoOverflow(5)->startOfMonth();
        $pesananEnamBulan = $this->pesananPeriode($toko, $mulaiGrafik, $akhir);

        $grafik = collect(range(5, 0))->map(function (int $mundur) use ($awal, $pesananEnamBulan, $toko): array {
            $bulanKe = $awal->copy()->subMonthsNoOverflow($mundur);
            $nilai = $pesananEnamBulan
                ->filter(fn (Pemesanan $satu) => $satu->tanggal_mulai->isSameMonth($bulanKe))
                ->sum(fn (Pemesanan $satu) => $this->barisPendapatan($toko, $satu)['bersih']);

            return [
                'label' => $bulanKe->translatedFormat('M Y'),
                'nilai' => (float) $nilai,
                'aktif' => $bulanKe->isSameMonth($awal),
            ];
        })->values();

        $puncak = (float) max(1, $grafik->max('nilai'));

        return [
            'awal' => $awal,
            'akhir' => $akhir,
            'kotor' => $kotor,
            'komisi' => $komisi,
            'bersih' => $kotor - $komisi,
            'persenKomisi' => $kotor > 0 ? round($komisi / $kotor * 100, 1) : 10.0,
            'pertumbuhan' => $kotorSebelumnya > 0
                ? round(($kotor - $kotorSebelumnya) / $kotorSebelumnya * 100, 1)
                : null,
            'riwayat' => $riwayat,
            'mutasi' => $this->mutasiInventaris($toko, $awal, $akhir),
            'grafik' => $grafik->map(fn (array $titik) => $titik + ['tinggi' => max(4, round($titik['nilai'] / $puncak * 100))]),
            'tertinggi' => $grafik->sortByDesc('nilai')->first(),
            'perluTindakan' => $this->pesananPerluTindakan($toko),
        ];
    }

    /**
     * @return Collection<int, Pemesanan>
     */
    private function pesananPeriode(TokoRental $toko, Carbon $awal, Carbon $akhir): Collection
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->whereIn('status', ['paid', 'completed'])
            ->whereBetween('tanggal_mulai', [$awal->toDateString(), $akhir->toDateString()])
            ->with(['items.peralatan'])
            ->orderByDesc('tanggal_mulai')
            ->get();
    }

    /**
     * @return array{kode: string, pemesan: string, mulai: string, selesai: string, unit: int, kotor: float, komisi: float, bersih: float}
     */
    private function barisPendapatan(TokoRental $toko, Pemesanan $pesanan): array
    {
        $items = $pesanan->items->filter(fn (ItemPemesanan $item) => $item->peralatan?->toko_rental_id === $toko->id);
        $kotor = (float) $items->sum('subtotal');
        $persen = (float) ($pesanan->persentase_komisi ?: 10);
        $komisi = round($kotor * $persen / 100, 2);

        return [
            'kode' => $pesanan->kode_pemesanan,
            'pemesan' => $pesanan->nama_ketua,
            'mulai' => $pesanan->tanggal_mulai->toDateString(),
            'selesai' => $pesanan->tanggal_selesai->toDateString(),
            'unit' => (int) $items->sum('jumlah'),
            'kotor' => $kotor,
            'komisi' => $komisi,
            'bersih' => $kotor - $komisi,
        ];
    }

    /**
     * @return Collection<int, array{tanggal: string, nama: string, jenis: string, jumlah: int, keterangan: string, tone: string}>
     */
    private function mutasiInventaris(TokoRental $toko, Carbon $awal, Carbon $akhir): Collection
    {
        $items = ItemPemesanan::query()
            ->whereHas('peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->whereHas('pemesanan', fn ($query) => $query
                ->whereIn('status', ['paid', 'completed'])
                ->whereBetween('tanggal_mulai', [$awal->toDateString(), $akhir->toDateString()]))
            ->with(['peralatan', 'pemesanan', 'pengembalian'])
            ->get();

        $baris = collect();

        foreach ($items as $item) {
            $baris->push([
                'tanggal' => $item->pemesanan->tanggal_mulai->toDateString(),
                'nama' => $item->peralatan?->nama ?? 'Alat dihapus',
                'jenis' => 'Keluar',
                'jumlah' => (int) $item->jumlah,
                'keterangan' => 'Pesanan '.$item->pemesanan->kode_pemesanan,
                'tone' => 'orange',
            ]);

            foreach (collect([$item->pengembalian])->filter() as $kembali) {
                $tanggal = optional($item->pemesanan->waktu_pengembalian)->toDateString()
                    ?? $item->pemesanan->tanggal_selesai->toDateString();

                if ((int) $kembali->jumlah_baik > 0) {
                    $baris->push([
                        'tanggal' => $tanggal,
                        'nama' => $item->peralatan?->nama ?? 'Alat dihapus',
                        'jenis' => 'Masuk',
                        'jumlah' => (int) $kembali->jumlah_baik,
                        'keterangan' => 'Dikembalikan — Kondisi Baik',
                        'tone' => 'emerald',
                    ]);
                }

                if ((int) $kembali->jumlah_rusak > 0) {
                    $baris->push([
                        'tanggal' => $tanggal,
                        'nama' => $item->peralatan?->nama ?? 'Alat dihapus',
                        'jenis' => 'Masuk',
                        'jumlah' => (int) $kembali->jumlah_rusak,
                        'keterangan' => 'Dikembalikan — Perlu Perbaikan',
                        'tone' => 'amber',
                    ]);
                }

                if ((int) $kembali->jumlah_hilang > 0) {
                    $baris->push([
                        'tanggal' => $tanggal,
                        'nama' => $item->peralatan?->nama ?? 'Alat dihapus',
                        'jenis' => 'Hilang',
                        'jumlah' => (int) $kembali->jumlah_hilang,
                        'keterangan' => 'Hilang — Denda '.Rupiah::format($kembali->denda),
                        'tone' => 'red',
                    ]);
                }
            }
        }

        return $baris->sortByDesc('tanggal')->values()->take(12);
    }

    private function pesananPerluTindakan(TokoRental $toko): int
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->where('status', 'paid')
            ->whereNull('waktu_serah_terima')
            ->count();
    }

    /**
     * @return array<int, string>
     */
    private function daftarBulan(): array
    {
        return collect(range(1, 12))
            ->mapWithKeys(fn (int $bulan) => [$bulan => Carbon::create(null, $bulan, 1)->locale('id')->translatedFormat('F')])
            ->all();
    }
}
