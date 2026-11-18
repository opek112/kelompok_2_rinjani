<?php

namespace Modules\Rental\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Payment\Models\Pembayaran;
use Modules\Rental\Support\Cart;

class CheckoutController extends Controller
{
    public function show(Cart $cart): View|RedirectResponse
    {
        if ($cart->isEmpty()) {
            return redirect()
                ->route('rental.cart')
                ->with('error', 'Keranjang masih kosong. Pilih alat terlebih dahulu.');
        }

        return view('rental.checkout', [
            'items' => $cart->items(),
            'mulai' => $cart->mulai(),
            'selesai' => $cart->selesai(),
            'durasi' => $cart->durasiHari(),
            'subtotal' => $cart->subtotal(),
            'biayaLayanan' => $cart->biayaLayanan(),
            'total' => $cart->total(),
        ]);
    }

    public function store(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->isEmpty()) {
            return redirect()->route('rental.cart')->with('error', 'Keranjang masih kosong.');
        }

        $validated = $request->validate([
            'nama_ketua' => ['required', 'string', 'max:120'],
            'telepon_ketua' => ['required', 'string', 'max:30'],
            'email_ketua' => ['required', 'email', 'max:120'],
            'nik_ketua' => ['required', 'digits:16'],
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
            'setuju' => ['accepted'],
        ], [
            'nik_ketua.digits' => 'NIK harus 16 digit angka sesuai KTP.',
            'setuju.accepted' => 'Anda harus menyetujui syarat & ketentuan sebelum membayar.',
            'foto_ktp.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        $pathKtp = $request->file('foto_ktp')?->store('ktp', 'local');

        $pemesanan = DB::transaction(function () use ($validated, $pathKtp, $cart): Pemesanan {
            $pemesanan = Pemesanan::create([
                'kode_pemesanan' => 'TMP-'.uniqid(),
                'pelanggan_id' => auth()->id(),
                'nama_ketua' => $validated['nama_ketua'],
                'email_ketua' => $validated['email_ketua'],
                'telepon_ketua' => $validated['telepon_ketua'],
                'nik_ketua' => $validated['nik_ketua'],
                'path_foto_ktp' => $pathKtp,
                'tanggal_mulai' => $cart->mulai()->toDateString(),
                'tanggal_selesai' => $cart->selesai()->toDateString(),
                'total_hari' => $cart->durasiHari(),
                'total_tagihan' => $cart->total(),
                'status' => 'pending',
            ]);

            $kode = 'RJN-'.now()->format('Y').'-'.str_pad((string) $pemesanan->id, 4, '0', STR_PAD_LEFT);
            $pemesanan->update(['kode_pemesanan' => $kode]);

            foreach ($cart->items() as $item) {
                $pemesanan->items()->create([
                    'peralatan_id' => $item['peralatan']->id,
                    'jumlah' => $item['jumlah'],
                    'tarif_per_hari_snapshot' => $item['peralatan']->tarif_harian,
                    'subtotal' => $item['subtotal'],
                ]);
            }

            Pembayaran::create([
                'pemesanan_id' => $pemesanan->id,
                'referensi_pembayaran' => 'QRIS-'.$kode,
                'nominal' => $cart->total(),
                'status_pembayaran' => 'pending',
                'kedaluwarsa_pada' => now()->addMinutes(15),
            ]);

            return $pemesanan;
        });

        $cart->kosongkan();

        return redirect()->route('rental.payment', $pemesanan->kode_pemesanan);
    }
}
