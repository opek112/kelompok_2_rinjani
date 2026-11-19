<?php

namespace Modules\Rental\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Booking\Models\Pemesanan;

class PartnerProfileController extends PartnerController
{
    public function index(Request $request): View
    {
        $toko = $this->toko($request);

        return view('rental.partner.profile', [
            'toko' => $toko,
            'sedangDikemas' => $this->pesananPerluTindakan($toko->id),
        ]);
    }

    private function pesananPerluTindakan(int $tokoId): int
    {
        return Pemesanan::query()
            ->whereHas('items.peralatan', fn ($query) => $query->where('toko_rental_id', $tokoId))
            ->where('status', 'paid')
            ->whereNull('waktu_serah_terima')
            ->count();
    }

    public function update(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        $data = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['required', 'string', 'max:255'],
            'telepon_toko' => ['required', 'string', 'max:20'],
            'lokasi_pos' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string', 'max:300'],
            'hari_buka' => ['required', 'string', 'max:100'],
            'jam_buka' => ['required', 'date_format:H:i'],
            'jam_tutup' => ['required', 'date_format:H:i', 'after:jam_buka'],
            'foto_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'jam_tutup.after' => 'Jam tutup harus lebih lambat dari jam buka.',
            'foto_toko.image' => 'Foto toko harus berupa gambar JPG, JPEG, atau PNG.',
            'foto_toko.max' => 'Ukuran foto toko maksimal 2 MB.',
        ]);

        unset($data['foto_toko']);

        if ($request->hasFile('foto_toko')) {
            if ($toko->path_logo) {
                Storage::disk('public')->delete($toko->path_logo);
            }

            $data['path_logo'] = $request->file('foto_toko')->store('toko/logo', 'public');
        }

        $toko->update($data);

        return redirect()
            ->route('rental.profile')
            ->with('success', 'Profil toko berhasil diperbarui dan langsung tampil di katalog publik.');
    }

    public function hapusFoto(Request $request): RedirectResponse
    {
        $toko = $this->toko($request);

        if ($toko->path_logo) {
            Storage::disk('public')->delete($toko->path_logo);
            $toko->update(['path_logo' => null]);
        }

        return redirect()
            ->route('rental.profile')
            ->with('success', 'Foto toko dihapus. Katalog publik akan memakai foto alat sebagai penanda.');
    }
}
