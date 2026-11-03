<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
// 4. RUTE SETELAH LOGIN (CUSTOMER & ADMIN)
// ==========================================
// Semua rute di dalam grup ini wajib login (auth) dan email terverifikasi (verified)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- Dashboard Customer ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Dashboard Admin ---
    Route::get('/admin/dashboard', function () {
        // Karena sudah masuk grup auth, kita tidak perlu cek auth()->check() lagi
        // Langsung cek perannya
        if (Auth::user()->peran === 'admin') {
            return view('admin-dashboard');
        }
        
        // Kalau yang login bukan admin, kembalikan ke dashboard customer
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin!');
    })->name('admin.dashboard');

    // --- Profile ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 5. RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
require __DIR__.'/auth.php';