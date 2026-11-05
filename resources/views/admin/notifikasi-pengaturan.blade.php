<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferensi Notifikasi - RinjaniGuide Admin</title>
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
                        <p class="text-sm text-gray-500">Kelola konfigurasi sistem, parameter operasional, dan preferensi platform.</p>
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
                <a href="{{ route('admin.pengaturan') ?? '#' }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
                    ⚙️ Preferensi Sistem
                </a>
                <a href="{{ route('admin.keamanan') ?? '#' }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
                    🛡️ Keamanan Akun
                </a>
                <a href="{{ route('admin.integrasi') ?? '#' }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
                    🔗 Integrasi
                </a>
                <!-- Tab Notifikasi (Aktif) -->
                <a href="#" class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">
                    🔔 Notifikasi
                </a>
            </div>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto space-y-6">

                    <!-- 1. NOTIFIKASI EMAIL -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Email</h3>
                        <p class="text-sm text-gray-500 mb-6">Terima email untuk aktivitas platform.</p>

                        <div class="space-y-6">
                            <!-- Toggle 1 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Pendaftaran Mitra Baru</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim email saat ada pendaftaran pemandu atau toko rental baru.</p>
                                </div>
                                <!-- Toggle Switch Aktif -->
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 2 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Transaksi Baru</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim email saat ada transaksi berhasil.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 3 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Webhook Gagal</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim email saat webhook pembayaran gagal.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 4 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Laporan Harian</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim ringkasan harian setiap pukul 08:00 WIB.</p>
                                </div>
                                <!-- Toggle Switch Nonaktif -->
                                <div class="w-11 h-6 bg-gray-200 rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 5 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Laporan Mingguan</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim ringkasan performa platform setiap Senin pagi.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm">
                                💾 Simpan Preferensi Email
                            </button>
                        </div>
                    </div>

                    <!-- 2. NOTIFIKASI PUSH -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Push</h3>
                        <p class="text-sm text-gray-500 mb-6">Notifikasi di browser dan aplikasi.</p>

                        <div class="space-y-6">
                            <!-- Toggle 1 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Aktivitas Penting</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Notifikasi untuk aksi penting (verifikasi, komisi, moderasi).</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 2 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Login dan Pengingat Baru</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Notifikasi saat ada login dari perangkat baru.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 3 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Peringatan Keamanan</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Notifikasi saat ada aktivitas mencurigakan.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm">
                                💾 Simpan Preferensi Push
                            </button>
                        </div>
                    </div>

                    <!-- 3. NOTIFIKASI WHATSAPP -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi WhatsApp</h3>
                        <p class="text-sm text-gray-500 mb-6">Notifikasi penting via WhatsApp.</p>

                        <div class="space-y-6">
                            <!-- Toggle 1 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Webhook Gagal</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim WhatsApp saat webhook pembayaran gagal berulang kali.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 2 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Peringatan Keamanan</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim WhatsApp saat ada aktivitas mencurigakan.</p>
                                </div>
                                <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                                </div>
                            </div>

                            <!-- Toggle 3 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Mode Pemeliharaan Aktif</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim WhatsApp saat mode pemeliharaan diaktifkan.</p>
                                </div>
                                <!-- Toggle Switch Nonaktif -->
                                <div class="w-11 h-6 bg-gray-200 rounded-full relative cursor-pointer shrink-0">
                                    <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm">
                                💾 Simpan Preferensi WhatsApp
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>