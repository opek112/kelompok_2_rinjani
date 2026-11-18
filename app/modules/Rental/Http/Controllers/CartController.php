<?php

namespace Modules\Rental\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Support\Cart;

class CartController extends Controller
{
    public function index(Cart $cart): View
    {
        return view('rental.cart', [
            'items' => $cart->items(),
            'mulai' => $cart->mulai(),
            'selesai' => $cart->selesai(),
            'durasi' => $cart->durasiHari(),
            'subtotal' => $cart->subtotal(),
            'biayaLayanan' => $cart->biayaLayanan(),
            'total' => $cart->total(),
        ]);
    }

    public function update(Request $request, Peralatan $peralatan, Cart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:'.$peralatan->jumlah_stok],
        ]);

        $cart->ubahJumlah($peralatan, $validated['jumlah']);

        return redirect()->route('rental.cart');
    }

    public function destroy(Peralatan $peralatan, Cart $cart): RedirectResponse
    {
        $cart->hapus($peralatan->id);

        return redirect()
            ->route('rental.cart')
            ->with('status', $peralatan->nama.' dihapus dari keranjang.');
    }

    public function dates(Request $request, Cart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $cart->aturTanggal($validated['tanggal_mulai'], $validated['tanggal_selesai']);

        return redirect()->route('rental.cart')->with('status', 'Jadwal sewa diperbarui.');
    }
}
