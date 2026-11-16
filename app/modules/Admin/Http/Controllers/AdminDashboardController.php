<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;
use Modules\Rental\Models\TokoRental;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->peran !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak!');
        }

        $totalTransaksi = Pemesanan::count();
        $totalOmzet = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('total_tagihan');
        $totalKomisi = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('nominal_komisi');
        $totalPemandu = Pemandu::where('status', 'active')->count();
        $totalRental = TokoRental::where('status', 'active')->count();

        $transaksiTerbaru = Pemesanan::with(['pelanggan', 'pemandu.user'])
            ->latest()
            ->take(5)
            ->get();

        $aktivitasTerbaru = Pemesanan::latest()->take(3)->get();

        return view('admin::dashboard', compact(
            'totalTransaksi',
            'totalOmzet',
            'totalKomisi',
            'totalPemandu',
            'totalRental',
            'transaksiTerbaru',
            'aktivitasTerbaru'
        ));
    }

    public function verifikasi()
    {
        return view('admin::verifikasi');
    }
}
