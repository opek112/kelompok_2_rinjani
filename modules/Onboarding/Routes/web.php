<?php
use Illuminate\Support\Facades\Route;
use Modules\Onboarding\Http\Controllers\PartnerRegistrationController;

Route::get('/daftar-guide', function () { return view('register-guide-step1'); })->name('register.guide');
Route::post('/daftar-guide', [PartnerRegistrationController::class, 'storeGuideStep1'])->name('register.guide.store');
Route::get('/daftar-guide/step-2', [PartnerRegistrationController::class, 'showGuideStep2'])->name('register.guide.step2');
Route::post('/daftar-guide/step-2', [PartnerRegistrationController::class, 'storeGuideStep2'])->name('register.guide.step2.store');
Route::get('/daftar-guide/step-3', [PartnerRegistrationController::class, 'showGuideStep3'])->name('register.guide.step3');
Route::post('/daftar-guide/step-3', [PartnerRegistrationController::class, 'storeGuideStep3'])->name('register.guide.step3.store');

Route::get('/daftar-rental', function () { return view('register-rental-step1'); })->name('register.rental');
Route::post('/daftar-rental', [PartnerRegistrationController::class, 'storeRentalStep1'])->name('register.rental.store');
Route::get('/daftar-rental/step-2', [PartnerRegistrationController::class, 'showRentalStep2'])->name('register.rental.step2');
Route::post('/daftar-rental/step-2', [PartnerRegistrationController::class, 'storeRentalStep2'])->name('register.rental.step2.store');
Route::get('/daftar-rental/step-3', [PartnerRegistrationController::class, 'showRentalStep3'])->name('register.rental.step3');
Route::post('/daftar-rental/step-3', [PartnerRegistrationController::class, 'storeRentalStep3'])->name('register.rental.step3.store');

Route::get('/menunggu-verifikasi', function () { return view('partner-waiting'); })->name('register.waiting');
