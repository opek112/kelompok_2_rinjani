<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/guide', function () { return view('guide'); })->name('guide');
Route::get('/rental', function () { return view('rental'); })->name('rental');
Route::get('/cara-pesan', function () { return view('cara-pesan'); })->name('cara-pesan');
Route::get('/jalur-pendakian', function () { return view('jalur-pendakian'); })->name('jalur-pendakian');
Route::get('/tentang-kami', function () { return view('tentang-kami'); })->name('tentang-kami');
Route::get('/faq', function () { return view('faq'); })->name('faq');
Route::get('/syarat-ketentuan', function () { return view('syarat-ketentuan'); })->name('syarat-ketentuan');
