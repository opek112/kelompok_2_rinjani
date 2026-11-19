<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminActivityController;
use Modules\Admin\Http\Controllers\AdminConfigurationController;
use Modules\Admin\Http\Controllers\AdminDashboardController;
use Modules\Admin\Http\Controllers\AdminKatalogController;
use Modules\Admin\Http\Controllers\AdminKomisiController;
use Modules\Admin\Http\Controllers\AdminRekapController;
use Modules\Admin\Http\Controllers\AdminVerifikasiController;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', [AdminActivityController::class, 'notifications'])->name('notifikasi');
    Route::view('/profil', 'admin::profil')->name('profil');
    Route::get('/pengaturan', [AdminConfigurationController::class, 'index'])->name('pengaturan');
    Route::get('/keamanan', [AdminConfigurationController::class, 'security'])->name('keamanan');
    Route::get('/integrasi', [AdminConfigurationController::class, 'integrations'])->name('integrasi');
    Route::get('/pengaturan-notifikasi', [AdminConfigurationController::class, 'notificationSettings'])
        ->name('pengaturan.notifikasi');
    Route::get('/log-audit', [AdminActivityController::class, 'auditLog'])->name('log-audit');
    Route::get('/rekap-transaksi', [AdminRekapController::class, 'index'])->name('rekap-transaksi');
    Route::get('/rekap-transaksi/export', [AdminRekapController::class, 'exportCsv'])
        ->name('rekap-transaksi.export');
    Route::get('/moderasi-katalog', [AdminKatalogController::class, 'index'])->name('moderasi-katalog');

    Route::get('/atur-komisi', [AdminKomisiController::class, 'index'])->name('atur-komisi');
    Route::patch('/atur-komisi', [AdminKomisiController::class, 'update'])->name('atur-komisi.update');

    Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi');
    Route::patch('/verifikasi/pemandu/{id}', [AdminVerifikasiController::class, 'updateStatusPemandu'])->name('verifikasi.pemandu.update');
    Route::patch('/verifikasi/rental/{id}', [AdminVerifikasiController::class, 'updateStatusRental'])->name('verifikasi.rental.update');
});
