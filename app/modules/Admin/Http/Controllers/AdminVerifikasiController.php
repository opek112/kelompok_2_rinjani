<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Guide\Models\Pemandu;
use Modules\Rental\Models\TokoRental;

class AdminVerifikasiController extends Controller
{
    public function index()
    {
        $pemanduPending = Pemandu::with('user')->where('status', 'pending')->latest()->get();
        $rentalPending = TokoRental::with('user')->where('status', 'pending')->latest()->get();
        $totalPending = $pemanduPending->count() + $rentalPending->count();

        return view('admin::verifikasi', compact('pemanduPending', 'rentalPending', 'totalPending'));
    }

    public function updateStatusPemandu(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:active,rejected']);

        $pemandu = Pemandu::findOrFail($id);
        $pemandu->update(['status' => $request->status]);

        $pesan = $request->status === 'active' ? 'Pemandu berhasil disetujui.' : 'Pemandu ditolak.';
        return redirect()->back()->with('success', $pesan);
    }

    public function updateStatusRental(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:active,rejected']);

        $rental = TokoRental::findOrFail($id);
        $rental->update(['status' => $request->status]);

        $pesan = $request->status === 'active' ? 'Toko Rental berhasil disetujui.' : 'Toko Rental ditolak.';
        return redirect()->back()->with('success', $pesan);
    }
}