<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Katalog - RinjaniGuide Admin</title>
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
                    <h2 class="text-2xl font-bold text-gray-900">Moderasi Katalog</h2>
                    <p class="text-sm text-gray-500">Kelola dan moderasi status publikasi mitra pemandu serta inventaris alat sewa.</p>
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

                    <!-- 1. TAB MENU (PEMANDU / ALAT SEWA) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tab Pemandu (Aktif) -->
                        <div class="bg-white rounded-xl border border-orange-500 shadow-sm p-4 flex items-center justify-between cursor-pointer relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-orange-500"></div>
                            <div class="flex items-center gap-3 pl-2">
                                <span class="text-xl">🧗‍♂️</span>
                                <span class="font-bold text-gray-900">Pemandu</span>
                            </div>
                            <span class="bg-orange-100 text-orange-600 font-bold px-2 py-0.5 rounded text-sm">34</span>
                        </div>
                        
                        <!-- Tab Alat Sewa (Tidak Aktif) -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3 pl-2">
                                <span class="text-xl">🎒</span>
                                <span class="font-bold text-gray-500">Alat Sewa</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 font-bold px-2 py-0.5 rounded text-sm">48</span>
                        </div>
                    </div>

                    <!-- 2. FILTER & PENCARIAN -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex flex-col md:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1 relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" placeholder="Cari nama pemandu atau alat..." class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                        </div>
                        <!-- Status -->
                        <div class="w-full md:w-48">
                            <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
                        </div>
                        <!-- Sort -->
                        <div class="w-full md:w-48">
                            <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option>Terbaru</option>
                                <option>Rating Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. BULK ACTION BAR -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-3 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-3 pl-2">
                            <input type="checkbox" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-500">0 item dipilih</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="border border-green-500 text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                ✅ Aktifkan Terpilih
                            </button>
                            <button class="border border-red-500 text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                ❌ Nonaktifkan Terpilih
                            </button>
                        </div>
                    </div>

                    <!-- 4. TABEL DATA -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-4 py-4 w-10"><input type="checkbox" class="rounded border-gray-300 text-orange-500"></th>
                                        <th class="px-4 py-4 font-semibold">Foto</th>
                                        <th class="px-6 py-4 font-semibold">Nama Pemandu</th>
                                        <th class="px-6 py-4 font-semibold">Jalur Keahlian</th>
                                        <th class="px-6 py-4 font-semibold">Tarif/Hari</th>
                                        <th class="px-6 py-4 font-semibold">Rating</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    
                                    <!-- Baris 1 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4"><input type="checkbox" class="rounded border-gray-300 text-orange-500"></td>
                                        <td class="px-4 py-4">
                                            <div class="w-10 h-10 bg-[#143529] rounded-lg flex items-center justify-center text-white font-bold text-xs">AR</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900">Ahmad Rifai</p>
                                            <p class="text-xs text-gray-500">Reg. APGI-ID-001</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-semibold">Sembalun</span>
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-semibold">Senaru</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 400.000</td>
                                        <td class="px-6 py-4 text-yellow-500 font-bold">★ 4.9</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif</span></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button class="border border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Detail</button>
                                                <button class="border border-red-200 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Nonaktifkan</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Baris 2 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4"><input type="checkbox" class="rounded border-gray-300 text-orange-500"></td>
                                        <td class="px-4 py-4">
                                            <div class="w-10 h-10 bg-[#143529] rounded-lg flex items-center justify-center text-white font-bold text-xs">SR</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900">Siti Rahayu</p>
                                            <p class="text-xs text-gray-500">Reg. APGI-ID-014</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-semibold">Senaru</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 375.000</td>
                                        <td class="px-6 py-4 text-yellow-500 font-bold">★ 4.8</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif</span></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button class="border border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Detail</button>
                                                <button class="border border-red-200 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Nonaktifkan</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Baris 3 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4"><input type="checkbox" class="rounded border-gray-300 text-orange-500"></td>
                                        <td class="px-4 py-4">
                                            <div class="w-10 h-10 bg-[#143529] rounded-lg flex items-center justify-center text-white font-bold text-xs">BS</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900">Budi Santoso</p>
                                            <p class="text-xs text-gray-500">Reg. APGI-ID-022</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-semibold">Torean</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rp 450.000</td>
                                        <td class="px-6 py-4 text-yellow-500 font-bold">★ 4.7</td>
                                        <td class="px-6 py-4"><span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif</span></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button class="border border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Detail</button>
                                                <button class="border border-red-200 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Nonaktifkan</button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- Footer Tabel -->
                        <div class="p-4 border-t border-gray-100 bg-gray-50 text-center">
                            <p class="text-sm text-gray-500">© 2026 RinjaniGuide & Rental. Ekspedisi Resmi Gunung Rinjani - TNGR.</p>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>