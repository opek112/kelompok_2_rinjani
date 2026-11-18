<?php

namespace Modules\Guide\Services;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Models\PengaturanPlatform;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;

class PendapatanService
{
    /** Pesanan yang dihitung sebagai pendapatan pemandu. */
    public function query(Pemandu $pemandu): Builder
    {
        return Pemesanan::query()
            ->with('pemandu')
            ->where('pemandu_id', $pemandu->id)
            ->whereIn('status', ['paid', 'completed']);
    }

    /**
     * Rincian pendapatan satu pesanan: kotor, komisi platform, dan bersih.
     *
     * @return array{kotor: float, komisi: float, bersih: float, persen: float}
     */
    public function rincian(Pemesanan $pemesanan): array
    {
        $kotor = $pemesanan->biaya_pemandu_snapshot;

        if ($kotor === null) {
            $tarif = (float) ($pemesanan->pemandu->tarif_harian ?? 0);
            $kotor = $tarif * max(1, (int) $pemesanan->total_hari);
        }

        $kotor = (float) $kotor;
        $persen = $pemesanan->persentase_komisi !== null
            ? (float) $pemesanan->persentase_komisi
            : (float) PengaturanPlatform::getKomisi();

        $komisi = $pemesanan->nominal_komisi !== null
            ? (float) $pemesanan->nominal_komisi
            : round($kotor * $persen / 100, 2);

        return [
            'kotor' => $kotor,
            'komisi' => $komisi,
            'bersih' => $kotor - $komisi,
            'persen' => $persen,
        ];
    }

    /**
     * @return array{kotor: float, komisi: float, bersih: float, jumlah: int}
     */
    public function ringkasan(Pemandu $pemandu, CarbonInterface $mulai, CarbonInterface $selesai): array
    {
        $daftar = $this->query($pemandu)
            ->whereBetween('tanggal_mulai', [$mulai->toDateString(), $selesai->toDateString()])
            ->get();

        $kotor = 0.0;
        $komisi = 0.0;

        foreach ($daftar as $pesanan) {
            $rincian = $this->rincian($pesanan);
            $kotor += $rincian['kotor'];
            $komisi += $rincian['komisi'];
        }

        return [
            'kotor' => $kotor,
            'komisi' => $komisi,
            'bersih' => $kotor - $komisi,
            'jumlah' => $daftar->count(),
        ];
    }

    /**
     * Pendapatan bersih beberapa bulan terakhir, urut dari paling lama.
     *
     * @return array<int, array{bulan: Carbon, label: string, total: float}>
     */
    public function bulanan(Pemandu $pemandu, int $jumlahBulan = 6): array
    {
        $hasil = [];

        for ($i = $jumlahBulan - 1; $i >= 0; $i--) {
            $awal = now()->startOfMonth()->subMonths($i);
            $ringkasan = $this->ringkasan($pemandu, $awal->copy()->startOfMonth(), $awal->copy()->endOfMonth());

            $hasil[] = [
                'bulan' => $awal,
                'label' => \Modules\Guide\Support\Formatter::bulan($awal),
                'total' => $ringkasan['bersih'],
            ];
        }

        return $hasil;
    }
}
