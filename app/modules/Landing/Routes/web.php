<?php

use Illuminate\Support\Facades\Route;
use Modules\Guide\Http\Controllers\GuideCatalogController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/guide', [GuideCatalogController::class, 'index'])->name('guide');
Route::get('/guide/{pemandu}', [GuideCatalogController::class, 'show'])->name('guide.detail')->whereNumber('pemandu');
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
