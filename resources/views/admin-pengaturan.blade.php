<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - RinjaniGuide Admin</title>
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
                        <!-- Notifikasi -->
                        <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                            <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                        </a>
                        <!-- Profile -->
                        <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                            <div class="w-10 h-10 bg-[#143529] rounded-full flex items-center justify-center text-white font-bold">
                                RA
                            </div>
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
                <a href="#" class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">
                    ⚙️ Preferensi Sistem
                </a>
                <a href="{{ route('admin.keamanan') }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
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

                    <!-- KARTU 1: PREFERENSI TAMPILAN -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Preferensi Tampilan</h3>
                        <p class="text-sm text-gray-500 mb-6">Sesuaikan format tanggal dan mata uang regional sistem.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Bahasa -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🌐</span>
                                    <select class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm appearance-none bg-white">
                                        <option>Indonesia</option>
                                        <option>English</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Zona Waktu -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Zona Waktu</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🕒</span>
                                    <select class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm appearance-none bg-white">
                                        <option>WIB (UTC+7)</option>
                                        <option>WITA (UTC+8)</option>
                                        <option>WIT (UTC+9)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Format Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Format Tanggal</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📅</span>
                                    <select class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm appearance-none bg-white">
                                        <option>DD MMMM YYYY (14 Mei 2026)</option>
                                        <option>DD/MM/YYYY (14/05/2026)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Format Mata Uang -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Format Mata Uang</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">💰</span>
                                    <select class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm appearance-none bg-white">
                                        <option>Rp 1.200.000</option>
                                        <option>IDR 1,200,000</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm">
                                Simpan Preferensi
                            </button>
                        </div>
                    </div>

                    <!-- KARTU 2: PENGATURAN PLATFORM -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Pengaturan Platform</h3>
                        <p class="text-sm text-gray-500 mb-6">Informasi dasar dan parameter operasional platform.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Nama Platform -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Platform</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🏢</span>
                                    <input type="text" value="RinjaniGuide & Rental" class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed" disabled>
                                </div>
                            </div>

                            <!-- Email Formal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Formal</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✉️</span>
                                    <input type="email" value="halo@rinjaniguide.id" class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed" disabled>
                                </div>
                            </div>

                            <!-- No WhatsApp -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Formal</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📞</span>
                                    <input type="text" value="0819-8765-4321" class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional Support</label>
                            <div class="flex items-center gap-4">
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 mb-1 block">Buka</span>
                                    <input type="time" value="08:00" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                                </div>
                                <span class="text-gray-400 mt-5">-</span>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 mb-1 block">Tutup</span>
                                    <input type="time" value="20:00" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 mb-1 block">Hari Kerja</span>
                                    <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                                        <option>Senin - Sabtu</option>
                                        <option>Setiap Hari</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm">
                                Simpan Pengaturan Platform
                            </button>
                        </div>
                    </div>

                    <!-- KARTU 3: MODE PEMELIHARAAN (Warna Kemerahan) -->
                    <div class="bg-red-50 rounded-2xl border border-red-200 shadow-sm p-8 relative overflow-hidden">
                        <div class="flex items-start justify-between mb-4 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-red-800">Mode Pemeliharaan</h3>
                                    <p class="text-sm text-red-700">Aktifkan mode pemeliharaan untuk menutup sementara akses ke platform bagi publik. Hanya akun administrator yang dapat login dan mengakses dashboard.</p>
                                </div>
                            </div>

                            <!-- Toggle Switch (Desain Statis) -->
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-semibold text-red-800">Aktifkan Mode Pemeliharaan</span>
                                <div class="w-12 h-6 bg-red-200 rounded-full relative cursor-pointer">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-red-500 mt-6 flex items-center gap-1 relative z-10">
                            ⚠️ Administrator yang tidak berperan sebagai Superadmin tidak akan bisa mengakses platform saat mode ini aktif.
                        </p>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>