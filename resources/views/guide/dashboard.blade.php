@extends('layouts.guide')

@section('title', 'Dashboard')
@section('header', 'Dashboard Kalender')
@section('subheader', 'Kelola ketersediaan hari ekspedisi dan konfirmasi pesanan pendaki.')

@section('content')
    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">📅</span>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Mei 2026</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">8 hari</h3>
            <p class="text-xs text-gray-500 mt-1">Jadwal Bulan Ini</p>
        </div>
        <div class="bg-white p-5 rounded-xl border-2 border-orange-400 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">⏱️</span>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded">Perlu Tindakan</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">2</h3>
            <p class="text-xs text-gray-500 mt-1">Menunggu Konfirmasi</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">⭐</span>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">42 Ulasan</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">4.9 <span class="text-sm text-gray-400 font-normal">/ 5.0</span></h3>
            <p class="text-xs text-gray-500 mt-1">Rating Pemandu</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">💵</span>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">+18% MoM</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">Rp 6.800.000</h3>
            <p class="text-xs text-gray-500 mt-1">Pendapatan Bulan Ini</p>
        </div>
    </div>

    <!-- Kalender -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Kalender Ketersediaan</h2>
                <p class="text-xs text-gray-500">Klik tanggal untuk mengubah status ketersediaan atau melihat detail pesanan.</p>
            </div>
            <div class="flex items-center gap-4 border border-gray-300 rounded-lg px-4 py-2">
                <span class="cursor-pointer text-gray-500"><</span>
                <span class="font-bold text-sm">Mei 2026</span>
                <span class="cursor-pointer text-gray-500">></span>
            </div>
        </div>
        
        <!-- Grid Kalender -->
        <div class="grid grid-cols-7 gap-2 mb-2 text-center text-xs font-bold text-gray-500">
            <div>SENIN</div><div>SELASA</div><div>RABU</div><div>KAMIS</div><div>JUMAT</div><div class="text-orange-500">SABTU</div><div class="text-red-500">MINGGU</div>
        </div>
        <div class="grid grid-cols-7 gap-2">
            <!-- Hari Kosong -->
            <div class="h-24 bg-gray-50 rounded-lg border border-gray-100 opacity-50"></div>
            <div class="h-24 bg-gray-50 rounded-lg border border-gray-100 opacity-50"></div>
            <div class="h-24 bg-gray-50 rounded-lg border border-gray-100 opacity-50"></div>
            <div class="h-24 bg-gray-50 rounded-lg border border-gray-100 opacity-50"></div>
            
            <!-- Tanggal 1-3 -->
            <div class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50">
                <span class="text-sm font-bold text-gray-700">1</span>
                <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
            </div>
            <div class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50">
                <span class="text-sm font-bold text-gray-700">2</span>
                <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
            </div>
            <div class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50">
                <span class="text-sm font-bold text-gray-700">3</span>
                <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
            </div>
            
            <!-- Tanggal 4-10 -->
            @for ($i = 4; $i <= 10; $i++)
                @if ($i >= 8 && $i <= 10)
                    <div class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
                    </div>
                @else
                    <div class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
                    </div>
                @endif
            @endfor
            
            <!-- Tanggal 11-17 -->
            @for ($i = 11; $i <= 17; $i++)
                @if ($i == 14)
                    <div class="h-24 border-2 border-orange-500 rounded-lg p-2 flex flex-col justify-between bg-orange-50 relative">
                        <div class="flex justify-between"><span class="text-sm font-bold text-gray-700">14</span><span class="text-[10px] font-bold text-orange-600">Hari Ini</span></div>
                        <span class="text-[10px] text-center bg-orange-200 text-orange-800 rounded py-1 font-semibold">Menunggu</span>
                    </div>
                @elseif ($i >= 15 && $i <= 16)
                    <div class="h-24 border border-orange-200 rounded-lg p-2 flex flex-col justify-between bg-orange-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-orange-200 text-orange-800 rounded py-1 font-semibold">Menunggu</span>
                    </div>
                @elseif ($i == 17)
                    <div class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
                    </div>
                @else
                    <div class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
                    </div>
                @endif
            @endfor

            <!-- Tanggal 18-24 -->
            @for ($i = 18; $i <= 24; $i++)
                @if ($i >= 22)
                    <div class="h-24 border border-red-200 rounded-lg p-2 flex flex-col justify-between bg-red-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-red-200 text-red-800 rounded py-1 font-semibold">Dipesan</span>
                    </div>
                @else
                    <div class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
                    </div>
                @endif
            @endfor

            <!-- Tanggal 25-31 -->
            @for ($i = 25; $i <= 31; $i++)
                @if ($i == 29)
                    <div class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
                    </div>
                @else
                    <div class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50">
                        <span class="text-sm font-bold text-gray-700">{{ $i }}</span>
                        <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
                    </div>
                @endif
            @endfor
        </div>

        <!-- Legend -->
        <div class="flex items-center gap-6 mt-6 text-xs text-gray-600">
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Tersedia</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Dipesan</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Libur (Off-Duty)</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Menunggu Konfirmasi</div>
            <div class="ml-auto flex items-center gap-2"><span class="w-3 h-3 border-2 border-orange-500 rounded bg-orange-50"></span> Kotak oranye: Tanggal hari ini</div>
        </div>
    </div>

    <!-- Detail Tanggal Terpilih -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
            <div class="flex items-center gap-3">
                <span class="text-2xl bg-orange-50 p-2 rounded-lg">📅</span>
                <div>
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">Detail Tanggal Terpilih: 14 Mei 2026 <span class="text-[10px] font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">• Menunggu Konfirmasi</span></h3>
                    <p class="text-xs text-gray-500">Permintaan reservasi masuk dari pendaki, membutuhkan respons pemandu dalam 24 jam.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">Tandai Libur</button>
                <button class="px-4 py-2 border border-gray-800 bg-white text-gray-800 rounded-lg text-sm font-bold hover:bg-gray-50 flex items-center gap-2">👁️ Lihat Pesanan</button>
            </div>
        </div>
        
        <div class="grid grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg text-sm">
            <div>
                <p class="text-gray-500 text-xs mb-1">Kode Reservasi</p>
                <p class="font-bold text-gray-800">RJN - 2026 - 0001</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs mb-1">Nama Pemesan</p>
                <p class="font-bold text-gray-800">Andi Pratama</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs mb-1">Jalur Pendakian</p>
                <p class="font-bold text-green-700 flex items-center gap-1">⛰️ Sembalun (3.726 mdpl)</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs mb-1">Kapasitas Rombongan</p>
                <p class="font-bold text-gray-800">4 orang (Trek 3 Hari)</p>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h4 class="text-xs font-bold text-gray-500 mb-4 tracking-widest uppercase">Aksi Cepat</h4>
        <div class="flex gap-4 text-sm font-semibold">
            <button class="px-4 py-2 border-2 border-gray-800 rounded-lg text-gray-800 hover:bg-gray-100 flex items-center gap-2">✔️ Tandai Semua Tersedia Bulan Ini</button>
            <button class="px-4 py-2 text-gray-600 hover:text-gray-900">Tandai Semua Libur</button>
        </div>
    </div>
@endsection