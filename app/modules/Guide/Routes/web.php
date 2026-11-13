<?php
use Illuminate\Support\Facades\Route;

Route::prefix('guide')->name('guide.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('guide.dashboard'); })->name('dashboard');
    Route::get('/jadwal', function () { return view('guide.schedule'); })->name('schedule');
    Route::get('/pendapatan', function () { return view('guide.earnings'); })->name('earnings');
    Route::get('/profil', function () { return view('guide.profile'); })->name('profile');
    Route::get('/notifikasi', function () { return view('guide.notifications'); })->name('notifications');
});
