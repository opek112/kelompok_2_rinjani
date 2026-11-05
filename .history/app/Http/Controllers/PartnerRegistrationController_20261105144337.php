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
        if (!session()->has('guide_step1')) {
            return redirect()->route('register.guide');
        }
        return view('register-guide-step2');
    }

    // ==========================================
    // --- STEP 2: DATA KEPEMANDUAN (GUIDE) ---
    // ==========================================
    public function storeGuideStep2(Request $request)
    {
        $request->validate([
            'nomor_lisensi' => ['required', 'string', 'max:255'],
            'tarif_harian' => ['required', 'numeric'],
            'bio' => ['required', 'string', 'max:300'],
        ]);

        $data = $request->only('nomor_lisensi', 'tarif_harian', 'bio');
        session(['guide_step2' => $data]);

        return redirect()->route('register.guide.step3');
    }

    public function showGuideStep3()
    {
        if (!session()->has('guide_step1') || !session()->has('guide_step2')) {
            return redirect()->route('register.guide');
        }
        return view('register-guide-step3');
    }

    // ==========================================
    // --- STEP 3: SERTIFIKAT & BANK (GUIDE) ---
    // ==========================================
    public function storeGuideStep3(Request $request)
    {
        $request->validate([
            'nama_bank' => ['required', 'string'],
            'nomor_rekening' => ['required', 'string'],
            'nama_pemilik_rekening' => ['required', 'string'],
        ]);

        $step1 = session('guide_step1');
        // $step2 = session('guide_step2'); // Bisa digunakan nanti untuk simpan ke DB profil

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

        return redirect()->route('guide.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Dashboard.');
    }

    // ==========================================
    // --- STEP 1: DATA AKUN (RENTAL) ---
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
        if (!session()->has('rental_step1')) { 
            return redirect()->route('register.rental'); 
        }
        return view('register-rental-step2');
    }

    // ==========================================
    // --- STEP 2: DATA TOKO (RENTAL) ---
    // ==========================================
    public function storeRentalStep2(Request $request)
    {
        // Validasi disesuaikan dengan form Rental Step 2
        $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'lokasi_pos' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'deskripsi' => ['required', 'string', 'max:300'],
        ]);

        // Simpan semua data ke session
        session(['rental_step2' => $request->only('nama_toko', 'lokasi_pos', 'alamat', 'deskripsi')]);
        
        return redirect()->route('register.rental.step3');
    }

    public function showRentalStep3()
    {
        if (!session()->has('rental_step1') || !session()->has('rental_step2')) { 
            return redirect()->route('register.rental'); 
        }
        return view('register-rental-step3');
    }

    // ==========================================
    // --- STEP 3: LEGALITAS & BANK (RENTAL) ---
    // ==========================================
    public function storeRentalStep3(Request $request)
    {
        // Validasi disesuaikan dengan form Rental Step 3
        $request->validate([
            'nib' => ['required', 'string'],
            'npwp' => ['required', 'string'],
            'nama_bank' => ['required', 'string'], 
            'nomor_rekening' => ['required', 'string'],
            'nama_pemilik_rekening' => ['required', 'string'],
        ]);
        
        $step1 = session('rental_step1');
        
        // Buat User baru
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

        // Karena dashboard rental belum ada, arahkan ke /dashboard dulu
        return redirect('/dashboard')->with('success', 'Pendaftaran Toko Rental berhasil!');
    }
}