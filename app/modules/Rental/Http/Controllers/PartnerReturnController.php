<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\PengembalianPeralatan;
use Modules\Rental\Models\TokoRental;

class PartnerReturnController extends PartnerController
{
    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        $menunggu = $this->basis($toko)
            ->where('status', 'paid')
            ->whereNotNull('waktu_serah_terima')
            ->with(['items.peralatan', 'items.pengembalian'])
            ->orderBy('tanggal_selesai')
            ->get();

        $riwayat = $this->basis($toko)
            ->where('status', 'completed')
            ->whereNotNull('waktu_pengembalian')
            ->with(['items.peralatan'])
            ->latest('waktu_pengembalian')
            ->take(6)
            ->get();

        $terlambat = $menunggu->filter(fn (Pemesanan $pesanan) => $pesanan->tanggal_selesai->lt(today()))->count();

        return view('rental.partner.returns', [
            'toko' => $toko,
            'menunggu' => $menunggu,
            'riwayat' => $riwayat,
            'terlambat' => $terlambat,
            'totalDenda' => (float) $this->basis($toko)->where('status', 'completed')->sum('denda_total'),
        ]);
    }

    public function show(Request $request, Pemesanan $pemesanan): View|RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $pemesanan);

        if ($pemesanan->status === 'completed' && $pemesanan->waktu_pengembalian !== null) {
            $pemesanan->load(['items.peralatan', 'items.pengembalian']);

            return view('rental.partner.return-receipt', [
                'toko' => $toko,
                'pesanan' => $pemesanan,
            ]);
        }

        if ($pemesanan->status !== 'paid' || $pemesanan->waktu_serah_terima === null) {
            return redirect()
                ->route('rental.returns')
                ->with('error', 'Pesanan '.$pemesanan->kode_pemesanan.' belum melewati serah terima, pengembalian belum bisa dicatat.');
        }

        $pemesanan->load(['items.peralatan', 'items.pengembalian']);

        return view('rental.partner.return-form', [
            'toko' => $toko,
            'pesanan' => $pemesanan,
            'terlambat' => $pemesanan->tanggal_selesai->lt(today()),
        ]);
    }

    public function store(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $toko = $this->toko($request);
        $this->pastikanMilikToko($toko, $pemesanan);

        if ($pemesanan->status !== 'paid' || $pemesanan->waktu_serah_terima === null) {
            return back()->with('error', 'Pesanan ini belum melewati serah terima, pengembalian belum bisa dicatat.');
        }

        if ($pemesanan->waktu_pengembalian !== null) {
            return back()->with('error', 'Pengembalian untuk pesanan ini sudah tercatat.');
        }

        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.baik' => ['nullable', 'integer', 'min:0', 'max:999'],
            'items.*.rusak' => ['nullable', 'integer', 'min:0', 'max:999'],
            'items.*.hilang' => ['nullable', 'integer', 'min:0', 'max:999'],
            'items.*.catatan' => ['nullable', 'string', 'max:300'],
            'items.*.denda' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'checklist' => ['required', 'array', 'min:4'],
        ], [
            'checklist.required' => 'Centang seluruh checklist pengembalian sebelum menyimpan.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 3 MB.',
            'foto.*.image' => 'Foto bukti harus berupa gambar JPG, PNG, atau WEBP.',
        ]);

        $items = $pemesanan->items()->with('peralatan')->get();
        $catatanPerItem = [];

        foreach ($items as $item) {
            $baris = $data['items'][$item->id] ?? [];
            $jumlah = (int) ($baris['baik'] ?? 0) + (int) ($baris['rusak'] ?? 0) + (int) ($baris['hilang'] ?? 0);

            if ($jumlah > $item->jumlah) {
                $catatanPerItem[] = ($item->peralatan?->nama ?? 'Alat').': jumlah dikembalikan ('.$jumlah.') melebihi jumlah disewa ('.$item->jumlah.').';
            }
        }

        if ($catatanPerItem !== []) {
            return back()
                ->withErrors(['items' => $catatanPerItem])
                ->withInput();
        }

        $fotoBaru = collect($request->file('foto') ?? [])
            ->map(fn ($berkas) => $berkas->store('pengembalian/'.$pemesanan->kode_pemesanan, 'public'))
            ->all();

        DB::transaction(function () use ($pemesanan, $items, $data, $fotoBaru): void {
            $totalDenda = 0;

            foreach ($items as $item) {
                $baris = $data['items'][$item->id] ?? [];
                $denda = (float) ($baris['denda'] ?? 0);
                $totalDenda += $denda;

                PengembalianPeralatan::updateOrCreate(
                    ['item_pemesanan_id' => $item->id],
                    [
                        'jumlah_baik' => (int) ($baris['baik'] ?? 0),
                        'jumlah_rusak' => (int) ($baris['rusak'] ?? 0),
                        'jumlah_hilang' => (int) ($baris['hilang'] ?? 0),
                        'catatan' => $baris['catatan'] ?? null,
                        'denda' => $denda,
                    ],
                );
            }

            $pemesanan->update([
                'status' => 'completed',
                'waktu_pengembalian' => now(),
                'catatan_pengembalian' => $data['catatan'] ?? null,
                'foto_pengembalian' => $fotoBaru === [] ? null : $fotoBaru,
                'denda_total' => $totalDenda,
            ]);
        });

        return redirect()
            ->route('rental.returns.show', $pemesanan)
            ->with('success', 'Pengembalian '.$pemesanan->kode_pemesanan.' berhasil dicatat.');
    }

    private function basis(TokoRental $toko)
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id));
    }

    private function pastikanMilikToko(TokoRental $toko, Pemesanan $pemesanan): void
    {
        $milikToko = ItemPemesanan::query()
            ->where('pemesanan_id', $pemesanan->id)
            ->whereHas('peralatan', fn ($query) => $query->where('toko_rental_id', $toko->id))
            ->exists();

        abort_unless($milikToko, 404);
    }
}
