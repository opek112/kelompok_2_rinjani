<?php

namespace Modules\Rental\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PartnerSettingsController extends PartnerController
{
    public const TAB = ['legalitas', 'rekening', 'keamanan', 'preferensi'];

    public const NOTIFIKASI = [
        'pesanan_baru' => 'Pesanan Baru',
        'pengembalian_terlambat' => 'Pengembalian Terlambat',
        'stok_rendah' => 'Stok Rendah',
        'promo' => 'Email Promo & Tips',
    ];

    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        $tab = $request->string('tab')->toString();
        if (! in_array($tab, self::TAB, true)) {
            $tab = 'legalitas';
        }

        return view('rental.partner.settings', [
            'toko' => $toko,
            'tab' => $tab,
            'sesi' => $this->sesiAktif($request),
            'notifikasi' => array_merge(
                array_fill_keys(array_keys(self::NOTIFIKASI), true),
                $toko->notifikasi ?? [],
            ),
            'daftarNotifikasi' => self::NOTIFIKASI,
        ]);
    }

    public function updateLegalitas(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $data = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['required', 'string', 'max:255'],
            'telepon_toko' => ['required', 'string', 'max:20'],
            'lokasi_pos' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string', 'max:300'],
            'nib' => ['nullable', 'string', 'max:100'],
            'npwp' => ['nullable', 'string', 'max:100'],
            'file_legalitas' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('file_legalitas')) {
            $data['path_berkas_legalitas'] = $request->file('file_legalitas')->store('dokumen/legalitas', 'public');
        }

        unset($data['file_legalitas']);

        $toko->update($data);

        return redirect()
            ->route('rental.settings', ['tab' => 'legalitas'])
            ->with('success', 'Data legalitas dan dokumen toko berhasil diperbarui.');
    }

    public function updateRekening(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $data = $request->validate([
            'nama_bank' => ['required', 'string', 'max:100'],
            'nomor_rekening' => ['required', 'string', 'min:6', 'max:40'],
            'nama_pemilik_rekening' => ['required', 'string', 'max:255'],
        ]);

        $data['info_rekening_bank'] = trim($data['nama_bank'].' - '.$data['nomor_rekening'].' - '.$data['nama_pemilik_rekening']);

        $toko->update($data);

        return redirect()
            ->route('rental.settings', ['tab' => 'rekening'])
            ->with('success', 'Rekening pencairan berhasil diperbarui.');
    }

    public function updateKeamanan(Request $request): RedirectResponse
    {
        $request->validate([
            'password_lama' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'password_lama.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi kata sandi baru belum sama.',
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return redirect()
            ->route('rental.settings', ['tab' => 'keamanan'])
            ->with('success', 'Kata sandi akun berhasil diperbarui.');
    }

    public function updateNotifikasi(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $pilihan = collect(array_keys(self::NOTIFIKASI))
            ->mapWithKeys(fn (string $kunci) => [$kunci => $request->boolean($kunci)])
            ->all();

        $toko->update(['notifikasi' => $pilihan]);

        return redirect()
            ->route('rental.settings', ['tab' => 'preferensi'])
            ->with('success', 'Preferensi notifikasi tersimpan.');
    }

    public function updateOperasional(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $data = $request->validate([
            'batas_stok_minimum' => ['required', 'integer', 'min:1', 'max:999'],
            'hari_buka' => ['required', 'string', 'max:100'],
            'jam_buka' => ['required', 'date_format:H:i'],
            'jam_tutup' => ['required', 'date_format:H:i', 'after:jam_buka'],
        ], [
            'jam_tutup.after' => 'Jam tutup harus lebih lambat dari jam buka.',
        ]);

        $data['auto_tutup_kosong'] = $request->boolean('auto_tutup_kosong');
        $data['tutup_hari_libur'] = $request->boolean('tutup_hari_libur');

        $toko->update($data);

        return redirect()
            ->route('rental.settings', ['tab' => 'preferensi'])
            ->with('success', 'Pengaturan stok dan jam operasional tersimpan.');
    }

    public function toggleAktif(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $toko->update(['aktif' => ! $toko->aktif]);

        return redirect()
            ->route('rental.settings', ['tab' => 'keamanan'])
            ->with('success', $toko->aktif
                ? 'Toko Anda aktif kembali dan tampil di katalog publik.'
                : 'Toko Anda dinonaktifkan dari katalog publik. Data inventaris tetap aman.');
    }

    public function akhiriSesi(Request $request, string $sesi): RedirectResponse
    {
        if ($sesi === $request->session()->getId()) {
            return back()->with('error', 'Sesi yang sedang Anda gunakan tidak dapat diakhiri dari daftar ini.');
        }

        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', $sesi)
            ->delete();

        return redirect()
            ->route('rental.settings', ['tab' => 'keamanan'])
            ->with('success', 'Sesi perangkat tersebut telah diakhiri.');
    }

    public function akhiriSesiLain(Request $request): RedirectResponse
    {
        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return redirect()
            ->route('rental.settings', ['tab' => 'keamanan'])
            ->with('success', 'Semua sesi lain berhasil diakhiri.');
    }

    /**
     * @return array<int, array{id: string, peramban: string, sistem: string, alamat: string, terakhir: string, aktif: bool}>
     */
    private function sesiAktif(Request $request): array
    {
        $sekarang = $request->session()->getId();

        return DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('last_activity')
            ->take(6)
            ->get()
            ->map(function ($baris) use ($sekarang): array {
                $agen = (string) $baris->user_agent;

                return [
                    'id' => (string) $baris->id,
                    'peramban' => match (true) {
                        str_contains($agen, 'Edg/') => 'Microsoft Edge',
                        str_contains($agen, 'Chrome/') => 'Chrome',
                        str_contains($agen, 'Firefox/') => 'Firefox',
                        str_contains($agen, 'Safari/') => 'Safari',
                        default => 'Peramban lain',
                    },
                    'sistem' => match (true) {
                        str_contains($agen, 'Android') => 'Android',
                        str_contains($agen, 'iPhone'), str_contains($agen, 'iPad') => 'iOS',
                        str_contains($agen, 'Windows') => 'Windows',
                        str_contains($agen, 'Mac OS X') => 'macOS',
                        str_contains($agen, 'Linux') => 'Linux',
                        default => 'Perangkat lain',
                    },
                    'alamat' => $baris->ip_address ?: '—',
                    'terakhir' => Carbon::createFromTimestamp($baris->last_activity)->timezone(config('app.timezone'))->translatedFormat('d M Y, H:i').' WIB',
                    'aktif' => $baris->id === $sekarang,
                ];
            })
            ->all();
    }
}
