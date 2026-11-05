<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PartnerRegistrationController extends Controller
{
    // Fungsi untuk menyimpan pendaftaran Guide (Tahap 1)
    public function storeGuide(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'peran' => 'guide', 
            'email_verified_at' => now(), 
        ]);

        Auth::login($user);

        return redirect()->route('register.waiting')->with('success', 'Akun berhasil dibuat! Silakan lengkapi data.');
    }

    // Fungsi untuk menyimpan pendaftaran Rental (Tahap 1)
    public function storeRental(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'peran' => 'rental',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('register.waiting')->with('success', 'Akun berhasil dibuat! Silakan lengkapi data.');
    }
}