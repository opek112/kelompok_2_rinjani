<?php

use Illuminate\Support\Facades\Route;
use Modules\Rental\Http\Controllers\CartController;
use Modules\Rental\Http\Controllers\CheckoutController;
use Modules\Rental\Http\Controllers\PartnerCatalogController;
use Modules\Rental\Http\Controllers\PartnerDashboardController;
use Modules\Rental\Http\Controllers\PartnerEquipmentController;
use Modules\Rental\Http\Controllers\PartnerNotificationController;
use Modules\Rental\Http\Controllers\PartnerOrderController;
use Modules\Rental\Http\Controllers\PartnerProfileController;
use Modules\Rental\Http\Controllers\PartnerReportController;
use Modules\Rental\Http\Controllers\PartnerReturnController;
use Modules\Rental\Http\Controllers\PartnerSettingsController;
use Modules\Rental\Http\Controllers\PaymentController;
use Modules\Rental\Http\Controllers\RentalController;
use Modules\Rental\Http\Middleware\EnsureRentalPartner;

Route::prefix('rental')->group(function (): void {
    Route::get('/', [RentalController::class, 'index'])->name('rental');

    Route::get('/keranjang', [CartController::class, 'index'])->name('rental.cart');
    Route::patch('/keranjang/jadwal', [CartController::class, 'dates'])->name('rental.cart.dates');
    Route::patch('/keranjang/{peralatan}', [CartController::class, 'update'])->name('rental.cart.update');
    Route::delete('/keranjang/{peralatan}', [CartController::class, 'destroy'])->name('rental.cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('rental.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('rental.checkout.store');

    Route::get('/{peralatan}', [RentalController::class, 'show'])->name('rental.detail');
    Route::post('/{peralatan}/keranjang', [RentalController::class, 'addToCart'])->name('rental.cart.add');
});

Route::get('/pembayaran/{kode}', [PaymentController::class, 'status'])->name('rental.payment');
Route::post('/pembayaran/{kode}/konfirmasi', [PaymentController::class, 'confirm'])->name('rental.payment.confirm');
Route::post('/pembayaran/{kode}/batalkan', [PaymentController::class, 'cancel'])->name('rental.payment.cancel');
Route::get('/e-voucher/{kode}', [PaymentController::class, 'voucher'])->name('rental.voucher');

Route::prefix('mitra')->name('rental.')->middleware('auth')->group(function (): void {
    Route::get('/verifikasi', [PartnerDashboardController::class, 'verifikasi'])->name('verification');

    Route::middleware(EnsureRentalPartner::class)->group(function (): void {
        Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventaris/unduh', [PartnerDashboardController::class, 'export'])->name('inventory.export');

        Route::get('/inventaris/tambah', [PartnerEquipmentController::class, 'create'])->name('equipment.create');
        Route::post('/inventaris', [PartnerEquipmentController::class, 'store'])->name('equipment.store');
        Route::get('/inventaris/{peralatan}/ubah', [PartnerEquipmentController::class, 'edit'])->name('equipment.edit')->whereNumber('peralatan');
        Route::put('/inventaris/{peralatan}', [PartnerEquipmentController::class, 'update'])->name('equipment.update')->whereNumber('peralatan');
        Route::delete('/inventaris/{peralatan}', [PartnerEquipmentController::class, 'destroy'])->name('equipment.destroy')->whereNumber('peralatan');

        Route::get('/pesanan', [PartnerOrderController::class, 'index'])->name('orders');
        Route::post('/pesanan/{pemesanan}/serah-terima', [PartnerOrderController::class, 'deliver'])->name('orders.deliver')->whereNumber('pemesanan');
        Route::post('/pesanan/{pemesanan}/selesai', [PartnerOrderController::class, 'complete'])->name('orders.complete')->whereNumber('pemesanan');

        Route::get('/pengembalian', [PartnerReturnController::class, 'index'])->name('returns');
        Route::get('/pengembalian/{pemesanan}', [PartnerReturnController::class, 'show'])->name('returns.show')->whereNumber('pemesanan');
        Route::post('/pengembalian/{pemesanan}', [PartnerReturnController::class, 'store'])->name('returns.store')->whereNumber('pemesanan');

        Route::get('/katalog', [PartnerCatalogController::class, 'index'])->name('catalog');

        Route::get('/rekap', [PartnerReportController::class, 'index'])->name('reports');
        Route::get('/rekap/unduh', [PartnerReportController::class, 'export'])->name('reports.export');

        Route::get('/profil', [PartnerProfileController::class, 'index'])->name('profile');
        Route::post('/profil', [PartnerProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profil/foto', [PartnerProfileController::class, 'hapusFoto'])->name('profile.foto.hapus');

        Route::get('/notifikasi', [PartnerNotificationController::class, 'index'])->name('notifications');
        Route::post('/notifikasi/semua-dibaca', [PartnerNotificationController::class, 'bacaSemua'])->name('notifications.baca-semua');
        Route::post('/notifikasi/{id}/dibaca', [PartnerNotificationController::class, 'baca'])
            ->name('notifications.baca')
            ->where('id', '[A-Za-z0-9\-]+');
        Route::get('/pengaturan', [PartnerSettingsController::class, 'index'])->name('settings');
        Route::post('/pengaturan/legalitas', [PartnerSettingsController::class, 'updateLegalitas'])->name('settings.legalitas');
        Route::post('/pengaturan/rekening', [PartnerSettingsController::class, 'updateRekening'])->name('settings.rekening');
        Route::post('/pengaturan/keamanan', [PartnerSettingsController::class, 'updateKeamanan'])->name('settings.keamanan');
        Route::post('/pengaturan/notifikasi', [PartnerSettingsController::class, 'updateNotifikasi'])->name('settings.notifikasi');
        Route::post('/pengaturan/operasional', [PartnerSettingsController::class, 'updateOperasional'])->name('settings.operasional');
        Route::post('/pengaturan/status-toko', [PartnerSettingsController::class, 'toggleAktif'])->name('settings.aktif');
        Route::delete('/pengaturan/sesi/{sesi}', [PartnerSettingsController::class, 'akhiriSesi'])->name('settings.sesi.akhiri');
        Route::post('/pengaturan/sesi/akhiri-lain', [PartnerSettingsController::class, 'akhiriSesiLain'])->name('settings.sesi.akhiri-lain');
    });
});
