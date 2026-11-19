<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\StokService;

class PartnerCatalogController extends PartnerController
{
    public function index(Request $request, StokService $stok): View
    {
        $toko = $this->toko($request);

        $pencarian = trim($request->string('q')->toString());
        $kategori = $request->string('kategori')->toString();

        $query = Peralatan::query()->where('toko_rental_id', $toko->id);

        if ($pencarian !== '') {
            $query->where(function ($builder) use ($pencarian): void {
                $builder->where('nama', 'like', "%{$pencarian}%")
                    ->orWhere('deskripsi', 'like', "%{$pencarian}%");
            });
        }

        if ($kategori !== '' && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        $peralatan = $query->orderByDesc('sorotan')->orderBy('nama')->paginate(9)->withQueryString();

        // FR-REN-03 + FR-REN-04: sisa stok pada rentang sewa yang sedang dilihat.
        $mulai = $request->date('mulai') ?? today();
        $selesai = $request->date('selesai') ?? $mulai->copy()->addDays(2);

        if ($selesai->lt($mulai)) {
            $selesai = $mulai->copy();
        }

        return view('rental.partner.catalog', [
            'toko' => $toko,
            'peralatan' => $peralatan,
            'pencarian' => $pencarian,
            'kategori' => $kategori,
            'mulai' => Carbon::parse($mulai),
            'selesai' => Carbon::parse($selesai),
            'sisaStok' => $stok->petaSisaStok($peralatan->pluck('id')->all(), $mulai, $selesai),
            'tampilPublik' => $toko->status === 'active' && $toko->aktif,
            'daftarKategori' => Peralatan::query()
                ->where('toko_rental_id', $toko->id)
                ->whereNotNull('kategori')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori'),
            'sedangDikemas' => $this->pesananPerluTindakan($toko),
        ]);
    }

    private function pesananPerluTindakan(TokoRental $toko): int
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->where('status', 'paid')
            ->whereNull('waktu_serah_terima')
            ->count();
    }
}
