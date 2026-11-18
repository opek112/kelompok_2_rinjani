<?php

namespace Modules\Rental\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\Cart;

class RentalController extends Controller
{
    public function index(Request $request): View
    {
        $kategori = $request->string('kategori')->toString();
        $pos = $request->string('pos')->toString();
        $pencarian = trim($request->string('q')->toString());
        $urutkan = $request->string('urutkan')->toString();
        $tokoId = $request->integer('toko');
        $hargaMaksimal = $request->integer('maksimal');
        $tampil = max(6, min(36, $request->integer('tampil', 6)));

        $query = Peralatan::query()->with('toko')->where('jumlah_stok', '>', 0);

        if ($pencarian !== '') {
            $query->where(function ($builder) use ($pencarian): void {
                $builder->where('nama', 'like', "%{$pencarian}%")
                    ->orWhere('deskripsi', 'like', "%{$pencarian}%");
            });
        }

        if ($kategori !== '' && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        if ($pos !== '' && $pos !== 'Semua') {
            $query->where('pos', $pos);
        }

        if ($tokoId > 0) {
            $query->where('toko_rental_id', $tokoId);
        }

        if ($hargaMaksimal > 0) {
            $query->where('tarif_harian', '<=', $hargaMaksimal);
        }

        match ($urutkan) {
            'termurah' => $query->orderBy('tarif_harian'),
            'termahal' => $query->orderByDesc('tarif_harian'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('sorotan')->orderBy('id'),
        };

        $total = (clone $query)->count();
        $peralatan = $query->limit($tampil)->get();

        return view('rental.catalog', [
            'peralatan' => $peralatan,
            'total' => $total,
            'tampil' => $tampil,
            'tampilBerikutnya' => min(36, $tampil + 6),
            'pencarian' => $pencarian,
            'kategoriAktif' => $kategori,
            'posAktif' => $pos,
            'urutkan' => $urutkan,
            'tokoId' => $tokoId,
            'hargaMaksimal' => $hargaMaksimal,
            'daftarKategori' => Peralatan::query()->select('kategori')->distinct()->orderBy('kategori')->pluck('kategori')->filter()->values(),
            'daftarPos' => Peralatan::query()->select('pos')->distinct()->orderBy('pos')->pluck('pos')->filter()->values(),
            'daftarToko' => TokoRental::query()->where('status', 'active')->orderBy('nama_toko')->get(),
        ]);
    }

    public function show(Peralatan $peralatan): View
    {
        $peralatan->load('toko');

        $serupa = Peralatan::query()
            ->with('toko')
            ->where('id', '!=', $peralatan->id)
            ->where(function ($query) use ($peralatan): void {
                $query->where('toko_rental_id', $peralatan->toko_rental_id)
                    ->orWhere('kategori', $peralatan->kategori);
            })
            ->where('jumlah_stok', '>', 0)
            ->limit(3)
            ->get();

        return view('rental.detail', [
            'peralatan' => $peralatan,
            'serupa' => $serupa,
            'ulasan' => $this->ulasanContoh(),
            'galeri' => $peralatan->galeriFoto(),
        ]);
    }

    public function addToCart(Request $request, Peralatan $peralatan, Cart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:'.$peralatan->jumlah_stok],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'aksi' => ['nullable', 'in:keranjang,langsung'],
        ], [
            'jumlah.max' => 'Jumlah melebihi stok yang tersedia ('.$peralatan->jumlah_stok.' unit).',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $cart->aturTanggal($validated['tanggal_mulai'], $validated['tanggal_selesai']);
        $cart->tambah($peralatan, $validated['jumlah']);

        if (($validated['aksi'] ?? 'keranjang') === 'langsung') {
            return redirect()->route('rental.checkout');
        }

        return redirect()
            ->route('rental.cart')
            ->with('status', $peralatan->nama.' berhasil ditambahkan ke keranjang.');
    }

    /**
     * @return array<int, array{nama: string, inisial: string, tanggal: string, rating: int, isi: string}>
     */
    private function ulasanContoh(): array
    {
        return [
            [
                'nama' => 'Andi Pratama',
                'inisial' => 'AP',
                'tanggal' => '12 Mei 2026',
                'rating' => 5,
                'isi' => 'Tenda kokoh, tidak bocor semalam hujan. Serah terima di pos Sembalun sangat cepat.',
            ],
            [
                'nama' => 'Sarah Wijaya',
                'inisial' => 'SW',
                'tanggal' => '28 April 2026',
                'rating' => 5,
                'isi' => 'Kondisi bersih dan wangi. Penjaga toko membantu cek kelengkapan sebelum kami naik.',
            ],
            [
                'nama' => 'Budi Hartono',
                'inisial' => 'BH',
                'tanggal' => '3 April 2026',
                'rating' => 4,
                'isi' => 'Sesuai deskripsi dan foto. Pengembalian di pos registrasi tidak ribet sama sekali.',
            ],
        ];
    }
}
