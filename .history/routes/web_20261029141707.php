<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Halaman Landing
Route::get('/', function () {
    return view('landing');
})->name('home');

// Halaman Auth (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Halaman Fitur
Route::get('/pemandu', function () { return view('pemandu'); })->name('pemandu');
Route::get('/sewa-alat', function () { return view('sewa'); })->name('sewa');