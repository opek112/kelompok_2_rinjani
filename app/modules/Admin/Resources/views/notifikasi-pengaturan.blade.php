@extends('admin::layouts.admin')

@section('title', 'Preferensi Notifikasi')
@section('header_title', 'Pengaturan')
@section('header_desc', 'Kelola konfigurasi sistem, parameter operasional, dan preferensi platform.')

@section('content')
    <!-- SUB-NAVIGASI TAB -->
    <div class="bg-white border-b border-gray-200 -mx-8 -mt-8 px-8 flex gap-6 shrink-0 mb-6 shadow-sm">
        <a href="{{ route('admin.pengaturan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">⚙️
            Preferensi Sistem</a>
        <a href="{{ route('admin.keamanan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🛡️
            Keamanan Akun</a>
        <a href="{{ route('admin.integrasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔗
            Integrasi</a>
        <a href="#"
            class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">🔔
            Notifikasi</a>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- 1. NOTIFIKASI EMAIL -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Email</h3>
            <p class="text-sm text-gray-500 mb-6">Terima email untuk aktivitas platform.</p>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Pendaftaran Mitra Baru</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Kirim email saat ada pendaftaran baru.</p>
                    </div>
                    <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                        <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Transaksi Baru</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Kirim email saat ada transaksi berhasil.</p>
                    </div>
                    <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                        <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8"><button
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                    Preferensi Email</button></div>
        </div>

        <!-- 2. NOTIFIKASI PUSH -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Push</h3>
            <p class="text-sm text-gray-500 mb-6">Notifikasi di browser dan aplikasi.</p>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Aktivitas Penting</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Notifikasi untuk aksi penting.</p>
                    </div>
                    <div class="w-11 h-6 bg-[#10b981] rounded-full relative cursor-pointer shrink-0">
                        <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8"><button
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                    Preferensi Push</button></div>
        </div>
    </div>
@endsection
