@extends('admin::layouts.admin')

@section('title', 'Keamanan Akun')
@section('header_title', 'Pengaturan')
@section('header_desc', 'Kelola preferensi sistem, parameter operasional, dan keamanan platform.')

@section('content')
    <!-- SUB-NAVIGASI TAB -->
    <div class="bg-white border-b border-gray-200 -mx-8 -mt-8 px-8 flex gap-6 shrink-0 mb-6 shadow-sm">
        <a href="{{ route('admin.pengaturan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">⚙️
            Preferensi Sistem</a>
        <a href="#"
            class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">🛡️
            Keamanan Akun</a>
        <a href="{{ route('admin.integrasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔗
            Integrasi</a>
        <a href="{{ route('admin.pengaturan.notifikasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔔
            Notifikasi</a>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- KARTU 1: UBAH KATA SANDI -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Ubah Kata Sandi</h3>
            <p class="text-sm text-gray-500 mb-6">Perbarui kata sandi Anda secara berkala.</p>
            <form class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" placeholder="••••••••"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                </div>
                <div class="flex justify-end pt-2">
                    <button type="button"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Ubah
                        Kata Sandi</button>
                </div>
            </form>
        </div>

        <!-- KARTU 2: SESI AKTIF -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Sesi Aktif</h3>
            <p class="text-sm text-gray-500 mb-6">Perangkat yang saat ini login ke akun Anda.</p>
            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">💻
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-gray-900 text-sm">Chrome di Windows</p>
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Sesi
                                Ini</span>
                        </div>
                        <p class="text-xs text-gray-500">Mataram, Indonesia • IP 192.168.1.10</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
