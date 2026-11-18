<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Models\PengaturanPlatform;

class AdminKomisiController extends Controller
{
    public function index()
    {
        $komisi = PengaturanPlatform::where('kunci', 'persentase_komisi')->first();
        $persentase = $komisi ? (float) $komisi->nilai : 10.00;

        $riwayat = [
            ['tanggal' => '1 Apr 2026', 'lama' => '8%', 'baru' => '10%', 'oleh' => 'Rizki Aditya'],
            ['tanggal' => '1 Jan 2026', 'lama' => '10%', 'baru' => '8%', 'oleh' => 'Rizki Aditya'],
        ];

        return view('admin::atur-komisi', compact('persentase', 'riwayat'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'persentase_komisi' => 'required|numeric|min:1|max:30',
        ]);

        PengaturanPlatform::updateOrCreate(
            ['kunci' => 'persentase_komisi'],
            ['nilai' => $request->persentase_komisi]
        );

        return redirect()->back()->with('success', 'Persentase komisi berhasil diperbarui menjadi '.$request->persentase_komisi.'%');
    }
}
