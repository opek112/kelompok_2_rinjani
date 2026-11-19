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
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Preferensi Tampilan</h3>
            <p class="text-sm text-gray-500 mb-6">Preferensi yang sedang digunakan aplikasi.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa</label>
                    <p class="text-sm text-gray-900">{{ $bahasa }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zona Waktu</label>
                    <p class="text-sm text-gray-900">{{ $zonaWaktu }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Pengaturan Platform</h3>
            <p class="text-sm text-gray-500 mb-6">Nilai database ditampilkan jika tersedia, selain itu menggunakan konfigurasi aplikasi.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Platform</label>
                    <p class="text-sm text-gray-900">{{ $namaPlatform }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Formal</label>
                    <p class="text-sm text-gray-900">{{ $emailFormal ?: 'Belum dikonfigurasi' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Formal</label>
                    <p class="text-sm text-gray-900">{{ $nomorWhatsapp ?: 'Belum dikonfigurasi' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center shrink-0">⚙️
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mode Pemeliharaan</h3>
                        <p class="text-sm text-gray-500">Status aktual aplikasi; pengaturan tidak diubah dari halaman ini.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-sm font-semibold {{ $modePemeliharaan ? 'text-orange-700' : 'text-green-700' }}">
                        {{ $modePemeliharaan ? 'Aktif' : 'Tidak aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
