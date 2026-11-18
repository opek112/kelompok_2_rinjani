<?php

use Illuminate\Support\Facades\Route;
use Modules\Rental\Http\Controllers\CartController;
use Modules\Rental\Http\Controllers\CheckoutController;
use Modules\Rental\Http\Controllers\PaymentController;
use Modules\Rental\Http\Controllers\RentalController;

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
