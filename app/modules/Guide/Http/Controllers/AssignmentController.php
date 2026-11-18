<?php

namespace Modules\Guide\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Ketersediaan;

class AssignmentController extends GuideController
{
    private const TAB = ['akan_datang', 'berjalan', 'selesai'];

    public function index(Request $request): View
    {
        $pemandu = $this->pemandu();
        $tab = in_array($request->query('tab'), self::TAB, true) ? $request->query('tab') : 'akan_datang';
        $hariIni = today();

        $dasar = Pemesanan::query()
            ->with('pelanggan')
            ->where('pemandu_id', $pemandu->id)
            ->whereNotIn('status', ['cancelled', 'expired']);

        $jumlah = [
            'akan_datang' => (clone $dasar)
                ->where('status', '!=', 'completed')
                ->whereDate('tanggal_mulai', '>', $hariIni->toDateString())
                ->count(),
            'berjalan' => (clone $dasar)
                ->where('status', '!=', 'completed')
                ->whereDate('tanggal_mulai', '<=', $hariIni->toDateString())
                ->whereDate('tanggal_selesai', '>=', $hariIni->toDateString())
                ->count(),
            'selesai' => (clone $dasar)
                ->where(function ($query) use ($hariIni) {
                    $query->where('status', 'completed')
                        ->orWhereDate('tanggal_selesai', '<', $hariIni->toDateString());
                })
                ->count(),
        ];

        $daftar = (clone $dasar)
            ->when($tab === 'akan_datang', fn ($query) => $query
                ->where('status', '!=', 'completed')
                ->whereDate('tanggal_mulai', '>', $hariIni->toDateString()))
            ->when($tab === 'berjalan', fn ($query) => $query
                ->where('status', '!=', 'completed')
                ->whereDate('tanggal_mulai', '<=', $hariIni->toDateString())
                ->whereDate('tanggal_selesai', '>=', $hariIni->toDateString()))
            ->when($tab === 'selesai', fn ($query) => $query
                ->where(function ($sub) use ($hariIni) {
                    $sub->where('status', 'completed')
                        ->orWhereDate('tanggal_selesai', '<', $hariIni->toDateString());
                }))
            ->orderBy('tanggal_mulai')
            ->get();

        return view('guide.schedule', compact('pemandu', 'tab', 'daftar', 'jumlah'));
    }

    public function show(Pemesanan $pemesanan): View
    {
        $this->authorize('view', $pemesanan);

        $pemesanan->load(['pelanggan', 'pemandu.user']);

        $bolehKonfirmasi = $pemesanan->status === 'paid'
            && ! $pemesanan->kehadiran_pemandu_dikonfirmasi
            && $pemesanan->tanggal_selesai->gte(today());

        return view('guide.assignment', compact('pemesanan', 'bolehKonfirmasi'));
    }

    /**
     * Konfirmasi kehadiran pemandu di basecamp.
     */
    public function konfirmasi(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $this->authorize('view', $pemesanan);

        $request->validate([
            'checklist' => ['required', 'array', 'size:5'],
            'checklist.*' => ['in:1,2,3,4,5'],
        ], [
            'checklist.size' => 'Seluruh item checklist wajib dicentang sebelum konfirmasi.',
        ]);

        if ($pemesanan->kehadiran_pemandu_dikonfirmasi) {
            return back()->with('error', 'Kehadiran untuk pesanan ini sudah dikonfirmasi.');
        }

        if ($pemesanan->status !== 'paid') {
            return back()->with('error', 'Konfirmasi hanya dapat dilakukan untuk pesanan yang sudah dibayar.');
        }

        DB::transaction(function () use ($pemesanan) {
            $pemesanan->update([
                'kehadiran_pemandu_dikonfirmasi' => true,
                'waktu_konfirmasi_pemandu' => now(),
                'waktu_serah_terima' => $pemesanan->waktu_serah_terima ?? now(),
            ]);

            if ($pemesanan->pemandu_id !== null) {
                for ($hari = $pemesanan->tanggal_mulai->copy(); $hari->lte($pemesanan->tanggal_selesai); $hari->addDay()) {
                    Ketersediaan::updateOrCreate(
                        ['pemandu_id' => $pemesanan->pemandu_id, 'tanggal' => $hari->toDateString()],
                        ['status' => 'booked', 'pemesanan_id' => $pemesanan->id]
                    );
                }
            }
        });

        return redirect()
            ->route('guide.assignment.show', $pemesanan)
            ->with('success', 'Serah terima berhasil dikonfirmasi. Selamat mendampingi!');
    }

    /**
     * Akses berkas KTP pemesan, hanya untuk pemandu yang ditugaskan (Policy).
     */
    public function ktp(Pemesanan $pemesanan)
    {
        $this->authorize('viewKtp', $pemesanan);

        abort_unless(
            filled($pemesanan->path_foto_ktp) && Storage::disk('public')->exists($pemesanan->path_foto_ktp),
            404,
            'Berkas KTP tidak ditemukan.'
        );

        return Storage::disk('public')->response($pemesanan->path_foto_ktp);
    }
}
