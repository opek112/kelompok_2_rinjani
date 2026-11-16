@extends('admin::layouts.admin')

@section('title', 'Pengaturan')
@section('header_title', 'Pengaturan')
@section('header_desc', 'Kelola preferensi sistem, parameter operasional, dan keamanan platform.')

@section('content')
    <!-- SUB-NAVIGASI TAB -->
    <div class="bg-white border-b border-gray-200 -mx-8 -mt-8 px-8 flex gap-6 shrink-0 mb-6 shadow-sm">
        <a href="#"
            class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">⚙️
            Preferensi Sistem</a>
        <a href="{{ route('admin.keamanan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🛡️
            Keamanan Akun</a>
        <a href="{{ route('admin.integrasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔗
            Integrasi</a>
        <a href="{{ route('admin.pengaturan.notifikasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔔
            Notifikasi</a>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- KARTU 1: PREFERENSI TAMPILAN -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Preferensi Tampilan</h3>
            <p class="text-sm text-gray-500 mb-6">Sesuaikan format tanggal dan mata uang regional sistem.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa</label>
                    <select
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                        <option>Indonesia</option>
                        <option>English</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zona Waktu</label>
                    <select
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                        <option>WIB (UTC+7)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                    Preferensi</button>
            </div>
        </div>

        <!-- KARTU 2: PENGATURAN PLATFORM -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Pengaturan Platform</h3>
            <p class="text-sm text-gray-500 mb-6">Informasi dasar dan parameter operasional platform.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Platform</label>
                    <input type="text" value="RinjaniGuide & Rental"
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Formal</label>
                    <input type="email" value="halo@rinjaniguide.id"
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Formal</label>
                    <input type="text" value="0819-8765-4321"
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-white">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                    Pengaturan Platform</button>
            </div>
        </div>

        <!-- KARTU 3: MODE PEMELIHARAAN -->
        <div class="bg-red-50 rounded-2xl border border-red-200 shadow-sm p-8 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">⚠️
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-800">Mode Pemeliharaan</h3>
                        <p class="text-sm text-red-700">Aktifkan mode pemeliharaan untuk menutup sementara akses ke platform
                            bagi publik.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-sm font-semibold text-red-800">Aktifkan</span>
                    <div class="w-12 h-6 bg-red-200 rounded-full relative cursor-pointer">
                        <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
