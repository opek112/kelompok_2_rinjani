<?php

use Illuminate\Support\Facades\Route;
use Modules\Guide\Http\Controllers\AssignmentController;
use Modules\Guide\Http\Controllers\EarningsController;
use Modules\Guide\Http\Controllers\GuideBookingController;
use Modules\Guide\Http\Controllers\GuideDashboardController;
use Modules\Guide\Http\Controllers\GuideProfileController;
use Modules\Guide\Http\Controllers\GuideSettingsController;
use Modules\Guide\Http\Controllers\GuideVerificationController;
use Modules\Guide\Http\Controllers\KetersediaanController;
use Modules\Guide\Http\Middleware\EnsureGuidePartner;

Route::prefix('guide')->name('guide.')->middleware(['auth'])->group(function () {
    Route::get('/verifikasi', [GuideVerificationController::class, 'index'])->name('verification');

    Route::middleware(EnsureGuidePartner::class)->group(function () {
        Route::get('/dashboard', [GuideDashboardController::class, 'index'])->name('dashboard');

        Route::get('/jadwal', [AssignmentController::class, 'index'])->name('schedule');
        Route::get('/penugasan/{pemesanan}', [AssignmentController::class, 'show'])->name('assignment.show')->whereNumber('pemesanan');
        Route::post('/penugasan/{pemesanan}/konfirmasi', [AssignmentController::class, 'konfirmasi'])->name('assignment.konfirmasi')->whereNumber('pemesanan');
        Route::post('/penugasan/{pemesanan}/selesai', [AssignmentController::class, 'selesaikan'])->name('assignment.selesai')->whereNumber('pemesanan');
        Route::get('/penugasan/{pemesanan}/ktp', [AssignmentController::class, 'ktp'])->name('assignment.ktp')->whereNumber('pemesanan');

        Route::post('/ketersediaan', [KetersediaanController::class, 'bulk'])->name('ketersediaan.bulk');
        Route::post('/ketersediaan/{tanggal}', [KetersediaanController::class, 'toggle'])
            ->where('tanggal', '\d{4}-\d{2}-\d{2}')
            ->name('ketersediaan.toggle');

        Route::get('/pendapatan', [EarningsController::class, 'index'])->name('earnings');
        Route::get('/pendapatan/unduh', [EarningsController::class, 'export'])->name('earnings.export');

        Route::get('/profil', [GuideProfileController::class, 'edit'])->name('profile');
        Route::post('/profil', [GuideProfileController::class, 'update'])->name('profile.update');
        Route::post('/profil/foto', [GuideProfileController::class, 'updateFoto'])->name('profile.foto');
        Route::delete('/profil/foto', [GuideProfileController::class, 'hapusFoto'])->name('profile.foto.hapus');

        Route::get('/pengaturan', [GuideSettingsController::class, 'index'])->name('settings');
        Route::put('/pengaturan/keamanan', [GuideSettingsController::class, 'updateKeamanan'])->name('settings.keamanan');
        Route::put('/pengaturan/rekening', [GuideSettingsController::class, 'updateRekening'])->name('settings.rekening');
        Route::put('/pengaturan/kepemanduan', [GuideSettingsController::class, 'updateKepemanduan'])->name('settings.kepemanduan');
        Route::post('/pengaturan/dokumen/{jenis}', [GuideSettingsController::class, 'uploadDokumen'])->name('settings.dokumen.upload');
        Route::delete('/pengaturan/dokumen/{jenis}', [GuideSettingsController::class, 'hapusDokumen'])->name('settings.dokumen.hapus');

        Route::get('/notifikasi', function () { return view('guide.notifications'); })->name('notifications');
    });
});

// Pemesanan pemandu oleh pelanggan (tanpa perlu login, seperti alur rental).
Route::get('/guide/{pemandu}/pesan', [GuideBookingController::class, 'create'])
    ->name('guide.booking.create')
    ->whereNumber('pemandu');
Route::post('/guide/{pemandu}/pesan', [GuideBookingController::class, 'store'])
    ->name('guide.booking.store')
    ->whereNumber('pemandu');
