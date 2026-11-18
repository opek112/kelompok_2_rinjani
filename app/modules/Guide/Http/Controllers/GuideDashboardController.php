<?php

namespace Modules\Guide\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Services\KetersediaanService;
use Modules\Guide\Services\PendapatanService;

class GuideDashboardController extends GuideController
{
    public function index(Request $request): View
    {
        $pemandu = $this->pemandu();
        $bulan = $this->bulan($request->query('bulan'));

        $awalBulan = $bulan->copy()->startOfMonth();
        $akhirBulan = $bulan->copy()->endOfMonth();

        $peta = KetersediaanService::petaBulan($pemandu->id, $bulan);

        $cells = array_fill(0, $awalBulan->dayOfWeekIso - 1, null);

        foreach ($peta as $iso => $status) {
            $cells[] = [
                'tanggal' => Carbon::parse($iso),
                'iso' => $iso,
                'status' => $status,
            ];
        }

        $penugasanBulanIni = Pemesanan::query()
            ->where('pemandu_id', $pemandu->id)
            ->whereIn('status', ['paid', 'completed'])
            ->whereDate('tanggal_mulai', '<=', $akhirBulan->toDateString())
            ->whereDate('tanggal_selesai', '>=', $awalBulan->toDateString())
            ->count();

        $perluKonfirmasi = Pemesanan::query()
            ->where('pemandu_id', $pemandu->id)
            ->where('status', 'paid')
            ->where('kehadiran_pemandu_dikonfirmasi', false)
            ->whereDate('tanggal_selesai', '>=', today()->toDateString())
            ->count();

        $pendapatan = (new PendapatanService())->ringkasan($pemandu, $awalBulan, $akhirBulan);

        $hariTersedia = count(array_filter($peta, fn (string $status) => $status === 'available'));
        $hariTerisi = count(array_filter($peta, fn (string $status) => $status === 'booked'));

        return view('guide.dashboard', [
            'pemandu' => $pemandu,
            'bulan' => $bulan,
            'cells' => $cells,
            'penugasanBulanIni' => $penugasanBulanIni,
            'perluKonfirmasi' => $perluKonfirmasi,
            'pendapatanBulanIni' => $pendapatan['bersih'],
            'hariTersedia' => $hariTersedia,
            'hariTerisi' => $hariTerisi,
        ]);
    }

    private function bulan(?string $nilai): Carbon
    {
        if (is_string($nilai) && preg_match('/^\d{4}-\d{2}$/', $nilai) === 1) {
            return Carbon::createFromFormat('Y-m-d', $nilai.'-01')->startOfMonth();
        }

        return now()->startOfMonth();
    }
}
