<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Komisi Platform - RinjaniGuide Admin</title>
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
                    <h2 class="text-2xl font-bold text-gray-900">Atur Komisi Platform</h2>
                    <p class="text-sm text-gray-500">Atur persentase komisi yang dikenakan dari setiap transaksi pada platform RinjaniGuide.</p>
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
            <div class="flex-1 overflow-y-auto p-8 pb-24">
                <div class="max-w-4xl mx-auto space-y-6">

                    <!-- 1. KARTU ATAS: SAAT INI & SIMULASI -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Kartu Komisi Saat Ini -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 relative overflow-hidden">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Komisi Saat Ini</h3>
                                <span class="bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded text-[10px] font-bold">✓ AKTIF</span>
                            </div>
                            <div class="flex items-baseline gap-1 mb-2">
                                <span class="text-6xl font-black text-orange-500">10</span>
                                <span class="text-3xl font-bold text-orange-500">%</span>
                            </div>
                            <p class="text-sm text-gray-500 mb-8">Dari setiap transaksi berlaku</p>
                            
                            <div class="flex justify-between items-end border-t border-gray-100 pt-4">
                                <div>
                                    <p class="text-xs text-gray-400 mb-0.5">Berlaku sejak</p>
                                    <p class="text-sm font-bold text-gray-900">1 Apr 2026</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 mb-0.5">Diubah oleh</p>
                                    <p class="text-sm font-bold text-gray-900">Rizki Aditya</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Simulasi Perhitungan -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                            <div class="flex justify-between items-start mb-6">
                                <h3 class="text-sm font-bold text-gray-900">Simulasi Perhitungan</h3>
                                <button class="text-[11px] text-gray-500 border border-gray-300 px-2 py-1 rounded hover:bg-gray-50">Lihat Rincian</button>
                            </div>
                            <p class="text-xs text-gray-500 mb-4">Contoh transaksi senilai Rp 1.000.000:</p>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Nilai Transaksi</span>
                                    <span class="font-bold text-gray-900">Rp 1.000.000</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Komisi Platform (10%)</span>
                                    <span class="font-bold text-orange-500">Rp 100.000</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Pendapatan Mitra (90%)</span>
                                    <span class="font-bold text-green-600">Rp 900.000</span>
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <p class="text-[10px] text-gray-400 flex items-center gap-1">ℹ️ Perubahan akan otomatis update saat komisi berubah.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. KARTU UBAH PERSENTASE (SLIDER) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Ubah Persentase Komisi</h3>
                        <p class="text-sm text-gray-500 mb-8">Komisi akan otomatis ditagihkan dari setiap transaksi baru.</p>

                        <!-- Box Input Persentase -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center mb-8">
                            <label class="block text-sm font-semibold text-gray-600 mb-3">Persentase Komisi (%)</label>
                            <div class="inline-flex items-center justify-center bg-white border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                                <input type="number" value="10" class="w-16 text-center text-3xl font-bold text-gray-900 focus:outline-none bg-transparent">
                                <span class="text-2xl font-bold text-gray-400 ml-1">%</span>
                            </div>
                        </div>

                        <!-- Slider Range -->
                        <div class="px-4">
                            <input type="range" min="1" max="30" value="10" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-orange-500 mb-4">
                            <div class="flex justify-between text-xs font-semibold text-gray-400">
                                <span>1%</span>
                                <span>15%</span>
                                <span>30%</span>
                            </div>
                        </div>

                        <!-- Preset Buttons -->
                        <div class="flex justify-center gap-2 mt-6">
                            <span class="text-xs text-gray-500 mr-2 self-center">Preset Cepat:</span>
                            <button class="px-3 py-1 border border-gray-300 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">5%</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">8%</button>
                            <button class="px-4 py-1 bg-orange-500 text-white rounded text-xs font-bold shadow-sm">10%</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">15%</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">20%</button>
                        </div>
                    </div>

                    <!-- 3. PERINGATAN KUNING -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-yellow-500 text-lg mt-0.5">⚠️</span>
                        <p class="text-sm text-yellow-800 font-medium">Perubahan komisi akan berlaku untuk transaksi baru. Transaksi yang sudah dibayar tetap memakai komisi lama.</p>
                    </div>

                    <!-- 4. TABEL RIWAYAT PERUBAHAN -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Riwayat Perubahan</h3>
                            <span class="text-xs text-gray-400">Total 3 riwayat tercatat</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold">Komisi Lama</th>
                                        <th class="px-6 py-4 font-semibold">Komisi Baru</th>
                                        <th class="px-6 py-4 font-semibold">Diubah Oleh</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <!-- Baris 1 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">1 Apr 2026</td>
                                        <td class="px-6 py-4">8%</td>
                                        <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full text-xs font-bold">10%</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rizki Aditya</td>
                                    </tr>
                                    <!-- Baris 2 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">1 Jan 2026</td>
                                        <td class="px-6 py-4">10%</td>
                                        <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full text-xs font-bold">8%</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rizki Aditya</td>
                                    </tr>
                                    <!-- Baris 3 -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">1 Sep 2025</td>
                                        <td class="px-6 py-4">—</td>
                                        <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full text-xs font-bold">10%</span></td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Rizki Aditya <span class="text-xs text-gray-400 font-normal">(awal)</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 5. FLOATING ACTION BAR (Bawah) -->
            <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 px-8 flex justify-end gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20">
                <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Batalkan</button>
                <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm flex items-center gap-2">
                    💾 Simpan Perubahan
                </button>
            </div>

        </main>
    </div>
</body>
</html>