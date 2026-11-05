<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Transaksi Global - RinjaniGuide Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0 z-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Rekap Transaksi Global</h2>
                    <p class="text-sm text-gray-500">Pantau seluruh pendapatan, data demografi, dan strategi bisnis.</p>
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
            </header>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- 1. KARTU RINGKASAN -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Total Transaksi -->
                        <div class="bg-white rounded-xl border border-orange-200 p-5 shadow-sm flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Total Transaksi</p>
                                <h3 class="text-2xl font-bold text-gray-900">128 <span class="text-sm font-normal text-gray-500">dalam 30 hari</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        
                        <!-- Total Omzet -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Total Omzet</p>
                                <h3 class="text-2xl font-bold text-gray-900">Rp 156.400.000</h3>
                            </div>
                            <div class="w-12 h-12 bg-gray-50 text-gray-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                        </div>

                        <!-- Total Komisi -->
                        <div class="bg-white rounded-xl border border-orange-200 p-5 shadow-sm flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Total Komisi Platform</p>
                                <h3 class="text-2xl font-bold text-orange-500">Rp 15.640.000</h3>
                            </div>
                            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- 2. FILTER & PENCARIAN -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="relative mb-4">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" placeholder="Cari kode pesanan atau nama pemesan..." class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Periode</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Bulan Ini</option>
                                    <option>7 Hari Terakhir</option>
                                    <option>Tahun Ini</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Status</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                    <option>Lunas</option>
                                    <option>Menunggu</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Jenis Layanan</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                    <option>Pemandu</option>
                                    <option>Rental</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Tipe</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2">
                            <div class="flex gap-2">
                                <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-bold transition shadow-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                    Terapkan Filter
                                </button>
                                <button class="text-gray-500 hover:text-gray-800 px-4 py-2 text-sm font-semibold transition">Reset</button>
                            </div>
                            <div class="flex gap-2">
                                <button class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Ekspor CSV
                                </button>
                                <button class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Ekspor Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 3. TABEL TRANSAKSI -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Transaksi</h3>
                            <p class="text-sm text-gray-500">Menampilkan 128 transaksi.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Pemesan</th>
                                        <th class="px-6 py-4 font-semibold">Pemandu</th>
                                        <th class="px-6 py-4 font-semibold">Toko Rental</th>
                                        <th class="px-6 py-4 font-semibold">Total</th>
                                        <th class="px-6 py-4 font-semibold">Komisi</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    
                                    <!-- Baris 1 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0004</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">24/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Maya Sari</td>
                                        <td class="px-6 py-4 text-xs">Dewi Lestari</td>
                                        <td class="px-6 py-4 text-xs">Rinjani Outdoor</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.320.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 132.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 2 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0003</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">25/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Budi Hartono</td>
                                        <td class="px-6 py-4 text-xs">Ahmad Rifai</td>
                                        <td class="px-6 py-4 text-xs">Sembalun Gear</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 2.150.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 215.000</td>
                                        <td class="px-6 py-4"><span class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Menunggu</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 3 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0002</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">22/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Sarah Wijaya</td>
                                        <td class="px-6 py-4 text-xs">-</td>
                                        <td class="px-6 py-4 text-xs">Rinjani Outdoor</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 890.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 89.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 4 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">14/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Andi Pratama</td>
                                        <td class="px-6 py-4 text-xs">Ahmad Rifai</td>
                                        <td class="px-6 py-4 text-xs">-</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.470.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 147.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 5 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0008</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">10/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Budi Hartono</td>
                                        <td class="px-6 py-4 text-xs">-</td>
                                        <td class="px-6 py-4 text-xs">Rinjani Outdoor</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 300.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 30.000</td>
                                        <td class="px-6 py-4"><span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Selesai</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 6 -->
                                    <tr class="hover:bg-gray-50 transition border-b-2 border-gray-200">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0007</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">03/Mei<br><span class="text-gray-400">2026</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Maya Sari</td>
                                        <td class="px-6 py-4 text-xs">Dewi Lestari</td>
                                        <td class="px-6 py-4 text-xs">-</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.320.000</td>
                                        <td class="px-6 py-4 font-semibold text-orange-500">Rp 132.000</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="p-4 border-t border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 gap-4">
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-400 cursor-not-allowed text-xs">← Sebelumnya</button>
                                <button class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-50 text-xs">Berikutnya →</button>
                            </div>
                            <span>Halaman 1 dari 13</span>
                            <div class="flex items-center gap-2">
                                <span>Tampilkan</span>
                                <select class="border-gray-300 rounded-md text-sm py-1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                <span>per halaman</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. LOG AUDIT PEMBAYARAN -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Log Audit Pembayaran</h3>
                            <a href="{{ route('admin.log-audit') ?? '#' }}" class="text-sm text-orange-500 font-semibold hover:underline">Lihat Semua Log →</a>
                        </div>
                        <div class="p-6 space-y-4">
                            
                            <!-- Log 1 -->
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="flex-1 border-b border-gray-50 pb-4">
                                    <p class="text-sm text-gray-800">Webhook berhasil: <span class="font-bold">RJN-2026-0004</span></p>
                                    <p class="text-xs text-gray-500">Sistem memproses status pembayaran lunas.</p>
                                </div>
                                <span class="text-xs text-gray-400">24/05/2026, 14:32 WIB</span>
                            </div>

                            <!-- Log 2 -->
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="flex-1 border-b border-gray-50 pb-4">
                                    <p class="text-sm text-gray-800">Webhook berhasil: <span class="font-bold">RJN-2026-0002</span></p>
                                    <p class="text-xs text-gray-500">Sistem memproses status pembayaran lunas.</p>
                                </div>
                                <span class="text-xs text-gray-400">22/05/2026, 09:15 WIB</span>
                            </div>

                            <!-- Log 3 (Error) -->
                            <div class="flex items-start gap-4 bg-red-50 p-3 rounded-lg -mx-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-red-800">Webhook gagal: Signature tidak valid</p>
                                    <p class="text-xs text-red-600">HMAC-SHA256 tidak cocok dengan secret-key server.</p>
                                </div>
                                <span class="text-xs text-red-400">22/05/2026, 09:14 WIB</span>
                            </div>

                            <!-- Log 4 -->
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="flex-1 pb-2">
                                    <p class="text-sm text-gray-800">Webhook berhasil: <span class="font-bold">RJN-2026-0001</span></p>
                                    <p class="text-xs text-gray-500">Sistem memproses status pembayaran lunas.</p>
                                </div>
                                <span class="text-xs text-gray-400">14/05/2026, 14:12 WIB</span>
                            </div>

                        </div>
                    </div>

                    <!-- 5. EMPTY STATE (Bawah) -->
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-12 flex flex-col items-center justify-center text-center mt-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Tidak Ada Transaksi</h3>
                        <p class="text-sm text-gray-500 mb-6">Coba ubah filter atau reset pencarian untuk menampilkan data.</p>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm flex items-center gap-2">
                            🔄 Reset Filter
                        </button>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>