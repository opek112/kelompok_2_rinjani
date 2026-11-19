<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;
use Modules\Payment\Models\LogPembayaran;
use Modules\Payment\Models\Pembayaran;
use Modules\Rental\Models\TokoRental;

class AdminActivityController extends Controller
{
    public function notifications(): View
    {
        $notifikasi = collect();

        Pemandu::with('user:id,nama')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get()
            ->each(function (Pemandu $pemandu) use ($notifikasi): void {
                $notifikasi->push([
                    'judul' => 'Pendaftaran pemandu baru',
                    'deskripsi' => ($pemandu->user?->nama ?? 'Pemandu')
                        .' menunggu verifikasi.',
                    'waktu' => $pemandu->created_at,
                    'tautan' => route('admin.verifikasi'),
                    'jenis' => 'Verifikasi',
                ]);
            });

        TokoRental::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get()
            ->each(function (TokoRental $rental) use ($notifikasi): void {
                $notifikasi->push([
                    'judul' => 'Pendaftaran rental baru',
                    'deskripsi' => $rental->nama_toko.' menunggu verifikasi.',
                    'waktu' => $rental->created_at,
                    'tautan' => route('admin.verifikasi'),
                    'jenis' => 'Verifikasi',
                ]);
            });

        Pemesanan::whereIn('status', ['paid', 'completed'])
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->each(function (Pemesanan $pemesanan) use ($notifikasi): void {
                $notifikasi->push([
                    'judul' => 'Transaksi berhasil',
                    'deskripsi' => $pemesanan->kode_pemesanan.' telah dibayar.',
                    'waktu' => $pemesanan->updated_at,
                    'tautan' => route('admin.rekap-transaksi'),
                    'jenis' => 'Transaksi',
                ]);
            });

        Pembayaran::with('pemesanan')
            ->whereIn('status_pembayaran', ['failure', 'expire'])
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->each(function (Pembayaran $pembayaran) use ($notifikasi): void {
                $notifikasi->push([
                    'judul' => 'Pembayaran tidak berhasil',
                    'deskripsi' => ($pembayaran->pemesanan?->kode_pemesanan ?? 'Pembayaran')
                        .' berstatus '.$pembayaran->status_pembayaran.'.',
                    'waktu' => $pembayaran->updated_at,
                    'tautan' => route('admin.rekap-transaksi'),
                    'jenis' => 'Pembayaran',
                ]);
            });

        $notifikasi = $notifikasi->sortByDesc('waktu')->take(12)->values();

        return view('admin::notifikasi', compact('notifikasi'));
    }

    public function auditLog(): View
    {
        $totalLogHariIni = LogPembayaran::whereDate('created_at', today())->count();
        $webhookValidHariIni = LogPembayaran::whereDate('created_at', today())
            ->where('tanda_tangan_valid', true)
            ->count();
        $pembayaranGagalHariIni = Pembayaran::whereIn('status_pembayaran', ['failure', 'expire'])
            ->whereDate('updated_at', today())
            ->count();
        $logPembayaran = LogPembayaran::with('pembayaran.pemesanan')
            ->latest()
            ->paginate(20);

        return view('admin::log-audit', compact(
            'totalLogHariIni',
            'webhookValidHariIni',
            'pembayaranGagalHariIni',
            'logPembayaran'
        ));
    }
}
