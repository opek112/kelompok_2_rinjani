<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keamanan Akun - RinjaniGuide Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex flex-col justify-center px-8 shrink-0 z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Pengaturan</h2>
                        <p class="text-sm text-gray-500">Kelola preferensi sistem, parameter operasional, dan keamanan platform.</p>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                            <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                        </a>
                        <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                            <div class="w-10 h-10 bg-[#143529] rounded-full flex items-center justify-center text-white font-bold">RA</div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-tight">Rizki Aditya</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- SUB-NAVIGASI TAB -->
            <div class="bg-white border-b border-gray-200 px-8 flex gap-6 shrink-0 z-10 shadow-sm">
               <a href="{{ route('admin.pengaturan') }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
    ⚙️ Preferensi Sistem
</a>
                <!-- Tab Keamanan (Aktif) -->
                <a href="#" class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">
                    🛡️ Keamanan Akun
                </a>
               <a href="{{ route('admin.integrasi') }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
    🔗 Integrasi
</a>
               <a href="{{ route('admin.pengaturan.notifikasi') }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
    🔔 Notifikasi
</a>
            </div>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto space-y-6">

                    <!-- KARTU 1: UBAH KATA SANDI -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Ubah Kata Sandi</h3>
                        <p class="text-sm text-gray-500 mb-6">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>

                        <form class="space-y-5">
                            <!-- Sandi Saat Ini -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                                <div class="relative">
                                    <input type="password" placeholder="••••••••" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm pr-10">
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">👁️</span>
                                </div>
                            </div>

                            <!-- Sandi Baru -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password" value="KompasGaruda2026" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm pr-10">
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">👁️</span>
                                </div>
                                <!-- Indikator Kekuatan Sandi -->
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="flex-1 h-1.5 bg-green-500 rounded-full"></div>
                                    <div class="flex-1 h-1.5 bg-green-500 rounded-full"></div>
                                    <div class="flex-1 h-1.5 bg-green-500 rounded-full"></div>
                                    <span class="text-xs font-bold text-green-600 ml-2">Kuat</span>
                                </div>
                            </div>

                            <!-- Konfirmasi Sandi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password" value="KompasGaruda2026" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm pr-10">
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">👁️</span>
                                </div>
                            </div>

                            <p class="text-[11px] text-gray-500">Minimal 8 karakter, kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>

                            <div class="flex justify-end pt-2">
                                <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">
                                    Ubah Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- KARTU 2: 2FA -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Autentikasi Dua Faktor (2FA)</h3>
                        <p class="text-sm text-gray-500 mb-6">Tingkatkan keamanan akun dengan lapisan verifikasi tambahan.</p>

                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border border-gray-200 rounded-xl p-4 bg-gray-50">
                            <div class="flex items-center gap-3 mb-4 md:mb-0">
                                <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-xl">🔐</div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900 text-sm">2FA via Aplikasi Authenticator</span>
                                        <span class="bg-orange-100 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Belum Aktif</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Gunakan aplikasi seperti Google Authenticator atau Authy.</p>
                                </div>
                            </div>
                            <button class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition shrink-0">
                                Aktifkan 2FA
                            </button>
                        </div>
                    </div>

                    <!-- KARTU 3: SESI AKTIF -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Sesi Aktif</h3>
                        <p class="text-sm text-gray-500 mb-6">Perangkat yang saat ini login ke akun Anda.</p>

                        <div class="space-y-3">
                            <!-- Sesi 1 -->
                            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">💻</div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-gray-900 text-sm">Chrome di Windows</p>
                                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Sesi Ini</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Mataram, Indonesia • IP 192.168.1.10</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sesi 2 -->
                            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-xl">📱</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">Chrome di Android</p>
                                        <p class="text-xs text-gray-500">Mataram, Indonesia • 29 Okt 2026, 09:15 WIB</p>
                                    </div>
                                </div>
                                <button class="text-red-500 hover:text-red-700 text-sm font-semibold transition">Akhiri</button>
                            </div>

                            <!-- Sesi 3 -->
                            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-xl">🖥️</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">Safari di iPad</p>
                                        <p class="text-xs text-gray-500">Jakarta, Indonesia • 27 Okt 2026, 20:10 WIB</p>
                                    </div>
                                </div>
                                <button class="text-red-500 hover:text-red-700 text-sm font-semibold transition">Akhiri</button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="text-red-500 hover:underline text-sm font-bold flex items-center gap-1">
                                Akhiri Semua Sesi Lain
                            </button>
                        </div>
                    </div>

                    <!-- KARTU 4: NONAKTIFKAN AKUN -->
                    <div class="bg-red-50 rounded-2xl border border-red-200 shadow-sm p-8">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Nonaktifkan Akun Admin</h3>
                                <p class="text-sm text-red-700 mt-1">Akun akan dinonaktifkan secara permanen. Semua akses ke platform dan tugas-tugas admin akan terhenti. Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                        <div class="pl-13">
                            <button class="border border-red-500 text-red-600 hover:bg-red-500 hover:text-white px-5 py-2.5 rounded-lg text-sm font-bold transition bg-white">
                                Nonaktifkan Akun Saya
                            </button>
                            <p class="text-[10px] text-red-400 mt-2">Tindakan ini membutuhkan persetujuan Superadmin.</p>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>