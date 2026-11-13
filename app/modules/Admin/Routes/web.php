<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Controllers\AdminDashboardController;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', function () { return view('admin-notifikasi'); })->name('notifikasi');
    Route::get('/verifikasi', function () { return view('admin-verifikasi'); })->name('verifikasi');
    Route::get('/profil', function () { return view('admin-profil'); })->name('profil');
    Route::get('/pengaturan', function () { return view('admin-pengaturan'); })->name('pengaturan');
    Route::get('/keamanan', function () { return view('admin-keamanan'); })->name('keamanan');
    Route::get('/integrasi', function () { return view('admin-integrasi'); })->name('integrasi');
    Route::get('/pengaturan-notifikasi', function () { return view('admin-notifikasi-pengaturan'); })->name('pengaturan.notifikasi');
    Route::get('/log-audit', function () { return view('admin-log-audit'); })->name('log-audit');
    Route::get('/rekap-transaksi', function () { return view('admin-rekap-transaksi'); })->name('rekap-transaksi');
    Route::get('/moderasi-katalog', function () { return view('admin-moderasi-katalog'); })->name('moderasi-katalog');
    Route::get('/atur-komisi', function () { return view('admin-atur-komisi'); })->name('atur-komisi');
});
