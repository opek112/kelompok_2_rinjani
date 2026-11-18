<?php

namespace Modules\Guide\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class GuideSettingsController extends GuideController
{
    public const RUTE = ['Sembalun', 'Senaru', 'Torean', 'Aik Berik', 'Timbanuh', 'Tetebatu'];

    public const BAHASA = ['Indonesia', 'Inggris', 'Mandarin', 'Jepang', 'Arab', 'Prancis'];

    public const TAB = ['keamanan', 'rekening', 'dokumen', 'kepemanduan'];

    /**
     * Kolom penyimpanan berkas untuk tiap jenis dokumen.
     */
    private const DOKUMEN = [
        'lisensi' => [
            'kolom' => 'path_berkas_lisensi',
            'folder' => 'dokumen/sertifikat',
            'mimes' => 'jpg,jpeg,png,pdf',
            'maks' => 5120,
            'label' => 'Lisensi Kepemanduan',
        ],
        'sertifikat' => [
            'kolom' => 'path_sertifikat_pendakian',
            'folder' => 'dokumen/sertifikat-pendakian',
            'mimes' => 'jpg,jpeg,png,pdf',
            'maks' => 5120,
            'label' => 'Sertifikat Pendakian',
        ],
        'ktp' => [
            'kolom' => 'path_foto_ktp',
            'folder' => 'dokumen/ktp',
            'mimes' => 'jpg,jpeg,png',
            'maks' => 2048,
            'label' => 'KTP',
        ],
    ];

    public function index(Request $request): View
    {
        $tab = $request->query('tab');
        $tab = in_array($tab, self::TAB, true) ? $tab : 'keamanan';

        $pemandu = $this->pemandu();

        return view('guide.settings', [
            'pemandu' => $pemandu,
            'user' => $pemandu->user,
            'tab' => $tab,
            'ruteTersedia' => self::RUTE,
            'bahasaTersedia' => self::BAHASA,
            'dokumen' => collect(self::DOKUMEN)->map(fn (array $item, string $jenis) => [
                'jenis' => $jenis,
                'label' => $item['label'],
                'path' => $pemandu->{$item['kolom']},
                'mimes' => $item['mimes'],
                'maks' => round($item['maks'] / 1024),
            ])->all(),
        ]);
    }

    public function updateKeamanan(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'password_lama' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'password_lama.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->email = $data['email'];
        $user->no_telepon = $data['no_telepon'] ?? null;

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return redirect()
            ->route('guide.settings', ['tab' => 'keamanan'])
            ->with('success', 'Keamanan akun berhasil diperbarui.');
    }

    public function updateRekening(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_bank' => ['required', 'string', 'max:50'],
            'nomor_rekening' => ['required', 'string', 'min:5', 'max:30', 'regex:/^[0-9]+$/'],
            'nama_pemilik_rekening' => ['required', 'string', 'max:255'],
        ], [
            'nomor_rekening.regex' => 'Nomor rekening hanya boleh berisi angka.',
        ]);

        $pemandu = $this->pemandu();

        $pemandu->update([
            'nama_bank' => $data['nama_bank'],
            'nomor_rekening' => $data['nomor_rekening'],
            'nama_pemilik_rekening' => $data['nama_pemilik_rekening'],
            'info_rekening_bank' => trim($data['nama_bank'].' - '.$data['nomor_rekening'].' - '.$data['nama_pemilik_rekening']),
        ]);

        return redirect()
            ->route('guide.settings', ['tab' => 'rekening'])
            ->with('success', 'Rekening pencairan berhasil disimpan.');
    }

    public function updateKepemanduan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nomor_lisensi' => ['required', 'string', 'max:255'],
            'rute' => ['required', 'array', 'min:1'],
            'rute.*' => ['string', 'max:50'],
            'bahasa' => ['required', 'array', 'min:1'],
            'bahasa.*' => ['string', 'max:50'],
            'tarif_harian' => ['required', 'numeric', 'min:0'],
            'bio' => ['required', 'string', 'max:300'],
        ]);

        $pemandu = $this->pemandu();

        $pemandu->update([
            'nomor_lisensi' => $data['nomor_lisensi'],
            'bahasa' => implode(', ', $data['bahasa']),
            'tarif_harian' => $data['tarif_harian'],
            'bio' => $data['bio'],
        ]);

        $pemandu->rutes()->delete();
        foreach ($data['rute'] as $rute) {
            $pemandu->rutes()->create(['rute' => $rute]);
        }

        return redirect()
            ->route('guide.settings', ['tab' => 'kepemanduan'])
            ->with('success', 'Data kepemanduan berhasil diperbarui.');
    }

    public function uploadDokumen(Request $request, string $jenis): RedirectResponse
    {
        abort_unless(isset(self::DOKUMEN[$jenis]), 404);

        $aturan = self::DOKUMEN[$jenis];

        $request->validate([
            'berkas' => ['required', 'file', 'mimes:'.$aturan['mimes'], 'max:'.$aturan['maks']],
        ], [
            'berkas.mimes' => 'Format berkas harus '.str_replace(',', ', ', $aturan['mimes']).'.',
            'berkas.max' => 'Ukuran berkas maksimal '.round($aturan['maks'] / 1024).' MB.',
        ]);

        $pemandu = $this->pemandu();
        $lama = $pemandu->{$aturan['kolom']};

        $path = $request->file('berkas')->store($aturan['folder'], 'public');

        if ($lama) {
            Storage::disk('public')->delete($lama);
        }

        $pemandu->update([$aturan['kolom'] => $path]);

        return redirect()
            ->route('guide.settings', ['tab' => 'dokumen'])
            ->with('success', $aturan['label'].' berhasil diunggah.');
    }

    public function hapusDokumen(string $jenis): RedirectResponse
    {
        abort_unless(isset(self::DOKUMEN[$jenis]), 404);

        $aturan = self::DOKUMEN[$jenis];
        $pemandu = $this->pemandu();
        $lama = $pemandu->{$aturan['kolom']};

        if ($lama) {
            Storage::disk('public')->delete($lama);
            $pemandu->update([$aturan['kolom'] => null]);
        }

        return redirect()
            ->route('guide.settings', ['tab' => 'dokumen'])
            ->with('success', $aturan['label'].' berhasil dihapus.');
    }
}
