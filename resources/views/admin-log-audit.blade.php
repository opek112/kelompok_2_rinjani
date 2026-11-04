<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Audit - RinjaniGuide Admin</title>
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
                    <h2 class="text-2xl font-bold text-gray-900">Log Audit</h2>
                    <p class="text-sm text-gray-500">Catatan aktivitas platform untuk keperluan audit dan investigasi.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Notifikasi -->
                    <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                        <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    </a>
                    <!-- Profile -->
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

                    <!-- 1. WIDGET RINGKASAN -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Total Log -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">47</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Total Log Hari Ini</p>
                            </div>
                        </div>
                        <!-- Webhook Berhasil -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-50 text-green-500 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">38</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Webhook Berhasil</p>
                            </div>
                        </div>
                        <!-- Webhook Gagal -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">3</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Webhook Gagal</p>
                            </div>
                        </div>
                        <!-- Aksi Admin -->
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">6</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Aksi Admin</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. FILTER & PENCARIAN -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <!-- Search Input -->
                        <div class="relative mb-4">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" placeholder="Cari kata kunci, nama pengguna, atau ID..." class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                        </div>
                        
                        <!-- Dropdowns -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Kategori</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                    <option>Verifikasi Mitra</option>
                                    <option>Pengaturan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Pengguna</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Periode</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Hari ini</option>
                                    <option>7 Hari Terakhir</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Status</label>
                                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    <option>Semua</option>
                                    <option>Berhasil</option>
                                    <option>Gagal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
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
                                    Ekspor PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 3. TABEL LOG AUDIT -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Aktivitas Platform</h3>
                                <p class="text-sm text-gray-500">Menampilkan 47 log hari ini.</p>
                            </div>
                            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-200 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Auto-refresh: Aktif
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Waktu</th>
                                        <th class="px-6 py-4 font-semibold">Pengguna</th>
                                        <th class="px-6 py-4 font-semibold w-1/3">Aktivitas</th>
                                        <th class="px-6 py-4 font-semibold">Kategori</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    
                                    <!-- Baris 1 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-[10px]">✓</div>
                                                <span>26 Mei 2026, 14:32</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Rizki Aditya</td>
                                        <td class="px-6 py-4">Menyetujui pendaftaran pemandu: Joko Wijaya</td>
                                        <td class="px-6 py-4"><span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-semibold border border-blue-100">Verifikasi Mitra</span></td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 2 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-[10px]">✎</div>
                                                <span>26 Mei 2026, 13:15</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Rizki Aditya</td>
                                        <td class="px-6 py-4">Mengubah komisi dari 8% menjadi 10%</td>
                                        <td class="px-6 py-4"><span class="bg-purple-50 text-purple-600 px-2 py-1 rounded text-xs font-semibold border border-purple-100">Pengaturan</span></td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 3 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px]">⚙️</div>
                                                <span>26 Mei 2026, 10:48</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Sistem</td>
                                        <td class="px-6 py-4">Webhook diproses untuk pesanan RJN-2026-0004</td>
                                        <td class="px-6 py-4"><span class="bg-orange-50 text-orange-600 px-2 py-1 rounded text-xs font-semibold border border-orange-100">Pembayaran</span></td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 4 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-[10px]">!</div>
                                                <span>26 Mei 2026, 09:47</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Sistem</td>
                                        <td class="px-6 py-4">Webhook gagal: Signature tidak valid</td>
                                        <td class="px-6 py-4"><span class="bg-orange-50 text-orange-600 px-2 py-1 rounded text-xs font-semibold border border-orange-100">Pembayaran</span></td>
                                        <td class="px-6 py-4"><span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs font-bold border border-red-200">Gagal</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 5 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-[10px]">📦</div>
                                                <span>24 Mei 2026, 10:20</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Rizki Aditya</td>
                                        <td class="px-6 py-4">Menonaktifkan alat: Carrier 60L milik Senaru Camp</td>
                                        <td class="px-6 py-4"><span class="bg-pink-50 text-pink-600 px-2 py-1 rounded text-xs font-semibold border border-pink-100">Moderasi Katalog</span></td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 6 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px]">🔑</div>
                                                <span>23 Mei 2026, 09:05</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Linda Susanti</td>
                                        <td class="px-6 py-4">Login berhasil dari IP: 180.245.xx.xx</td>
                                        <td class="px-6 py-4"><span class="bg-cyan-50 text-cyan-600 px-2 py-1 rounded text-xs font-semibold border border-cyan-100">Autentikasi</span></td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>

                                    <!-- Baris 7 -->
                                    <tr class="hover:bg-gray-50 transition border-b-2 border-gray-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-[10px]">!</div>
                                                <span>23 Mei 2026, 08:55</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Tidak Dikenal</td>
                                        <td class="px-6 py-4">Login gagal: password salah (3x percobaan)</td>
                                        <td class="px-6 py-4"><span class="bg-cyan-50 text-cyan-600 px-2 py-1 rounded text-xs font-semibold border border-cyan-100">Autentikasi</span></td>
                                        <td class="px-6 py-4"><span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs font-bold border border-red-200">Gagal</span></td>
                                        <td class="px-6 py-4 text-center text-gray-400 cursor-pointer hover:text-orange-500">👁️</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="p-4 border-t border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 gap-4">
                            <div class="flex items-center gap-2">
                                <span>Tampilkan</span>
                                <select class="border-gray-300 rounded-md text-sm py-1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                <span>per halaman</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span>Halaman 1 dari 5</span>
                                <div class="flex gap-1">
                                    <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-400 cursor-not-allowed text-xs">Sebelumnya</button>
                                    <button class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-50 text-xs">Berikutnya →</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-blue-500 mt-0.5 text-lg">ℹ️</span>
                        <p class="text-sm text-blue-700">Log audit disimpan minimal 90 hari untuk keperluan audit dan investigasi.</p>
                    </div>

                    <!-- Empty State (Sesuai Gambar) -->
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-12 flex flex-col items-center justify-center text-center mt-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Tidak Ada Log</h3>
                        <p class="text-sm text-gray-500 mb-6">Cobalah ubah filter atau pencarian.</p>
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