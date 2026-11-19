<?php

namespace Modules\Rental\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Rental\Models\TokoRental;

abstract class PartnerController extends Controller
{
    protected function toko(Request $request): TokoRental
    {
        $toko = $request->user()?->tokoRental()->first();

        abort_if($toko === null, 403, 'Akun ini belum terhubung dengan toko rental.');

        return $toko;
    }

    /**
     * @return array{jenis: int, total: int, disewa: int, tersedia: int}
     */
    protected function ringkasanStok(TokoRental $toko): array
    {
        $jenis = $toko->peralatan()->count();
        $total = (int) $toko->peralatan()->sum('jumlah_stok');

        $disewa = (int) ItemPemesanan::query()
            ->whereHas('peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->whereHas('pemesanan', fn ($query) => $query->where('status', 'paid')->whereNotNull('waktu_serah_terima'))
            ->sum('jumlah');

        return [
            'jenis' => $jenis,
            'total' => $total,
            'disewa' => $disewa,
            'tersedia' => max(0, $total - $disewa),
        ];
    }
}
