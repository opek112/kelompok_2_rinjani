<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Booking\Models\Pemesanan;

class AdminRekapController extends Controller
{
    public function index()
    {
        $totalTransaksi = Pemesanan::count();
        $totalOmzet = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('total_tagihan');
        $totalKomisi = Pemesanan::whereIn('status', ['paid', 'completed'])->sum('nominal_komisi');

        $transaksis = Pemesanan::with(['pelanggan', 'pemandu.user'])
            ->latest()
            ->paginate(10);

        return view('admin::rekap-transaksi', compact(
            'totalTransaksi',
            'totalOmzet',
            'totalKomisi',
            'transaksis'
        ));
    }

    public function exportCsv()
    {
        $fileName = 'rekap_transaksi_'.date('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $transaksis = Pemesanan::with('pelanggan')->latest()->get();

        $columns = ['Kode Pesanan', 'Tanggal', 'Nama Pemesan', 'Total Tagihan', 'Komisi Platform', 'Status'];

        $callback = function () use ($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transaksis as $trx) {
                $row = [
                    $trx->kode_pemesanan,
                    $trx->created_at->format('Y-m-d H:i'),
                    $trx->pelanggan ? $trx->pelanggan->nama : $trx->nama_ketua,
                    $trx->total_tagihan,
                    $trx->nominal_komisi,
                    $trx->status,
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
