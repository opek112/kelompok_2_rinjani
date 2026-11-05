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

        // Simpan data sementara di session
        $data = $request->only('nama', 'email', 'no_telepon');
        $data['password'] = Hash::make($request->password);
        session(['guide_step1' => $data]);

        // Lanjut ke Step 2
        return redirect()->route('register.guide.step2');
    }

    public function showGuideStep2()
    {
        // Cek jika user belum isi step 1, tendang balik
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
            // Validasi lain bisa ditambahkan di sini
        ]);

        // Simpan data sementara di session
        $data = $request->only('nomor_lisensi', 'tarif_harian', 'bio');
        session(['guide_step2' => $data]);

        // Lanjut ke Step 3
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
            // File upload validasi bisa ditambahkan di sini
        ]);

        // 1. Ambil semua data dari session
        $step1 = session('guide_step1');
        $step2 = session('guide_step2');

        // 2. Simpan User ke Database secara permanen
        $user = User::create([
            'nama' => $step1['nama'],
            'email' => $step1['email'],
            'no_telepon' => $step1['no_telepon'],
            'password' => $step1['password'],
            'peran' => 'guide', 
            'email_verified_at' => now(), 
        ]);

        // (Opsional) Di sini Anda bisa menyimpan data step 2 dan 3 ke tabel profil_guide
        
        Auth::login($user);

        // 3. Hapus session karena sudah selesai
        session()->forget(['guide_step1', 'guide_step2']);

        // 4. Langsung masuk ke Dashboard Guide!
        return redirect()->route('guide.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Dashboard.');
    }

    // ==========================================
    // --- RENTAL (Sama persis alurnya, hanya beda nama rute/view) ---
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
        if (!session()->has('rental_step1')) { return redirect()->route('register.rental'); }
        return view('register-rental-step2');
    }

    public function storeRentalStep2(Request $request)
    {
        $request->validate(['nama_toko' => ['required', 'string']]);
        session(['rental_step2' => $request->only('nama_toko', 'alamat', 'deskripsi')]);
        return redirect()->route('register.rental.step3');
    }

    public function showRentalStep3()
    {
        if (!session()->has('rental_step1') || !session()->has('rental_step2')) { return redirect()->route('register.rental'); }
        return view('register-rental-step3');
    }

    public function storeRentalStep3(Request $request)
    {
        $request->validate(['nama_bank' => ['required', 'string'], 'nomor_rekening' => ['required', 'string']]);
        
        $step1 = session('rental_step1');
        
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

        // Asumsi Anda akan membuat rute rental.dashboard
        return redirect('/dashboard')->with('success', 'Pendaftaran Toko Rental berhasil!');
    }
}