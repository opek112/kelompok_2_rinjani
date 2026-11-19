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
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Email</h3>
            <p class="text-sm text-gray-500 mb-4">Mail driver aktual dari konfigurasi aplikasi.</p>
            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                <span class="text-sm font-semibold text-gray-700">Mail driver</span>
                <span class="text-sm text-gray-900">{{ $mailDriver ?: 'Tidak dikonfigurasi' }}</span>
            </div>
            <p class="text-xs text-gray-500 mt-4">Preferensi email per aktivitas belum disimpan di database.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Notifikasi Push</h3>
            <p class="text-sm text-gray-500">Pengiriman push notification belum dikonfigurasi.</p>
        </div>
    </div>
@endsection
