<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\Rupiah;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PartnerDashboardController extends PartnerController
{
    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        $pencarian = trim($request->string('q')->toString());
        $kategori = $request->string('kategori')->toString();
        $urutkan = $request->string('urutkan')->toString();

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

        match ($urutkan) {
            'termurah' => $query->orderBy('tarif_harian'),
            'termahal' => $query->orderByDesc('tarif_harian'),
            'stok' => $query->orderByDesc('jumlah_stok'),
            'nama' => $query->orderBy('nama'),
            default => $query->latest('updated_at'),
        };

        return view('rental.partner.dashboard', [
            'toko' => $toko,
            'stats' => $this->ringkasanStok($toko),
            'peralatan' => $query->paginate(8)->withQueryString(),
            'pencarian' => $pencarian,
            'kategori' => $kategori,
            'urutkan' => $urutkan,
            'daftarKategori' => Peralatan::query()
                ->where('toko_rental_id', $toko->id)
                ->whereNotNull('kategori')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori'),
            'sedangDikemas' => $this->pesananPerluTindakan($toko),
        ]);
    }

    public function segeraHadir(Request $request, string $judul, string $ikon): View
    {
        return view('rental.partner.placeholder', [
            'toko' => $this->toko($request),
            'judul' => $judul,
            'ikon' => $ikon,
        ]);
    }

    public function verifikasi(Request $request): View
    {
        $toko = $request->user()->tokoRental()->first();

        return view('rental.partner.verification', [
            'toko' => $toko,
        ])->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $toko = $this->toko($request);
        $peralatan = Peralatan::query()->where('toko_rental_id', $toko->id)->orderBy('nama')->get();

        $namaBerkas = 'inventaris-'.str($toko->nama_toko)->slug().'-'.now()->format('Ymd').'.csv';

        return response()->streamDownload(function () use ($peralatan): void {
            $keluaran = fopen('php://output', 'w');
            fputcsv($keluaran, ['Nama Alat', 'Kategori', 'Pos', 'Tarif Harian', 'Jumlah Stok', 'Kondisi']);

            foreach ($peralatan as $alat) {
                $kondisi = match (true) {
                    $alat->jumlah_stok <= 0 => 'Habis',
                    $alat->jumlah_stok <= 3 => 'Terbatas',
                    default => 'Baik',
                };

                fputcsv($keluaran, [
                    $alat->nama,
                    $alat->kategori ?? '-',
                    $alat->pos ?? '-',
                    Rupiah::format($alat->tarif_harian),
                    $alat->jumlah_stok,
                    $kondisi,
                ]);
            }

            fclose($keluaran);
        }, $namaBerkas, ['Content-Type' => 'text/csv']);
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
