<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    // Mengarah ke welcome.blade.php (landing page sebelum login)
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
// 4. HALAMAN SETELAH LOGIN (CUSTOMER DASHBOARD)
// ==========================================
Route::get('/dashboard', function () {
    // Ini adalah halaman beranda setelah customer login
    // Pastikan Anda membuat file resources/views/dashboard.blade.php
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// 5. RUTE PROFILE BAWAAN LARAVEL BREEZE
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 6. RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
// File ini otomatis dibuat oleh Laravel Breeze
// Isinya: /login, /register, /forgot-password, /logout, dll.
require __DIR__.'/auth.php';