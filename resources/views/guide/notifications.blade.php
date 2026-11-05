@extends('layouts.guide')

@section('title', 'Notifikasi')
@section('header', 'Notifikasi')
@section('subheader', 'Pantau pesanan, jadwal, pembayaran, dan aktivitas akun kemitraan Anda.')

@section('content')
    <!-- Bar Atas -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6 flex justify-between items-center">
        <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
            <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> 2 notifikasi belum dibaca
        </div>
        <button class="text-orange-500 font-bold text-sm hover:underline flex items-center gap-1">
            ✔️ Tandai Semua Dibaca
        </button>
    </div>

    <!-- Tabs -->
    <div class="flex gap-6 border-b border-gray-200 mb-6 text-sm font-bold">
        <button class="pb-3 border-b-2 border-orange-500 text-orange-500 flex items-center gap-2">
            Semua <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">5</span>
        </button>
        <button class="pb-3 text-gray-500 hover:text-gray-800 flex items-center gap-2">
            Belum Dibaca <span class="bg-orange-500 text-white px-2 py-0.5 rounded text-xs">2</span>
        </button>
        <button class="pb-3 text-gray-500 hover:text-gray-800">
            Sudah Dibaca
        </button>
    </div>

    <!-- Daftar Notifikasi -->
    <div class="space-y-3">
        
        <!-- Notif 1 (Belum Dibaca) -->
        <div class="bg-green-50/50 border border-green-200 rounded-xl p-5 flex gap-4 relative">
            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center flex-shrink-0 text-lg">📅</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded">Pesanan</span>
                    <h4 class="font-bold text-gray-800">Pesanan Baru Masuk</h4>
                </div>
                <p class="text-sm text-gray-700 mb-2"><strong>Andi Pratama</strong> memesan Anda untuk pendakian 14-16 Mei 2026 via jalur Sembalun.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">🕒 5 menit lalu</span>
                    <a href="{{ route('guide.schedule') }}" class="text-orange-500 font-semibold hover:underline">Buka Jadwal Penugasan →</a>
                </div>
            </div>
            <span class="absolute top-5 right-5 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
        </div>

        <!-- Notif 2 (Belum Dibaca) -->
        <div class="bg-green-50/50 border border-green-200 rounded-xl p-5 flex gap-4 relative">
            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center flex-shrink-0 text-lg">⏱️</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded">Pengingat</span>
                    <h4 class="font-bold text-gray-800">Pengingat Pendakian Besok</h4>
                </div>
                <p class="text-sm text-gray-700 mb-2">Anda akan mendampingi <strong>Sarah Wijaya</strong> besok, 22 Mei 2026. Meeting point: Basecamp Senaru.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">🕒 1 jam lalu</span>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Detail Pesanan →</a>
                </div>
            </div>
            <span class="absolute top-5 right-5 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
        </div>

        <!-- Notif 3 (Sudah Dibaca) -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0 text-lg">💵</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded">Keuangan</span>
                    <h4 class="font-bold text-gray-800">Pencairan Berhasil</h4>
                </div>
                <p class="text-sm text-gray-700 mb-2"><strong>Rp 1.080.000</strong> telah ditransfer ke rekening BCA Anda.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">🕒 Kemarin</span>
                    <a href="{{ route('guide.earnings') }}" class="text-orange-500 font-semibold hover:underline">Lihat Rekap Pendapatan →</a>
                </div>
            </div>
        </div>

        <!-- Notif 4 (Sudah Dibaca) -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0 text-lg">⭐</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded">Ulasan</span>
                    <h4 class="font-bold text-gray-800">Ulasan Baru</h4>
                </div>
                <p class="text-sm text-gray-700 mb-2"><strong>Andi Pratama</strong> memberi Anda rating <strong>⭐ 5.0</strong> "Pemandu sangat ramah dan sabar."</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">🕒 2 hari lalu</span>
                    <a href="{{ route('guide.profile') }}" class="text-orange-500 font-semibold hover:underline">Buka Halaman Profil →</a>
                </div>
            </div>
        </div>

        <!-- Notif 5 (Sudah Dibaca) -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 text-lg">✔️</div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded">Verifikasi</span>
                    <h4 class="font-bold text-gray-800">Akun Terverifikasi</h4>
                </div>
                <p class="text-sm text-gray-700 mb-2">Akun Pemandu Anda telah diverifikasi admin. Profil Anda sudah tampil di katalog publik RinjaniGuide.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">🕒 3 bulan lalu</span>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat di Katalog Publik →</a>
                </div>
            </div>
        </div>

    </div>
@endsection