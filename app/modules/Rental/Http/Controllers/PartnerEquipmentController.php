<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;

class PartnerEquipmentController extends PartnerController
{
    public function create(Request $request): View
    {
        $toko = $this->toko($request);

        return view('rental.partner.equipment', [
            'toko' => $toko,
            'peralatan' => new Peralatan([
                'kategori' => 'Tenda',
                'pos' => $this->posToko($toko),
                'jumlah_stok' => 1,
                'tarif_harian' => 0,
            ]),
            'daftarKategori' => $this->daftarKategori($toko),
            'daftarPos' => $this->daftarPos(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $data = $this->validasi($request);
        $data['toko_rental_id'] = $toko->id;

        Peralatan::create($data);

        return redirect()
            ->route('rental.dashboard')
            ->with('success', $data['nama'].' berhasil ditambahkan ke inventaris.');
    }

    public function edit(Request $request, Peralatan $peralatan): View
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $peralatan);

        return view('rental.partner.equipment', [
            'toko' => $toko,
            'peralatan' => $peralatan,
            'daftarKategori' => $this->daftarKategori($toko),
            'daftarPos' => $this->daftarPos(),
        ]);
    }

    public function update(Request $request, Peralatan $peralatan): RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $peralatan);

        $peralatan->update($this->validasi($request));

        return redirect()
            ->route('rental.dashboard')
            ->with('success', 'Data '.$peralatan->nama.' berhasil diperbarui.');
    }

    public function destroy(Request $request, Peralatan $peralatan): RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $peralatan);

        if (ItemPemesanan::query()->where('peralatan_id', $peralatan->id)->exists()) {
            return redirect()
                ->route('rental.dashboard')
                ->with('error', 'Alat ini sudah pernah dipesan. Ubah stok menjadi 0 alih-alih menghapusnya.');
        }

        $nama = $peralatan->nama;
        $peralatan->delete();

        return redirect()
            ->route('rental.dashboard')
            ->with('success', $nama.' dihapus dari inventaris.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'pos' => ['required', 'string', 'max:100'],
            'tarif_harian' => ['required', 'numeric', 'min:0'],
            'jumlah_stok' => ['required', 'integer', 'min:0', 'max:9999'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'kapasitas' => ['nullable', 'string', 'max:100'],
            'berat' => ['nullable', 'string', 'max:100'],
            'material' => ['nullable', 'string', 'max:100'],
            'dimensi' => ['nullable', 'string', 'max:100'],
            'path_gambar' => ['nullable', 'url', 'max:500'],
        ], [
            'path_gambar.url' => 'Tautan foto harus berupa URL yang valid (https://...).',
        ]);

        $data['sorotan'] = $request->boolean('sorotan');

        return $data;
    }

    private function pastikanMilikToko(TokoRental $toko, Peralatan $peralatan): void
    {
        abort_unless($peralatan->toko_rental_id === $toko->id, 404);
    }

    /**
     * @return Collection<int, string>
     */
    private function daftarKategori(TokoRental $toko)
    {
        return Peralatan::query()
            ->where('toko_rental_id', $toko->id)
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->merge(['Tenda', 'Sleeping Bag', 'Matras', 'Alat Masak', 'Carrier', 'Aksesoris', 'Pakaian'])
            ->unique()
            ->values();
    }

    /**
     * @return array<int, string>
     */
    private function daftarPos(): array
    {
        return ['Sembalun', 'Senaru', 'Torean', 'Timbanuh', 'Aik Berik'];
    }

    private function posToko(TokoRental $toko): string
    {
        $pos = Peralatan::query()
            ->where('toko_rental_id', $toko->id)
            ->whereNotNull('pos')
            ->value('pos');

        return $pos ?: 'Sembalun';
    }
}
