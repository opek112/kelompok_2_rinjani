<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Landing Page sebelum login)
Route::get('/', function () {
    return view('welcome'); // Atau ganti menjadi 'home' jika Anda menamainya home.blade.php
})->name('home');

// Halaman Guide & Rental
Route::get('/guide', function () {
    return view('guide');
})->name('guide');

Route::get('/rental', function () {
    return view('rental');
})->name('rental');

// Halaman Info & Bantuan
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

// Halaman setelah Login (Dashboard Customer)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Rute Profil (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';