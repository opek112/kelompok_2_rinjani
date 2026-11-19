<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Guide\Models\Pemandu;
use Modules\Rental\Models\Peralatan;

class AdminKatalogController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'jenis' => ['sometimes', 'in:pemandu,alat'],
        ]);
        $jenis = $validated['jenis'] ?? 'pemandu';
        $totalPemandu = Pemandu::count();
        $totalPeralatan = Peralatan::count();

        if ($jenis === 'alat') {
            $peralatan = Peralatan::with('toko')->latest()->paginate(10)->withQueryString();

            return view('admin::moderasi-katalog', compact(
                'jenis',
                'totalPemandu',
                'totalPeralatan',
                'peralatan'
            ));
        }

        $pemandu = Pemandu::with('user')->latest()->paginate(10)->withQueryString();

        return view('admin::moderasi-katalog', compact(
            'jenis',
            'totalPemandu',
            'totalPeralatan',
            'pemandu'
        ));
    }
}
