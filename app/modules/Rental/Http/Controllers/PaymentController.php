<?php

namespace Modules\Rental\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Services\JadwalPemanduService;

class PaymentController extends Controller
{
    private const AMBANG_KRITIS_DETIK = 120;

    public function status(Request $request, string $kode): View|RedirectResponse
    {
        $pemesanan = $this->cariPemesanan($kode);
        $pembayaran = $pemesanan->pembayaran;

        if (! $pembayaran) {
            abort(404);
        }

        if ($pemesanan->status === 'paid') {
            return redirect()->route('rental.voucher', $kode);
        }

        $sisaDetik = max(0, $pembayaran->kedaluwarsa_pada->getTimestamp() - now()->getTimestamp());

        $demo = $request->string('demo')->toString();

        if ($demo === 'critical') {
            $sisaDetik = 83;
        } elseif ($demo === 'expired') {
            $sisaDetik = 0;
        }

        if ($sisaDetik <= 0 && $pemesanan->status === 'pending' && $demo === '') {
            $pemesanan->update(['status' => 'expired']);
            $pembayaran->update(['status_pembayaran' => 'expire']);
            JadwalPemanduService::lepas($pemesanan);
        }

        $state = match (true) {
            $pemesanan->status === 'cancelled', $pemesanan->status === 'expired', $sisaDetik <= 0 => 'expired',
            $sisaDetik <= self::AMBANG_KRITIS_DETIK => 'critical',
            default => 'waiting',
        };

        return view('rental.payment.status', [
            'pemesanan' => $pemesanan,
            'pembayaran' => $pembayaran,
            'state' => $state,
            'sisaDetik' => $sisaDetik,
            'kode' => $pemesanan->kode_pemesanan,
        ]);
    }

    public function confirm(string $kode): RedirectResponse
    {
        $pemesanan = $this->cariPemesanan($kode);
        $pembayaran = $pemesanan->pembayaran;

        if ($pemesanan->status === 'paid') {
            return redirect()->route('rental.voucher', $kode);
        }

        if ($pemesanan->status === 'cancelled') {
            return redirect()
                ->route('rental.payment', $kode)
                ->with('error', 'Pesanan ini sudah dibatalkan.');
        }

        if (! $pembayaran || now()->greaterThan($pembayaran->kedaluwarsa_pada)) {
            $pemesanan->update(['status' => 'expired']);
            $pembayaran?->update(['status_pembayaran' => 'expire']);
            JadwalPemanduService::lepas($pemesanan);

            return redirect()
                ->route('rental.payment', $kode)
                ->with('error', 'Batas waktu pembayaran sudah habis. Silakan buat pesanan baru.');
        }

        $pemesanan->update(['status' => 'paid']);
        $pembayaran->update([
            'status_pembayaran' => 'settlement',
            'dibayar_pada' => now(),
        ]);

        JadwalPemanduService::kunci($pemesanan);

        return redirect()->route('rental.voucher', $kode);
    }

    public function cancel(string $kode): RedirectResponse
    {
        $pemesanan = $this->cariPemesanan($kode);

        if ($pemesanan->status === 'pending') {
            $pemesanan->update(['status' => 'cancelled']);
            $pemesanan->pembayaran?->update(['status_pembayaran' => 'expire']);
            JadwalPemanduService::lepas($pemesanan);
        }

        return redirect()
            ->route('home')
            ->with('status', 'Pesanan '.$kode.' dibatalkan. Kuota alat dikembalikan ke sistem.');
    }

    public function voucher(string $kode): View|RedirectResponse
    {
        $pemesanan = $this->cariPemesanan($kode);

        if ($pemesanan->status !== 'paid') {
            return redirect()
                ->route('rental.payment', $kode)
                ->with('error', 'E-voucher tersedia setelah pembayaran dinyatakan lunas.');
        }

        return view('rental.payment.voucher', [
            'pemesanan' => $pemesanan,
            'pembayaran' => $pemesanan->pembayaran,
            'kode' => $pemesanan->kode_pemesanan,
        ]);
    }

    private function cariPemesanan(string $kode): Pemesanan
    {
        return Pemesanan::query()
            ->with(['items.peralatan.toko', 'pembayaran', 'pemandu.user'])
            ->where('kode_pemesanan', $kode)
            ->firstOrFail();
    }
}
