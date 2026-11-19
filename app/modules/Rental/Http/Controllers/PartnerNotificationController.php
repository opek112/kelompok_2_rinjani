<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Support\NotifikasiToko;

class PartnerNotificationController extends PartnerController
{
    public const TAB = ['semua', 'belum', 'sudah'];

    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        $tab = $request->string('tab')->toString();
        if (! in_array($tab, self::TAB, true)) {
            $tab = 'semua';
        }

        $dibaca = collect($toko->notifikasi_dibaca ?? [])->all();
        $semua = NotifikasiToko::daftar($toko);

        $notifikasi = match ($tab) {
            'belum' => $semua->reject(fn (array $item) => in_array($item['id'], $dibaca, true)),
            'sudah' => $semua->filter(fn (array $item) => in_array($item['id'], $dibaca, true)),
            default => $semua,
        };

        return view('rental.partner.notifications', [
            'toko' => $toko,
            'tab' => $tab,
            'notifikasi' => $notifikasi->values(),
            'jumlah' => [
                'semua' => $semua->count(),
                'belum' => $semua->reject(fn (array $item) => in_array($item['id'], $dibaca, true))->count(),
                'sudah' => $semua->filter(fn (array $item) => in_array($item['id'], $dibaca, true))->count(),
            ],
            'dibaca' => $dibaca,
            'sedangDikemas' => $this->pesananPerluTindakan($toko->id),
        ]);
    }

    public function bacaSemua(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        NotifikasiToko::tandai($toko);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function baca(Request $request, string $id): RedirectResponse
    {
        $toko = $this->toko($request);

        NotifikasiToko::tandai($toko, $id);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    private function pesananPerluTindakan(int $tokoId): int
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $tokoId))
            ->where('status', 'paid')
            ->whereNull('waktu_serah_terima')
            ->count();
    }
}
