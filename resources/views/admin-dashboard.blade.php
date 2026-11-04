<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RinjaniGuide</title>
    <!-- Menggunakan Vite & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin</h2>
                    <p class="text-sm text-gray-500">Pemantauan metrik operasional, transaksi ekosistem, dan aktivitas platform</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Notifikasi -->
                    <div class="relative">
                    <a href="{{ route('admin.notifikasi') }}" class="relative block">
                    <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    </a>
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
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- WIDGET CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                            <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">128</h3>
                            <p class="text-xs text-gray-500 mt-1">Total Transaksi</p>
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                            <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Rp 156.400.000</h3>
                            <p class="text-xs text-gray-500 mt-1">Total Omzet</p>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                            <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Rp 15.640.000</h3>
                            <p class="text-xs text-gray-500 mt-1">Komisi Platform</p>
                        </div>
                        <!-- Card 4 -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                            <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">24</h3>
                            <p class="text-xs text-gray-500 mt-1">Mitra Pemandu</p>
                        </div>
                        <!-- Card 5 -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                            <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">12</h3>
                            <p class="text-xs text-gray-500 mt-1">Mitra Rental</p>
                        </div>
                    </div>

                    <!-- ALERT BANNER -->
                    <div class="bg-[#fff9e6] border border-[#ffeeba] rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Butuh Perhatian</h4>
                                <p class="text-sm text-gray-600">2 pendaftaran mitra menunggu verifikasi.</p>
                            </div>
                        </div>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition">
                            Lihat Sekarang →
                        </button>
                    </div>

                    <!-- CHART SECTION -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Transaksi 6 Bulan Terakhir</h3>
                                <p class="text-sm text-gray-500">Total omzet per bulan.</p>
                            </div>
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button class="px-4 py-1.5 text-sm font-semibold text-white bg-orange-500 rounded-md shadow-sm">Omzet</button>
                                <button class="px-4 py-1.5 text-sm font-semibold text-gray-600 hover:text-gray-900">Jumlah Transaksi</button>
                            </div>
                        </div>

                        <!-- Fake Chart (HTML/CSS) -->
                        <div class="h-64 flex items-end justify-between px-4 pb-4 border-b border-gray-200 relative">
                            <!-- Grid Lines (Opsional) -->
                            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                                <div class="border-t border-gray-100 w-full h-0"></div>
                                <div class="border-t border-gray-100 w-full h-0"></div>
                                <div class="border-t border-gray-100 w-full h-0"></div>
                                <div class="border-t border-gray-100 w-full h-0"></div>
                            </div>

                            <!-- Bars -->
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 18jt</span>
                                <div class="w-10 bg-[#143529] rounded-t-md h-32 group-hover:bg-[#1a402f] transition"></div>
                                <span class="text-xs text-gray-500">Des 2025</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 22jt</span>
                                <div class="w-10 bg-[#143529] rounded-t-md h-40 group-hover:bg-[#1a402f] transition"></div>
                                <span class="text-xs text-gray-500">Jan</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 24jt</span>
                                <div class="w-10 bg-[#143529] rounded-t-md h-44 group-hover:bg-[#1a402f] transition"></div>
                                <span class="text-xs text-gray-500">Feb</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 28jt</span>
                                <div class="w-10 bg-[#143529] rounded-t-md h-52 group-hover:bg-[#1a402f] transition"></div>
                                <span class="text-xs text-gray-500">Mar</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 31jt</span>
                                <div class="w-10 bg-[#143529] rounded-t-md h-56 group-hover:bg-[#1a402f] transition"></div>
                                <span class="text-xs text-gray-500">Apr</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                                <span class="text-xs font-bold text-orange-500">Rp 33.4jt</span>
                                <div class="w-10 bg-orange-500 rounded-t-md h-60 shadow-lg shadow-orange-500/30"></div>
                                <span class="text-xs font-bold text-orange-500">Mei</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-3 text-[11px] text-gray-400">
                            <p>*Data agregat mencakup transaksi sewa alat dan reservasi pemandu terverifikasi.</p>
                            <p>Skala Otomatis (Rp 0 - Rp 40jt)</p>
                        </div>
                    </div>

                    <!-- TABEL TRANSAKSI -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 flex justify-between items-center border-b border-gray-100">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h3>
                                <p class="text-sm text-gray-500">Daftar transaksi pesanan terakhir yang diproses sistem</p>
                            </div>
                            <a href="#" class="text-sm text-orange-500 font-semibold hover:underline">Lihat Semua Transaksi →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                                        <th class="px-6 py-4 font-semibold">Pemesan</th>
                                        <th class="px-6 py-4 font-semibold">Total</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">26 Mei 2026</td>
                                        <td class="px-6 py-4 font-mono text-xs">RJN-2026-0004</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">Maya Sari</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.320.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">25 Mei 2026</td>
                                        <td class="px-6 py-4 font-mono text-xs">RJN-2026-0003</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">Budi Hartono</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 2.150.000</td>
                                        <td class="px-6 py-4"><span class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Menunggu</span></td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">22 Mei 2026</td>
                                        <td class="px-6 py-4 font-mono text-xs">RJN-2026-0002</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">Sarah Wijaya</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 890.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">14 Mei 2026</td>
                                        <td class="px-6 py-4 font-mono text-xs">RJN-2026-0001</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">Andi Pratama</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.470.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">10 Mei 2026</td>
                                        <td class="px-6 py-4 font-mono text-xs">RJN-2026-0008</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">Budi Hartono</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 300.000</td>
                                        <td class="px-6 py-4"><span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Selesai</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- AKTIVITAS TERBARU -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
                            <p class="text-sm text-gray-500">Catatan tindakan administratif dan sistem dalam ekosistem</p>
                        </div>
                        <div class="p-2">
                            <!-- List 1 -->
                            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition border-b border-gray-50">
                                <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Pendaftaran mitra disetujui: Joko Wijaya</p>
                                    <p class="text-xs text-gray-500">5 menit lalu</p>
                                </div>
                            </div>
                            <!-- List 2 -->
                            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition border-b border-gray-50">
                                <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Komisi platform diubah dari 8% menjadi 10%</p>
                                    <p class="text-xs text-gray-500">2 jam lalu</p>
                                </div>
                            </div>
                            <!-- List 3 -->
                            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition border-b border-gray-50">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Webhook pembayaran diterima: RJN-2026-0004</p>
                                    <p class="text-xs text-gray-500">3 jam lalu</p>
                                </div>
                            </div>
                            <!-- List 4 -->
                            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition border-b border-gray-50">
                                <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 text-red-600">Webhook gagal: signature tidak valid</p>
                                    <p class="text-xs text-gray-500">3 jam lalu</p>
                                </div>
                            </div>
                            <!-- List 5 -->
                            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition">
                                <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Alat baru ditambahkan: Carrier 60L</p>
                                    <p class="text-xs text-gray-500">Kemarin</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 text-right">
                            <a href="#" class="text-sm text-orange-500 font-semibold hover:underline">Lihat Semua Log Audit →</a>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>