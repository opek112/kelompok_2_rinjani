<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PartnerRegistrationController extends Controller
{
    // ==========================================
    // --- STEP 1: DATA AKUN (GUIDE) ---
    // ==========================================
    public function storeGuideStep1(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->only('nama', 'email', 'no_telepon');
        $data['password'] = Hash::make($request->password);
        session(['guide_step1' => $data]);

        return redirect()->route('register.guide.step2');
    }

    public function showGuideStep2()
    {
        if (!session()->has('guide_step1')) { return redirect()->route('register.guide')->with('error', 'Sesi habis, silakan isi ulang.'); }
        return view('register-guide-step2');
    }

    // ==========================================
    // --- STEP 2: DATA KEPEMANDUAN (GUIDE) ---
    // ==========================================
    public function storeGuideStep2(Request $request)
    {
        $request->validate([
            'nomor_lisensi' => ['required', 'string', 'max:255'],
            'jalur_keahlian' => ['required', 'string'],
            'bahasa' => ['required', 'array'],
            'tarif_harian' => ['required', 'numeric'],
            'bio' => ['required', 'string', 'max:300'],
        ]);

        $data = $request->only('nomor_lisensi', 'jalur_keahlian', 'bahasa', 'tarif_harian', 'bio');
        session(['guide_step2' => $data]);

        return redirect()->route('register.guide.step3');
    }

    public function showGuideStep3()
    {
        if (!session()->has('guide_step1') || !session()->has('guide_step2')) { 
            return redirect()->route('register.guide')->with('error', 'Sesi habis, silakan isi ulang.'); 
        }
        return view('register-guide-step3');
    }

    // ==========================================
    // --- STEP 3: SERTIFIKAT & BANK (GUIDE) ---
    // ==========================================
    public function storeGuideStep3(Request $request)
    {
        $request->validate([
            'file_sertifikat' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:5120'],
            'file_ktp' => ['required', 'file', 'mimes:jpg,png', 'max:2048'],
            'nama_bank' => ['required', 'string'],
            'nomor_rekening' => ['required', 'string'],
            'nama_pemilik_rekening' => ['required', 'string'],
        ]);

        $step1 = session('guide_step1');
        
        // PENGAMAN: Cek jika session hilang
        if (!$step1) {
            return redirect()->route('register.guide')->with('error', 'Sesi pendaftaran Anda telah berakhir. Silakan isi ulang dari awal.');
        }
        
        // Simpan file ke folder storage/app/public/dokumen
        $pathSertifikat = $request->file('file_sertifikat')->store('dokumen/sertifikat', 'public');
        $pathKtp = $request->file('file_ktp')->store('dokumen/ktp', 'public');

        $user = User::create([
            'nama' => $step1['nama'],
            'email' => $step1['email'],
            'no_telepon' => $step1['no_telepon'],
            'password' => $step1['password'],
            'peran' => 'guide', 
            'email_verified_at' => now(), 
        ]);

        Auth::login($user);
        session()->forget(['guide_step1', 'guide_step2']);

        // REDIRECT KE HALAMAN MENUNGGU VERIFIKASI
        return redirect()->route('register.waiting')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi admin.');
    }

    // ==========================================
    // --- RENTAL (Alur Sama) ---
    // ==========================================
    public function storeRentalStep1(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->only('nama', 'email', 'no_telepon');
        $data['password'] = Hash::make($request->password);
        session(['rental_step1' => $data]);

        return redirect()->route('register.rental.step2');
    }

    public function showRentalStep2()
    {
        if (!session()->has('rental_step1')) { return redirect()->route('register.rental')->with('error', 'Sesi habis, silakan isi ulang.'); }
        return view('register-rental-step2');
    }

    public function storeRentalStep2(Request $request)
    {
        $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'lokasi_pos' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'deskripsi' => ['required', 'string', 'max:300'],
        ]);

        session(['rental_step2' => $request->only('nama_toko', 'lokasi_pos', 'alamat', 'deskripsi')]);
        return redirect()->route('register.rental.step3');
    }

    public function showRentalStep3()
    {
        if (!session()->has('rental_step1') || !session()->has('rental_step2')) { 
            return redirect()->route('register.rental')->with('error', 'Sesi habis, silakan isi ulang.'); 
        }
        return view('register-rental-step3');
    }

    public function storeRentalStep3(Request $request)
    {
        $request->validate([
            'nib' => ['required', 'string'],
            'npwp' => ['required', 'string'],
            'file_legalitas' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:5120'],
            'nama_bank' => ['required', 'string'], 
            'nomor_rekening' => ['required', 'string'],
            'nama_pemilik_rekening' => ['required', 'string'],
        ]);
        
        $step1 = session('rental_step1');
        
        // PENGAMAN: Cek jika session hilang
        if (!$step1) {
            return redirect()->route('register.rental')->with('error', 'Sesi pendaftaran Anda telah berakhir. Silakan isi ulang dari awal.');
        }
        
        // Simpan file
        $pathLegalitas = $request->file('file_legalitas')->store('dokumen/legalitas', 'public');

        $user = User::create([
            'nama' => $step1['nama'],
            'email' => $step1['email'],
            'no_telepon' => $step1['no_telepon'],
            'password' => $step1['password'],
            'peran' => 'rental', 
            'email_verified_at' => now(), 
        ]);

        Auth::login($user);
        session()->forget(['rental_step1', 'rental_step2']);

        // REDIRECT KE HALAMAN MENUNGGU VERIFIKASI
        return redirect()->route('register.waiting')->with('success', 'Pendaftaran Toko Rental berhasil! Menunggu verifikasi admin.');
    }
}