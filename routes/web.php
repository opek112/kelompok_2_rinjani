<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==========================================
// 2. HALAMAN FITUR UTAMA (Guide & Rental)
// ==========================================
Route::get('/guide', function () {
    return view('guide');
})->name('guide');

Route::get('/rental', function () {
    return view('rental');
})->name('rental');

// ==========================================
// 3. HALAMAN INFORMASI (Dropdown Navbar)
// ==========================================
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

// ==========================================
// 4. RUTE SETELAH LOGIN (CUSTOMER & ADMIN)
// ==========================================
// Semua rute di dalam grup ini wajib login (auth) dan email terverifikasi (verified)
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Dashboard Customer ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Dashboard Admin ---
    // --- Dashboard Admin ---
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // --- Notifikasi Admin ---
    Route::get('/admin/notifikasi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-notifikasi');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.notifikasi');
    // --- Verifikasi Mitra ---
    Route::get('/admin/verifikasi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-verifikasi');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.verifikasi');
    // --- Profil Admin ---
    Route::get('/admin/profil', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-profil');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.profil');
    // --- Pengaturan Admin ---
    Route::get('/admin/pengaturan', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-pengaturan');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.pengaturan');
    // --- Keamanan Admin ---
    Route::get('/admin/keamanan', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-keamanan');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.keamanan');
    // --- Integrasi Admin ---
    Route::get('/admin/integrasi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-integrasi');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.integrasi');
    // --- Notifikasi Pengaturan Admin ---
    Route::get('/admin/pengaturan-notifikasi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-notifikasi-pengaturan');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.pengaturan.notifikasi');
    // --- Log Audit Admin ---
    Route::get('/admin/log-audit', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-log-audit');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.log-audit');
    // --- Rekap Transaksi Admin ---
    Route::get('/admin/rekap-transaksi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-rekap-transaksi');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.rekap-transaksi');
    // --- Moderasi Katalog Admin ---
    Route::get('/admin/moderasi-katalog', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-moderasi-katalog');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses!');
    })->name('admin.moderasi-katalog');
    Route::get('admin/atur-komisi', function () {
        if (Auth::user()->peran === 'admin') {
            return view('admin-atur-komisi');
        }

        return redirect('/dashboard')->with('error', 'anda tidak memiliki akses!');
    })->name('admin.atur-komisi');

    // --- Profile ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 5. RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
require __DIR__.'/auth.php';


// Route untuk simulasi halaman Pemandu (sementara)
Route::prefix('guide')->name('guide.')->group(function () {
    Route::get('/dashboard', function () { return view('guide.dashboard'); })->name('dashboard');
    Route::get('/jadwal', function () { return view('guide.schedule'); })->name('schedule');
    Route::get('/pendapatan', function () { return view('guide.earnings'); })->name('earnings');
    Route::get('/profil', function () { return view('guide.profile'); })->name('profile');
    Route::get('/notifikasi', function () { return view('guide.notifications'); })->name('notifications');
});