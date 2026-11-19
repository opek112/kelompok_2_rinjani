<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\StatusPesanan;

class PartnerOrderController extends PartnerController
{
    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        $tab = $request->string('tab')->toString();
        if (! in_array($tab, StatusPesanan::TAB, true)) {
            $tab = 'akan-datang';
        }

        $pencarian = trim($request->string('q')->toString());

        $basis = $this->basis($toko);

        $jumlah = [
            'akan-datang' => (clone $basis)->where('status', 'paid')->whereNull('waktu_serah_terima')->count(),
            'disewa' => (clone $basis)->where('status', 'paid')->whereNotNull('waktu_serah_terima')->count(),
            'selesai' => (clone $basis)->whereIn('status', ['completed', 'expired', 'cancelled'])->count(),
        ];

        $query = $this->basis($toko)->with(['items.peralatan', 'pembayaran']);

        match ($tab) {
            'disewa' => $query->where('status', 'paid')->whereNotNull('waktu_serah_terima'),
            'selesai' => $query->whereIn('status', ['completed', 'expired', 'cancelled'])->latest('updated_at'),
            default => $query->where('status', 'paid')->whereNull('waktu_serah_terima')->orderBy('tanggal_mulai'),
        };

        if ($pencarian !== '') {
            $query->where(function ($builder) use ($pencarian): void {
                $builder->where('kode_pemesanan', 'like', "%{$pencarian}%")
                    ->orWhere('nama_ketua', 'like', "%{$pencarian}%")
                    ->orWhere('telepon_ketua', 'like', "%{$pencarian}%");
            });
        }

        return view('rental.partner.orders', [
            'toko' => $toko,
            'tab' => $tab,
            'jumlah' => $jumlah,
            'pencarian' => $pencarian,
            'pesanan' => $query->paginate(6)->withQueryString(),
            'stats' => $this->ringkasanStok($toko),
            'sedangDikemas' => $jumlah['akan-datang'],
        ]);
    }

    public function deliver(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $pemesanan);

        if ($pemesanan->status !== 'paid') {
            return back()->with('error', 'Pesanan ini belum lunas, serah terima belum bisa dicatat.');
        }

        if ($pemesanan->waktu_serah_terima !== null) {
            return back()->with('error', 'Serah terima untuk pesanan ini sudah tercatat.');
        }

        $pemesanan->update(['waktu_serah_terima' => now()]);

        return back()->with('success', 'Serah terima '.$pemesanan->kode_pemesanan.' tercatat. Alat kini berstatus sedang disewa.');
    }

    public function complete(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $pemesanan);

        if ($pemesanan->status !== 'paid' || $pemesanan->waktu_serah_terima === null) {
            return back()->with('error', 'Pesanan ini belum melewati serah terima, pengembalian belum bisa dicatat.');
        }

        $pemesanan->update(['status' => 'completed']);

        return back()->with('success', 'Pengembalian '.$pemesanan->kode_pemesanan.' tercatat. Stok alat kembali tersedia.');
    }

    private function basis(TokoRental $toko)
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->whereIn('status', ['paid', 'completed', 'expired', 'cancelled']);
    }

    private function pastikanMilikToko(TokoRental $toko, Pemesanan $pemesanan): void
    {
        $milikToko = $pemesanan->items()
            ->whereHas('peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->exists();

        abort_unless($milikToko, 404);
    }
}
