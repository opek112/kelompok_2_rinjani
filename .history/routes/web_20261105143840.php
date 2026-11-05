<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PartnerRegistrationController; // TAMBAHAN BARU
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==========================================
// 2. HALAMAN FITUR UTAMA (Guide & Rental)
// ==========================================
Route::get('/guide', function () {
    return view('guide');
})->name('guide');

Route::get('/rental', function () {
    return view('rental');
})->name('rental');

// ==========================================
// 3. HALAMAN INFORMASI (Dropdown Navbar)
// ==========================================
Route::get('/cara-pesan', function () {
    return view('cara-pesan');
})->name('cara-pesan');

Route::get('/jalur-pendakian', function () {
    return view('jalur-pendakian');
})->name('jalur-pendakian');

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/syarat-ketentuan', function () {
    return view('syarat-ketentuan');
})->name('syarat-ketentuan');

// ==========================================
// 3.5. RUTE PENDAFTARAN MITRA (BARU)
// ==========================================
use App\Http\Controllers\PartnerRegistrationController; // Pastikan ini ada di atas

// -- Guide --
Route::get('/daftar-guide', function () { return view('register-guide-step1'); })->name('register.guide');
Route::post('/daftar-guide', [PartnerRegistrationController::class, 'storeGuideStep1'])->name('register.guide.store');

Route::get('/daftar-guide/step-2', [PartnerRegistrationController::class, 'showGuideStep2'])->name('register.guide.step2');
Route::post('/daftar-guide/step-2', [PartnerRegistrationController::class, 'storeGuideStep2'])->name('register.guide.step2.store');

Route::get('/daftar-guide/step-3', [PartnerRegistrationController::class, 'showGuideStep3'])->name('register.guide.step3');
Route::post('/daftar-guide/step-3', [PartnerRegistrationController::class, 'storeGuideStep3'])->name('register.guide.step3.store');

// -- Rental --
Route::get('/daftar-rental', function () { return view('register-rental-step1'); })->name('register.rental');
Route::post('/daftar-rental', [PartnerRegistrationController::class, 'storeRentalStep1'])->name('register.rental.store');

Route::get('/daftar-rental/step-2', [PartnerRegistrationController::class, 'showRentalStep2'])->name('register.rental.step2');
Route::post('/daftar-rental/step-2', [PartnerRegistrationController::class, 'storeRentalStep2'])->name('register.rental.step2.store');

Route::get('/daftar-rental/step-3', [PartnerRegistrationController::class, 'showRentalStep3'])->name('register.rental.step3');
Route::post('/daftar-rental/step-3', [PartnerRegistrationController::class, 'storeRentalStep3'])->name('register.rental.step3.store');


// ==========================================
// 4. RUTE SETELAH LOGIN (CUSTOMER & ADMIN)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Dashboard Customer ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Dashboard Admin ---
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // --- Notifikasi Admin ---
    Route::get('/admin/notifikasi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-notifikasi'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.notifikasi');

    // --- Verifikasi Mitra ---
    Route::get('/admin/verifikasi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-verifikasi'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.verifikasi');

    // --- Profil Admin ---
    Route::get('/admin/profil', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-profil'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.profil');

    // --- Pengaturan Admin ---
    Route::get('/admin/pengaturan', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-pengaturan'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.pengaturan');

    // --- Keamanan Admin ---
    Route::get('/admin/keamanan', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-keamanan'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.keamanan');

    // --- Integrasi Admin ---
    Route::get('/admin/integrasi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-integrasi'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.integrasi');

    // --- Notifikasi Pengaturan Admin ---
    Route::get('/admin/pengaturan-notifikasi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-notifikasi-pengaturan'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.pengaturan.notifikasi');

    // --- Log Audit Admin ---
    Route::get('/admin/log-audit', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-log-audit'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.log-audit');

    // --- Rekap Transaksi Admin ---
    Route::get('/admin/rekap-transaksi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-rekap-transaksi'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.rekap-transaksi');

    // --- Moderasi Katalog Admin ---
    Route::get('/admin/moderasi-katalog', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-moderasi-katalog'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.moderasi-katalog');

    // --- Atur Komisi Admin ---
    Route::get('/admin/atur-komisi', function () {
        if (Auth::user()->peran === 'admin') { return view('admin-atur-komisi'); }
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.atur-komisi');

    // --- Profile Customer ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 5. RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
require __DIR__.'/auth.php';


// ==========================================
// 6. RUTE SIMULASI DASHBOARD GUIDE (Sementara)
// ==========================================
Route::prefix('guide')->name('guide.')->group(function () {
    Route::get('/dashboard', function () { return view('guide.dashboard'); })->name('dashboard');
    Route::get('/jadwal', function () { return view('guide.schedule'); })->name('schedule');
    Route::get('/pendapatan', function () { return view('guide.earnings'); })->name('earnings');
    Route::get('/profil', function () { return view('guide.profile'); })->name('profile');
    Route::get('/notifikasi', function () { return view('guide.notifications'); })->name('notifications');
});