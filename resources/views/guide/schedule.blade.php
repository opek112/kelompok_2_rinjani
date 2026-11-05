@extends('layouts.guide')

@section('title', 'Jadwal Penugasan')
@section('header', 'Jadwal Penugasan')
@section('subheader', 'Kelola penugasan ekspedisi aktif dan riwayat pemanduan pendaki')

@section('content')
    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-gray-200 p-2 mb-6 flex gap-4">
        <button class="px-6 py-3 border-b-2 border-orange-500 text-orange-500 font-bold flex items-center gap-2">
            Akan Datang <span class="bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full">2</span>
        </button>
        <button class="px-6 py-3 text-gray-500 font-semibold hover:text-gray-800">Sedang Berjalan</button>
        <button class="px-6 py-3 text-gray-500 font-semibold hover:text-gray-800">Selesai</button>
    </div>

    <!-- List Pesanan 1 -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-4">
        <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
            <div class="flex gap-4 text-xs text-gray-500 font-medium">
                <span># RJN - 2026 - 0001</span>
                <span>•</span>
                <span>Dipesan: 10 Mei 2026</span>
            </div>
            <span class="bg-orange-50 text-orange-600 border border-orange-200 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">⏱️ Menunggu Pertemuan</span>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#1e4035] text-white rounded-full flex items-center justify-center font-bold text-lg">AP</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-bold text-lg text-gray-800">Andi Pratama</h3>
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded">Ketua Tim</span>
                    </div>
                    <p class="text-xs text-gray-500 flex items-center gap-3">
                        <span class="flex items-center gap-1">📞 0812-3456-7890</span>
                        <span>•</span>
                        <span class="flex items-center gap-1">👥 Rombongan: 4 orang</span>
                    </p>
                </div>
            </div>
            
            <div class="flex flex-col gap-2 w-56">
                <button class="w-full border border-green-600 text-green-700 bg-white py-2 rounded-lg text-sm font-bold hover:bg-green-50 flex items-center justify-center gap-2">📞 Hubungi via WhatsApp</button>
                <button class="w-full bg-orange-500 text-white py-2 rounded-lg text-sm font-bold hover:bg-orange-600 flex items-center justify-center gap-2">✔️ Konfirmasi Serah Terima</button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Tanggal Pendakian:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-2">📅 14-16 Mei 2026</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Jalur Pendakian:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-1">⛰️ Sembalun (3.726 mdpl)</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Total Durasi:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-2">⏱️ 3 hari 2 malam</p>
            </div>
        </div>
    </div>

    <!-- List Pesanan 2 -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
            <div class="flex gap-4 text-xs text-gray-500 font-medium">
                <span># RJN - 2026 - 0002</span>
                <span>•</span>
                <span>Dipesan: 12 Mei 2026</span>
            </div>
            <span class="bg-blue-50 text-blue-600 border border-blue-200 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">🔵 Akan Datang</span>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-lg">SW</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-bold text-lg text-gray-800">Sarah Wijaya</h3>
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded">Pendaki Terverifikasi</span>
                    </div>
                    <p class="text-xs text-gray-500 flex items-center gap-3">
                        <span class="flex items-center gap-1">📞 0813-9876-5432</span>
                        <span>•</span>
                        <span class="flex items-center gap-1">👥 Rombongan: 2 orang</span>
                    </p>
                </div>
            </div>
            
            <div class="flex flex-col gap-2 w-56">
                <button class="w-full border border-green-600 text-green-700 bg-white py-2 rounded-lg text-sm font-bold hover:bg-green-50 flex items-center justify-center gap-2">📞 Hubungi via WhatsApp</button>
                <button class="w-full bg-gray-200 text-gray-400 py-2 rounded-lg text-sm font-bold flex items-center justify-center gap-2 cursor-not-allowed" disabled>🔒 Konfirmasi Serah Terima</button>
                <p class="text-[10px] text-center text-gray-400 italic">Tersedia pada hari H (22 Mei)</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Tanggal Pendakian:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-2">📅 22-24 Mei 2026</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Jalur Pendakian:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-1">⛰️ Senaru (Lombok Utara)</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                <p class="text-[10px] text-gray-500 mb-1">Total Durasi:</p>
                <p class="text-sm font-bold text-gray-800 flex items-center gap-2">⏱️ 3 hari 2 malam</p>
            </div>
        </div>
    </div>

    <!-- Legend Status -->
    <div class="flex gap-6 text-xs text-gray-600 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <span class="font-bold text-gray-800">Panduan Status Penugasan:</span>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Kuning = Menunggu Pertemuan</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Biru = Akan Datang</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Hijau = Sedang Berjalan</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Abu = Selesai</div>
    </div>
@endsection