@extends('layouts.guide')

@section('title', 'Pendapatan')
@section('header', 'Pendapatan')
@section('subheader', 'Pusat Keuangan')

@section('content')
    <!-- 3 Kartu Finansial -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-semibold text-gray-600">Pendapatan Kotor</p>
                <span class="bg-orange-50 text-orange-500 p-2 rounded-lg">💵</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-2">Rp 6.800.000</h3>
            <p class="text-xs text-gray-500 flex items-center gap-1">📅 Bulan Ini</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-semibold text-gray-600">Komisi Platform (10%)</p>
                <span class="bg-gray-100 text-gray-600 p-2 rounded-lg">%</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-2">Rp 680.000</h3>
            <p class="text-xs text-gray-500 flex items-center gap-1">ℹ️ Bulan Ini</p>
        </div>

        <div class="bg-orange-50 p-6 rounded-xl border-2 border-orange-500 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-bold text-orange-600">Pendapatan Bersih</p>
                <span class="bg-orange-500 text-white p-2 rounded-lg">🛍️</span>
            </div>
            <h3 class="text-3xl font-bold text-orange-600 mb-2">Rp 6.120.000</h3>
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-gray-600 font-medium">Siap Dicairkan</p>
                <span class="text-[10px] bg-green-200 text-green-800 px-2 py-1 rounded-full font-bold">Tersedia</span>
            </div>
        </div>
    </div>

    <!-- Filter & Unduh -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex justify-between items-center mb-6">
        <div class="flex items-center gap-3 text-sm">
            <span class="font-bold text-gray-700">Bulan:</span>
            <select class="border-gray-300 rounded-lg py-1.5 focus:ring-orange-500 focus:border-orange-500"><option>Mei</option></select>
            <span class="font-bold text-gray-700 ml-2">Tahun:</span>
            <select class="border-gray-300 rounded-lg py-1.5 focus:ring-orange-500 focus:border-orange-500"><option>2026</option></select>
            <button class="ml-2 font-bold text-gray-800 hover:text-orange-500">Terapkan</button>
        </div>
        <button class="bg-orange-500 text-white font-bold px-4 py-2 rounded-lg text-sm flex items-center gap-2 hover:bg-orange-600">⬇️ Unduh Laporan</button>
    </div>

    <!-- Grafik 6 Bulan Terakhir (Simulasi CSS Bar Chart) -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Pendapatan 6 Bulan Terakhir</h3>
                <p class="text-xs text-gray-500">Total pendapatan bersih per bulan.</p>
            </div>
            <div class="flex gap-4 text-xs">
                <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Pendapatan Bersih</div>
                <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#1e4035]"></span> Bulan Sebelumnya</div>
            </div>
        </div>

        <!-- Bar Chart Area -->
        <div class="h-64 flex items-end justify-between px-8 relative border-b border-gray-200 pb-2">
            <!-- Grid Lines (simulasi) -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-20 pb-2">
                <div class="border-t border-gray-400 w-full"></div>
                <div class="border-t border-gray-400 w-full"></div>
                <div class="border-t border-gray-400 w-full"></div>
                <div class="border-t border-gray-400 w-full"></div>
            </div>

            <!-- Bar 1 -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-gray-600">Rp 4.200.000</span>
                <div class="w-full bg-[#1e4035] rounded-t-md" style="height: 120px;"></div>
                <span class="text-xs font-semibold text-gray-500 mt-2">Des 2025</span>
            </div>
            <!-- Bar 2 -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-gray-600">Rp 3.800.000</span>
                <div class="w-full bg-[#1e4035] rounded-t-md" style="height: 100px;"></div>
                <span class="text-xs font-semibold text-gray-500 mt-2">Jan 2026</span>
            </div>
            <!-- Bar 3 -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-gray-600">Rp 4.500.000</span>
                <div class="w-full bg-[#1e4035] rounded-t-md" style="height: 130px;"></div>
                <span class="text-xs font-semibold text-gray-500 mt-2">Feb 2026</span>
            </div>
            <!-- Bar 4 -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-gray-600">Rp 5.100.000</span>
                <div class="w-full bg-[#1e4035] rounded-t-md" style="height: 150px;"></div>
                <span class="text-xs font-semibold text-gray-500 mt-2">Mar 2026</span>
            </div>
            <!-- Bar 5 -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-gray-600">Rp 5.600.000</span>
                <div class="w-full bg-[#1e4035] rounded-t-md" style="height: 170px;"></div>
                <span class="text-xs font-semibold text-gray-500 mt-2">Apr 2026</span>
            </div>
            <!-- Bar 6 (Bulan Ini) -->
            <div class="flex flex-col items-center gap-2 z-10 w-16">
                <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-1 rounded">Bulan Ini <br> Rp 6.120.000</span>
                <div class="w-full bg-orange-500 rounded-t-md" style="height: 200px;"></div>
                <span class="text-xs font-bold text-orange-600 mt-2">Mei 2026</span>
            </div>
        </div>
    </div>

    <!-- Riwayat Pendampingan -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
        <div class="p-6 flex justify-between items-center border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Riwayat Pendampingan</h3>
                <p class="text-xs text-gray-500">Rincian pendapatan bersih dari ekspedisi terverifikasi.</p>
            </div>
            <span class="bg-orange-50 text-orange-600 text-xs font-bold px-3 py-1 rounded-full border border-orange-200">• 5 Ekspedisi Bulan Ini</span>
        </div>
        
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Kode Pesanan</th>
                    <th class="px-6 py-4">Pemesan</th>
                    <th class="px-6 py-4">Jalur</th>
                    <th class="px-6 py-4">Pendapatan Kotor</th>
                    <th class="px-6 py-4">Komisi (10%)</th>
                    <th class="px-6 py-4">Pendapatan Bersih</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">14-16 Mei 2026</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">RJN - 2026 - 0001</td>
                    <td class="px-6 py-4 text-gray-800">Andi Pratama</td>
                    <td class="px-6 py-4"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Sembalun</span></td>
                    <td class="px-6 py-4 text-gray-600">Rp 1.200.000</td>
                    <td class="px-6 py-4 text-gray-600">Rp 120.000</td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp 1.080.000</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">22-24 Mei 2026</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">RJN - 2026 - 0012</td>
                    <td class="px-6 py-4 text-gray-800">Sarah Wijaya</td>
                    <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">Senaru</span></td>
                    <td class="px-6 py-4 text-gray-600">Rp 1.125.000</td>
                    <td class="px-6 py-4 text-gray-600">Rp 112.500</td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp 1.012.500</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">3-5 Mei 2026</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">RJN - 2026 - 0034</td>
                    <td class="px-6 py-4 text-gray-800">Budi Hartono</td>
                    <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded">Torean</span></td>
                    <td class="px-6 py-4 text-gray-600">Rp 1.275.000</td>
                    <td class="px-6 py-4 text-gray-600">Rp 127.500</td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp 1.147.500</td>
                </tr>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex justify-between items-center text-xs">
            <button class="px-3 py-1.5 border border-gray-300 rounded bg-gray-100 text-gray-400 flex items-center gap-1">← Sebelumnya</button>
            <span class="text-gray-500">Halaman 1 dari 3</span>
            <button class="px-3 py-1.5 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 flex items-center gap-1">Berikutnya →</button>
        </div>
    </div>

    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center flex flex-col items-center justify-center">
        <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl mb-4">🧾</div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pendapatan</h3>
        <p class="text-sm text-gray-500 max-w-sm mb-6">Riwayat pendampingan Anda akan muncul di sini setelah menyelesaikan tugas pertama.</p>
        <button class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600 flex items-center gap-2">📅 Atur Ketersediaan</button>
    </div>
@endsection