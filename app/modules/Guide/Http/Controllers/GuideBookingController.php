<?php

namespace Modules\Guide\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Admin\Models\PengaturanPlatform;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;
use Modules\Guide\Services\KetersediaanService;
use Modules\Payment\Models\Pembayaran;

class GuideBookingController extends Controller
{
    private const BIAYA_LAYANAN = 5000;

    private const MAKS_HARI = 30;

    public function create(Request $request, Pemandu $pemandu): View
    {
        abort_unless($pemandu->status === 'active', 404);

        $pemandu->load(['user', 'rutes']);

        $mulai = $this->tanggal($request->query('tanggal_mulai'), today()->addDay());
        $selesai = $this->tanggal($request->query('tanggal_selesai'), $mulai->copy()->addDays(2));

        if ($selesai->lt($mulai)) {
            $selesai = $mulai->copy();
        }

        return view('guide.booking', [
            'pemandu' => $pemandu,
            'mulai' => $mulai,
            'selesai' => $selesai,
        ]);
    }

    public function store(Request $request, Pemandu $pemandu): RedirectResponse
    {
        abort_unless($pemandu->status === 'active', 404);

        $pemandu->load('rutes');

        $data = $request->validate([
            'rute' => ['required', 'string', 'max:50'],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'nama_ketua' => ['required', 'string', 'max:120'],
            'telepon_ketua' => ['required', 'string', 'max:30'],
            'email_ketua' => ['required', 'email', 'max:120'],
            'nik_ketua' => ['required', 'digits:16'],
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
            'setuju' => ['accepted'],
        ], [
            'nik_ketua.digits' => 'NIK harus 16 digit angka sesuai KTP.',
            'setuju.accepted' => 'Anda harus menyetujui syarat & ketentuan sebelum membayar.',
            'foto_ktp.max' => 'Ukuran file maksimal 2 MB.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        ]);

        if (! in_array($data['rute'], $pemandu->ruteList(), true)) {
            throw ValidationException::withMessages([
                'rute' => 'Jalur yang dipilih tidak dikuasai pemandu ini.',
            ]);
        }

        $mulai = Carbon::parse($data['tanggal_mulai'])->startOfDay();
        $selesai = Carbon::parse($data['tanggal_selesai'])->startOfDay();
        $hari = (int) $mulai->diffInDays($selesai) + 1;

        if ($hari > self::MAKS_HARI) {
            throw ValidationException::withMessages([
                'tanggal_selesai' => 'Durasi pendampingan maksimal '.self::MAKS_HARI.' hari.',
            ]);
        }

        $pathKtp = $request->file('foto_ktp')?->store('ktp', 'local');

        $pemesanan = DB::transaction(function () use ($pemandu, $data, $mulai, $selesai, $hari, $pathKtp): Pemesanan {
            $terkunci = Pemandu::query()->whereKey($pemandu->id)->lockForUpdate()->firstOrFail();

            if (! KetersediaanService::tersedia($terkunci->id, $mulai, $selesai)) {
                throw ValidationException::withMessages([
                    'tanggal_mulai' => 'Tanggal tersebut sudah dipesan atau ditandai libur. Silakan pilih tanggal lain.',
                ]);
            }

            $biaya = round((float) $terkunci->tarif_harian * $hari, 2);
            $persen = PengaturanPlatform::getKomisi();
            $komisi = round($biaya * $persen / 100, 2);
            $total = $biaya + self::BIAYA_LAYANAN;

            $pemesanan = Pemesanan::create([
                'kode_pemesanan' => 'TMP-'.uniqid(),
                'pelanggan_id' => auth()->id(),
                'pemandu_id' => $terkunci->id,
                'rute' => $data['rute'],
                'nama_ketua' => $data['nama_ketua'],
                'email_ketua' => $data['email_ketua'],
                'telepon_ketua' => $data['telepon_ketua'],
                'nik_ketua' => $data['nik_ketua'],
                'path_foto_ktp' => $pathKtp,
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $selesai->toDateString(),
                'total_hari' => $hari,
                'biaya_pemandu_snapshot' => $biaya,
                'persentase_komisi' => $persen,
                'nominal_komisi' => $komisi,
                'total_tagihan' => $total,
                'status' => 'pending',
            ]);

            $kode = 'RJN-'.now()->format('Y').'-'.str_pad((string) $pemesanan->id, 4, '0', STR_PAD_LEFT);
            $pemesanan->update(['kode_pemesanan' => $kode]);

            Pembayaran::create([
                'pemesanan_id' => $pemesanan->id,
                'referensi_pembayaran' => 'QRIS-'.$kode,
                'nominal' => $total,
                'status_pembayaran' => 'pending',
                'kedaluwarsa_pada' => now()->addMinutes(15),
            ]);

            return $pemesanan;
        });

        return redirect()->route('rental.payment', $pemesanan->kode_pemesanan);
    }

    private function tanggal(mixed $nilai, Carbon $cadangan): Carbon
    {
        if (is_string($nilai) && $nilai !== '') {
            try {
                return Carbon::parse($nilai)->startOfDay();
            } catch (\Exception) {
                return $cadangan;
            }
        }

        return $cadangan;
    }
}
