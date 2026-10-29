@extends('layouts.app')

@section('content')
    <!-- Header Dashboard -->
    <div class="bg-brand-dark py-12 text-white text-center">
        <h1 class="text-3xl font-serif font-bold mb-2">Beranda Pendaki</h1>
        <p class="text-gray-300">Selamat datang kembali, <span class="font-semibold text-brand-orange">{{ Auth::user()->name ?? 'Pendaki' }}</span>!</p>
    </div>

    <!-- Konten Utama -->
    <div class="py-12 bg-brand-light min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card 1: Pesanan Aktif -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-orange-100 text-brand-orange rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-person-hiking text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-dark">Pesanan Aktif</h3>
                            <p class="text-sm text-gray-500">0 Pesanan Berjalan</p>
                        </div>
                    </div>
                    <a href="{{ route('guide') }}" class="text-sm font-semibold text-brand-orange hover:underline flex items-center">
                        Cari Pemandu Baru <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <!-- Card 2: E-Voucher -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-ticket text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-dark">E-Voucher Saya</h3>
                            <p class="text-sm text-gray-500">1 Voucher Tersedia</p>
                        </div>
                    </div>
                    <a href="#" class="text-sm font-semibold text-brand-orange hover:underline flex items-center">
                        Lihat Semua Voucher <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <!-- Card 3: Sewa Alat -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-tent text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-dark">Sewa Alat</h3>
                            <p class="text-sm text-gray-500">Butuh perlengkapan?</p>
                        </div>
                    </div>
                    <a href="{{ route('rental') }}" class="text-sm font-semibold text-brand-orange hover:underline flex items-center">
                        Sewa Alat Outdoor <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Section Bantuan -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 text-center">
                <h3 class="text-xl font-bold text-brand-dark mb-2">Butuh Bantuan Ekspedisi?</h3>
                <p class="text-gray-500 mb-6 max-w-lg mx-auto">Jika Anda memiliki kendala dengan pesanan atau ingin berkonsultasi seputar jalur pendakian, tim kami siap membantu.</p>
                <a href="{{ route('faq') }}" class="inline-block border border-brand-dark text-brand-dark px-6 py-2.5 rounded-lg font-semibold hover:bg-brand-dark hover:text-white transition">
                    Buka Pusat Bantuan
                </a>
            </div>

        </div>
    </div>
@endsection