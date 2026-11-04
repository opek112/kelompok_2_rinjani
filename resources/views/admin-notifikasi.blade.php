<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - RinjaniGuide Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR  -->
      @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2>
                    <p class="text-sm text-gray-500">Pemantauan metrik transaksi, verifikasi gateway, dan status operasional platform.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4 text-sm font-medium">
                        <span class="text-orange-500 flex items-center gap-1"><span class="text-red-500">●</span> 5 notifikasi belum dibaca</span>
                        <a href="#" class="text-gray-500 hover:text-orange-500 transition">Tandai Semua Dibaca</a>
                    </div>
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
            </header>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Filter Tabs -->
                    <div class="flex items-center gap-6 border-b border-gray-200 mb-6">
                        <button class="text-orange-500 font-bold border-b-2 border-orange-500 pb-3 px-1">Semua <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full text-xs ml-1">9</span></button>
                        <button class="text-gray-500 hover:text-gray-800 font-semibold pb-3 px-1 transition">Belum Dibaca <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs ml-1">5</span></button>
                        <button class="text-gray-500 hover:text-gray-800 font-semibold pb-3 px-1 transition">Sudah Dibaca</button>
                    </div>

                    <!-- DAFTAR NOTIFIKASI (STATIS) -->
                    <div class="space-y-4">
                        
                        <!-- Notif 1: Verifikasi -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-orange-400"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-gray-900 text-sm">Pendaftaran Mitra Baru</h3>
                                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">Joko Wijaya mendaftar sebagai <span class="font-semibold">Pemandu</span>. Menunggu verifikasi.</p>
                                    <p class="text-xs text-gray-400">5 menit lalu • <a href="#" class="text-orange-500 hover:underline">Buka Verifikasi →</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 2: Peringatan -->
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-red-800 text-sm">Webhook Pembayaran Gagal</h3>
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    </div>
                                    <p class="text-sm text-red-700 mb-2">Signature tidak valid pada RJN-2026-0003. Periksa integrasi.</p>
                                    <p class="text-xs text-red-500">3 menit lalu • <a href="#" class="font-semibold hover:underline">Periksa Log →</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 3: Transaksi -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-green-500"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-green-800 text-sm">Transaksi Baru Berhasil</h3>
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    </div>
                                    <p class="text-sm text-green-700 mb-2">RJN-2026-0004 sebesar Rp 1.320.000 telah dibayar lunas.</p>
                                    <p class="text-xs text-green-600">7 menit lalu • <a href="#" class="font-semibold hover:underline">Lihat Transaksi →</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 4: Sistem -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-blue-800 text-sm">Pengujian Mode Sandbox</h3>
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    </div>
                                    <p class="text-sm text-blue-700 mb-2">Payment gateway masih dalam mode sandbox, lakukan uji sebelum production.</p>
                                    <p class="text-xs text-blue-500">10 menit lalu • <a href="#" class="font-semibold hover:underline">Pengaturan Gateway →</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 5: Keuangan -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-green-600"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-green-800 text-sm">Pencapaian Massal Berhasil</h3>
                                        <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                    </div>
                                    <p class="text-sm text-green-700 mb-2">26 mitra telah menerima pencairan total Rp 14.850.000.</p>
                                    <p class="text-xs text-green-600">15 menit lalu • <a href="#" class="font-semibold hover:underline">Detail Pencairan →</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 6: Sudah Dibaca (Laporan) -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-gray-300"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="font-bold text-gray-700 text-sm">Laporan Harian Siap</h3>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">Laporan transaksi 25 Mei 2026 sudah tersedia. Buka untuk melihat detail.</p>
                                    <p class="text-xs text-gray-400">2 jam lalu • <a href="#" class="text-orange-500 hover:underline">Unduh Laporan →</a></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- State Kosong / End of List -->
                    <div class="mt-8 border-t border-gray-200 border-dashed pt-8 pb-12 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Tidak Ada Notifikasi Baru</h3>
                        <p class="text-sm text-gray-500 mb-4">Semua notifikasi operasional dan sistem sudah Anda baca dan tindak lanjuti.</p>
                        <button class="bg-[#143529] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#1a402f] transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Ekspor Riwayat Notifikasi (PDF)
                        </button>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>