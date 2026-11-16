@extends('admin::layouts.admin')

@section('title', 'Profil Admin')
@section('header_title', 'Profil Admin')
@section('header_desc', 'Kelola informasi profil, keamanan, dan hak akses administrator.')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        <!-- KARTU PROFIL UTAMA -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden relative">
            <div class="h-32 bg-[#143529] w-full relative">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;">
                </div>
            </div>
            <div class="px-8 pb-8 flex flex-col items-center relative -mt-16">
                <div
                    class="w-28 h-28 bg-[#1a402f] rounded-full border-4 border-white shadow-md flex items-center justify-center text-white font-bold text-4xl relative">
                    {{ substr(Auth::user()->nama, 0, 2) }}
                    <div
                        class="absolute bottom-1 right-1 w-6 h-6 bg-orange-500 border-2 border-white rounded-full flex items-center justify-center">
                        ✏️</div>
                </div>
                <h3 class="mt-4 text-2xl font-bold text-gray-900">{{ Auth::user()->nama }}</h3>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }} &nbsp;•&nbsp;
                    {{ Auth::user()->no_telepon ?? '-' }}</p>
                <span
                    class="mt-3 inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold">
                    ✓ Akun Terverifikasi
                </span>
                <div class="mt-6 flex gap-3">
                    <button
                        class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Ganti
                        Foto</button>
                    <button
                        class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Hapus
                        Foto</button>
                </div>
                <p class="text-[10px] text-gray-400 mt-2">JPG, PNG maksimal 2MB</p>
            </div>
        </div>

        <!-- KARTU DATA PRIBADI -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Data Pribadi</h3>
            <p class="text-sm text-gray-500 mb-6">Perbarui informasi dasar dan detail akun Anda.</p>
            <form class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->nama }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed"
                        disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" value="{{ Auth::user()->email }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed"
                        disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                    <input type="text" value="{{ Auth::user()->no_telepon }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                </div>
            </form>
        </div>

        <!-- KARTU HAK AKSES -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Hak Akses</h3>
            <p class="text-sm text-gray-500 mb-6">Fitur dan modul yang tersedia untuk peran Anda.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div
                    class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                    <span class="text-sm font-semibold">✅ Verifikasi Mitra</span></div>
                <div
                    class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                    <span class="text-sm font-semibold">✅ Atur Komisi</span></div>
                <div
                    class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                    <span class="text-sm font-semibold">✅ Rekap Transaksi</span></div>
                <div
                    class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                    <span class="text-sm font-semibold">✅ Moderasi Katalog</span></div>
            </div>
        </div>
    </div>

    <!-- FLOATING ACTION BAR -->
    <div
        class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 px-8 flex items-center justify-between shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20">
        <div class="text-sm text-gray-500 flex items-center gap-2">ℹ️ Ada perubahan yang belum disimpan.</div>
        <div class="flex gap-3">
            <button type="button"
                class="border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Batalkan</button>
            <button type="button"
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                Perubahan</button>
        </div>
    </div>
@endsection
