<?php

namespace Modules\Guide\Services;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Ketersediaan;

class KetersediaanService
{
    /**
     * Semua tanggal dalam rentang tidak berstatus off atau booked.
     */
    public static function tersedia(int $idPemandu, CarbonInterface|string $mulai, CarbonInterface|string $selesai): bool
    {
        $mulai = Carbon::parse($mulai)->startOfDay();
        $selesai = Carbon::parse($selesai)->startOfDay();

        if ($selesai->lt($mulai)) {
            return false;
        }

        $diblokir = Ketersediaan::query()
            ->where('pemandu_id', $idPemandu)
            ->whereBetween('tanggal', [$mulai->toDateString(), $selesai->toDateString()])
            ->whereIn('status', ['off', 'booked'])
            ->exists();

        if ($diblokir) {
            return false;
        }

        return ! self::punyaPenugasan($idPemandu, $mulai, $selesai);
    }

    /**
     * Status satu tanggal: available, off, atau booked.
     */
    public static function statusTanggal(int $idPemandu, CarbonInterface|string $tanggal): string
    {
        $tanggal = Carbon::parse($tanggal)->startOfDay();

        $catatan = Ketersediaan::query()
            ->where('pemandu_id', $idPemandu)
            ->whereDate('tanggal', $tanggal->toDateString())
            ->first();

        if ($catatan && in_array($catatan->status, ['off', 'booked'], true)) {
            return $catatan->status;
        }

        return self::punyaPenugasan($idPemandu, $tanggal, $tanggal) ? 'booked' : 'available';
    }

    /**
     * Peta status seluruh hari dalam satu bulan.
     *
     * @return array<string, string> kunci Y-m-d, nilai available|off|booked
     */
    public static function petaBulan(int $idPemandu, CarbonInterface $bulan): array
    {
        $awal = Carbon::parse($bulan)->startOfMonth();
        $akhir = $awal->copy()->endOfMonth();

        $catatan = Ketersediaan::query()
            ->where('pemandu_id', $idPemandu)
            ->whereBetween('tanggal', [$awal->toDateString(), $akhir->toDateString()])
            ->get()
            ->mapWithKeys(fn (Ketersediaan $baris) => [Carbon::parse($baris->tanggal)->toDateString() => $baris->status]);

        $penugasan = Pemesanan::query()
            ->where('pemandu_id', $idPemandu)
            ->whereIn('status', ['pending', 'paid', 'completed'])
            ->whereDate('tanggal_mulai', '<=', $akhir->toDateString())
            ->whereDate('tanggal_selesai', '>=', $awal->toDateString())
            ->get(['tanggal_mulai', 'tanggal_selesai']);

        $peta = [];

        for ($hari = $awal->copy(); $hari->lte($akhir); $hari->addDay()) {
            $iso = $hari->toDateString();
            $status = $catatan[$iso] ?? 'available';

            if ($status === 'available') {
                foreach ($penugasan as $pesanan) {
                    if ($hari->betweenIncluded($pesanan->tanggal_mulai, $pesanan->tanggal_selesai)) {
                        $status = 'booked';
                        break;
                    }
                }
            }

            $peta[$iso] = in_array($status, ['off', 'booked'], true) ? $status : 'available';
        }

        return $peta;
    }

    private static function punyaPenugasan(int $idPemandu, CarbonInterface $mulai, CarbonInterface $selesai): bool
    {
        return Pemesanan::query()
            ->where('pemandu_id', $idPemandu)
            ->whereIn('status', ['pending', 'paid', 'completed'])
            ->whereDate('tanggal_mulai', '<=', $selesai->toDateString())
            ->whereDate('tanggal_selesai', '>=', $mulai->toDateString())
            ->exists();
    }
}
