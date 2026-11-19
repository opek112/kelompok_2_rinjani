<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;
use Modules\Rental\Models\TokoRental;

class AdminDashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->peran !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak!');
        }

        $totalTransaksi = Pemesanan::count();
        $totalOmzet = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('total_tagihan');
        $totalKomisi = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('nominal_komisi');
        $totalPemandu = Pemandu::where('status', 'active')->count();
        $totalRental = TokoRental::where('status', 'active')->count();
        $totalPending = Pemandu::where('status', 'pending')->count()
            + TokoRental::where('status', 'pending')->count();

        $transaksiTerbaru = Pemesanan::with(['pelanggan', 'pemandu.user'])
            ->latest()
            ->take(5)
            ->get();

        $aktivitasTerbaru = Pemesanan::latest()->take(3)->get();
        $bulanPertama = CarbonImmutable::now()->startOfMonth()->subMonths(5);
        $dataBulanan = collect(range(0, 5))->map(function (int $offset) use ($bulanPertama): array {
            $bulan = $bulanPertama->addMonths($offset);
            $ringkasan = Pemesanan::query()
                ->whereIn('status', ['paid', 'completed'])
                ->whereBetween('created_at', [$bulan->startOfMonth(), $bulan->endOfMonth()])
                ->selectRaw('COUNT(*) as total_transaksi, COALESCE(SUM(total_tagihan), 0) as total_omzet')
                ->first();

            return [
                'label' => $bulan->locale('id')->translatedFormat('M Y'),
                'omzet' => (float) $ringkasan->total_omzet,
                'transaksi' => (int) $ringkasan->total_transaksi,
            ];
        });
        $omzetMaksimum = max(1, (float) $dataBulanan->max('omzet'));

        return view('admin::dashboard', compact(
            'totalTransaksi',
            'totalOmzet',
            'totalKomisi',
            'totalPemandu',
            'totalRental',
            'totalPending',
            'transaksiTerbaru',
            'aktivitasTerbaru',
            'dataBulanan',
            'omzetMaksimum'
        ));
    }
}
