<?php

namespace Modules\Guide\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Guide\Models\Ketersediaan;
use Modules\Guide\Services\KetersediaanService;
use Modules\Guide\Support\Formatter;

class KetersediaanController extends GuideController
{
    /**
     * Klik satu tanggal: available <-> off. Tanggal booked tidak bisa diubah.
     */
    public function toggle(string $tanggal): RedirectResponse
    {
        $pemandu = $this->pemandu();
        $tanggalObj = Carbon::parse($tanggal)->startOfDay();
        $statusSekarang = KetersediaanService::statusTanggal($pemandu->id, $tanggalObj);

        if ($statusSekarang === 'booked') {
            return back()->with('error', 'Tanggal yang sudah dipesan tidak dapat diubah.');
        }

        $statusBaru = $statusSekarang === 'off' ? 'available' : 'off';

        Ketersediaan::updateOrCreate(
            ['pemandu_id' => $pemandu->id, 'tanggal' => $tanggalObj->toDateString()],
            ['status' => $statusBaru, 'pemesanan_id' => null]
        );

        return back()->with(
            'success',
            'Tanggal '.Formatter::tanggal($tanggalObj).' ditandai '.($statusBaru === 'off' ? 'libur' : 'tersedia').'.'
        );
    }

    /**
     * Aksi cepat: tandai seluruh bulan tersedia atau libur.
     */
    public function bulk(Request $request): RedirectResponse
    {
        $pemandu = $this->pemandu();

        $data = $request->validate([
            'status' => ['required', 'in:available,off'],
            'bulan' => ['required', 'regex:/^\d{4}-\d{2}$/'],
        ]);

        $awal = Carbon::createFromFormat('Y-m-d', $data['bulan'].'-01')->startOfMonth();
        $akhir = $awal->copy()->endOfMonth();
        $diubah = 0;

        for ($hari = $awal->copy(); $hari->lte($akhir); $hari->addDay()) {
            if (KetersediaanService::statusTanggal($pemandu->id, $hari) === 'booked') {
                continue;
            }

            Ketersediaan::updateOrCreate(
                ['pemandu_id' => $pemandu->id, 'tanggal' => $hari->toDateString()],
                ['status' => $data['status'], 'pemesanan_id' => null]
            );

            $diubah++;
        }

        return back()->with(
            'success',
            $diubah.' tanggal ditandai '.($data['status'] === 'off' ? 'libur' : 'tersedia').' untuk '.Formatter::bulan($awal).'.'
        );
    }
}
