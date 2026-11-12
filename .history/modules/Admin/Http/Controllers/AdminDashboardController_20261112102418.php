<?php

namespace Modules\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Pemandu;
use App\Models\Pemesanan;
use App\Models\TokoRental;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Cek Keamanan (Pastikan yang masuk hanya Admin)
        if (Auth::user()->peran !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak!');
        }

        // 2. Hitung Data Statistik
        $totalTransaksi = Pemesanan::count();

        // Total Omzet (Hanya hitung yang statusnya 'paid' atau 'completed')
        $totalOmzet = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('total_tagihan');

        // Total Komisi (Hanya hitung yang statusnya 'paid' atau 'completed')
        $totalKomisi = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('nominal_komisi');

        // Hitung Mitra yang statusnya aktif
        $totalPemandu = Pemandu::where('status', 'active')->count();
        $totalRental = TokoRental::where('status', 'active')->count();

        // 3. Ambil 5 Transaksi Terbaru
        $transaksiTerbaru = Pemesanan::with(['pelanggan', 'pemandu.user'])
            ->latest()
            ->take(5)
            ->get();

        // --- Aktivitas Terbaru (Sementara kita ambil dari 3 pemesanan terakhir) ---
        $aktivitasTerbaru = Pemesanan::latest()->take(3)->get();

        // 4. Lempar data ke view (admin-dashboard.blade.php)
        return view('admin.dashboard', compact(
            'totalTransaksi',
            'totalOmzet',
            'totalKomisi',
            'totalPemandu',
            'totalRental',
            'transaksiTerbaru',
            'aktivitasTerbaru'
        ));
    }
}
