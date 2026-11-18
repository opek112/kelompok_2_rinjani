<?php

namespace Modules\Guide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Guide\Models\Pemandu;
use Modules\Guide\Models\RutePemandu;
use Modules\Guide\Services\KetersediaanService;

class GuideCatalogController extends Controller
{
    public const BAHASA = ['Indonesia', 'Inggris', 'Mandarin', 'Jepang', 'Arab', 'Prancis'];

    public function index(Request $request): View
    {
        $filter = $request->validate([
            'rute' => ['nullable', 'string', 'max:50'],
            'bahasa' => ['nullable', 'string', 'max:50'],
            'tarif_min' => ['nullable', 'numeric', 'min:0'],
            'tarif_max' => ['nullable', 'numeric', 'min:0'],
        ]);

        $daftar = Pemandu::query()
            ->with(['user', 'rutes'])
            ->where('status', 'active')
            ->when($filter['rute'] ?? null, fn ($query, $rute) => $query
                ->whereHas('rutes', fn ($sub) => $sub->where('rute', $rute)))
            ->when($filter['bahasa'] ?? null, fn ($query, $bahasa) => $query
                ->where('bahasa', 'like', '%'.$bahasa.'%'))
            ->when($filter['tarif_min'] ?? null, fn ($query, $nilai) => $query
                ->where('tarif_harian', '>=', $nilai))
            ->when($filter['tarif_max'] ?? null, fn ($query, $nilai) => $query
                ->where('tarif_harian', '<=', $nilai))
            ->orderBy('tarif_harian')
            ->get();

        $ruteTersedia = RutePemandu::query()
            ->distinct()
            ->orderBy('rute')
            ->pluck('rute');

        return view('guide.catalog', [
            'daftar' => $daftar,
            'ruteTersedia' => $ruteTersedia,
            'bahasaTersedia' => self::BAHASA,
            'filter' => $filter,
        ]);
    }

    public function show(Pemandu $pemandu): View
    {
        abort_unless($pemandu->status === 'active', 404);

        $pemandu->load(['user', 'rutes']);

        $tersediaHariIni = KetersediaanService::tersedia($pemandu->id, now(), now());

        return view('guide.detail', compact('pemandu', 'tersediaHariIni'));
    }
}
