<?php

namespace Modules\Guide\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Guide\Services\PendapatanService;
use Modules\Guide\Support\Formatter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EarningsController extends GuideController
{
    public function index(Request $request): View
    {
        $pemandu = $this->pemandu();
        $bulan = $this->bulan($request->query('bulan'));
        $awal = $bulan->copy()->startOfMonth();
        $akhir = $bulan->copy()->endOfMonth();

        $service = new PendapatanService();

        $ringkasan = $service->ringkasan($pemandu, $awal, $akhir);

        $riwayat = $service->query($pemandu)
            ->whereBetween('tanggal_mulai', [$awal->toDateString(), $akhir->toDateString()])
            ->orderByDesc('tanggal_mulai')
            ->paginate(10)
            ->withQueryString();

        $riwayat->setCollection(
            $riwayat->getCollection()->map(fn ($pesanan) => [
                'pemesanan' => $pesanan,
                'rincian' => $service->rincian($pesanan),
            ])
        );

        $bulanan = $service->bulanan($pemandu);
        $maksimal = max(array_map(fn (array $baris) => $baris['total'], $bulanan) ?: [0]);
        $maksimal = $maksimal > 0 ? $maksimal : 1;

        return view('guide.earnings', compact('pemandu', 'bulan', 'ringkasan', 'riwayat', 'bulanan', 'maksimal'));
    }

    public function export(Request $request): StreamedResponse
    {
        $pemandu = $this->pemandu();
        $bulan = $this->bulan($request->query('bulan'));
        $awal = $bulan->copy()->startOfMonth();
        $akhir = $bulan->copy()->endOfMonth();

        $service = new PendapatanService();

        $daftar = $service->query($pemandu)
            ->whereBetween('tanggal_mulai', [$awal->toDateString(), $akhir->toDateString()])
            ->orderBy('tanggal_mulai')
            ->get();

        $namaBerkas = 'laporan-pendapatan-'.$awal->format('Y-m').'.csv';

        return response()->streamDownload(function () use ($daftar, $service) {
            $keluaran = fopen('php://output', 'w');

            fputcsv($keluaran, [
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Kode Pesanan',
                'Pemesan',
                'Jalur',
                'Pendapatan Kotor',
                'Komisi',
                'Pendapatan Bersih',
            ]);

            foreach ($daftar as $pesanan) {
                $rincian = $service->rincian($pesanan);

                fputcsv($keluaran, [
                    $pesanan->tanggal_mulai->toDateString(),
                    $pesanan->tanggal_selesai->toDateString(),
                    $pesanan->kode_pemesanan,
                    $pesanan->nama_ketua,
                    $pesanan->rute,
                    $rincian['kotor'],
                    $rincian['komisi'],
                    $rincian['bersih'],
                ]);
            }

            fclose($keluaran);
        }, $namaBerkas, ['Content-Type' => 'text/csv']);
    }

    private function bulan(?string $nilai): Carbon
    {
        if (is_string($nilai) && preg_match('/^\d{4}-\d{2}$/', $nilai) === 1) {
            return Carbon::createFromFormat('Y-m-d', $nilai.'-01')->startOfMonth();
        }

        return now()->startOfMonth();
    }
}
