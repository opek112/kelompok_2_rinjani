<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminDashboardController;
use Modules\Admin\Http\Controllers\AdminKomisiController;
use Modules\Admin\Http\Controllers\AdminVerifikasiController;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::view('/notifikasi', 'admin::notifikasi')->name('notifikasi');
    Route::view('/profil', 'admin::profil')->name('profil');
    Route::view('/pengaturan', 'admin::pengaturan')->name('pengaturan');
    Route::view('/keamanan', 'admin::keamanan')->name('keamanan');
    Route::view('/integrasi', 'admin::integrasi')->name('integrasi');
    Route::view('/pengaturan-notifikasi', 'admin::notifikasi-pengaturan')->name('pengaturan.notifikasi');
    Route::view('/log-audit', 'admin::log-audit')->name('log-audit');
    Route::view('/rekap-transaksi', 'admin::rekap-transaksi')->name('rekap-transaksi');
    Route::view('/moderasi-katalog', 'admin::moderasi-katalog')->name('moderasi-katalog');

    Route::get('/atur-komisi', [AdminKomisiController::class, 'index'])->name('atur-komisi');
    Route::patch('/atur-komisi', [AdminKomisiController::class, 'update'])->name('atur-komisi.update');

    Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi');
    Route::patch('/verifikasi/pemandu/{id}', [AdminVerifikasiController::class, 'updateStatusPemandu'])->name('verifikasi.pemandu.update');
    Route::patch('/verifikasi/rental/{id}', [AdminVerifikasiController::class, 'updateStatusRental'])->name('verifikasi.rental.update');
});