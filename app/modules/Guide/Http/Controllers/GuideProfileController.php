<?php

namespace Modules\Guide\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GuideProfileController extends GuideController
{
    public function edit(): View
    {
        $pemandu = $this->pemandu();

        return view('guide.profile', [
            'pemandu' => $pemandu,
            'user' => $pemandu->user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($data);

        return redirect()
            ->route('guide.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        $path = $request->file('foto')->store('profil', 'public');

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->update(['foto' => $path]);

        return redirect()
            ->route('guide.profile')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function hapusFoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->update(['foto' => null]);
        }

        return redirect()
            ->route('guide.profile')
            ->with('success', 'Foto profil dihapus.');
    }
}
