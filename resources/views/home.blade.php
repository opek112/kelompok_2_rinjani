@extends('layouts.app')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[600px] flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=2071&auto=format&fit=crop'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-10">
            <span class="inline-block bg-white/20 text-white px-4 py-1.5 rounded-full text-sm font-medium mb-6 backdrop-blur-sm">
                <i class="fa-solid fa-mountain mr-2"></i>Taman Nasional Gunung Rinjani
            </span>
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6 leading-tight">
                Jelajahi Puncak Rinjani dengan <br> Aman & Nyaman
            </h1>
            <p class="text-lg text-gray-200 mb-8 max-w-2xl mx-auto">
                Pesan pemandu lokal & sewa alat outdoor di pos Sembalun, Senaru, dan Torean.
            </p>
        </div>

        <!-- Floating Booking Form -->
        <div class="absolute -bottom-24 left-1/2 transform -translate-x-1/2 w-[90%] max-w-5xl bg-white rounded-2xl shadow-xl p-6 z-20">
            <form action="{{ route('guide') }}" method="GET"> <!-- Diarahkan ke halaman guide/pencarian -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pos Keberangkatan</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-3 top-3 text-gray-400"></i>
                            <select class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none appearance-none bg-white">
                                <option>Sembalun (Padang Savana & Puncak)</option>
                                <option>Senaru (Hutan Tropis & Danau)</option>
                                <option>Torean (Danau & Savana)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                        <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Selesai</label>
                        <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6">
                    <div class="flex items-center gap-6 text-sm text-gray-700">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-brand-green rounded focus:ring-brand-green">
                            Cari Pemandu
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-brand-green rounded focus:ring-brand-green">
                            Sewa Alat
                        </label>
                    </div>
                    <button type="submit" class="bg-brand-orange text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition w-full md:w-auto flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Sekarang
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- JALUR PENDAKIAN -->
    <section class="pt-40 pb-20 px-4 max-w-7xl mx-auto">
        <!-- ... (Kode kartu jalur pendakian tetap sama seperti sebelumnya) ... -->
        <div class="mt-12 text-center">
            <a href="{{ route('jalur-pendakian') }}" class="inline-block border border-gray-300 text-brand-dark px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                Lihat Semua Jalur <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- PEMANDU TERVERIFIKASI -->
    <section class="bg-white py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-brand-dark mb-2">Pemandu Terverifikasi</h2>
                    <p class="text-gray-500">Pemandu berlisensi resmi APGDI Inggris Rinjani.</p>
                </div>
                <a href="{{ route('guide') }}" class="text-brand-orange font-semibold hover:underline hidden md:block">Lihat Semua Pemandu <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>

            <!-- ... (Kode kartu pemandu tetap sama) ... -->
            <div class="mt-8 md:hidden text-center">
                <a href="{{ route('guide') }}" class="text-brand-orange font-semibold hover:underline">Lihat Semua Pemandu <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </section>

    <!-- ALAT OUTDOOR POPULER -->
    <section class="py-20 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-serif font-bold text-brand-dark mb-2">Alat Outdoor Populer</h2>
                <p class="text-gray-500">Alat berkualitas dari toko rental terpercaya.</p>
            </div>
            <a href="{{ route('rental') }}" class="text-brand-orange font-semibold hover:underline hidden md:block">Lihat Semua Alat <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>
        
        <!-- ... (Kode kartu alat tetap sama, pastikan tombol "Sewa Alat" dibungkus tag <a> mengarah ke route('rental')) ... -->
    </section>

    <!-- FAQ (Menggunakan Alpine.js untuk Accordion yang mulus) -->
    <section class="py-20 px-4 max-w-3xl mx-auto" x-data="{ activeFaq: null }">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-brand-dark mb-4">Pertanyaan Umum</h2>
            <p class="text-gray-500">Jawaban cepat untuk pertanyaan yang sering diajukan seputar pemesanan & layanan.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full px-6 py-4 text-left font-semibold text-brand-dark flex justify-between items-center focus:outline-none">
                    Berapa komisi platform?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="activeFaq === 1 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeFaq === 1" x-collapse class="px-6 pb-4 text-gray-600 text-sm border-t pt-4" style="display: none;">
                    Komisi 10% per transaksi berhasil. Tidak ada biaya pendaftaran.
                </div>
            </div>
            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full px-6 py-4 text-left font-semibold text-brand-dark flex justify-between items-center focus:outline-none">
                    Bagaimana cara membayar?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="activeFaq === 2 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="activeFaq === 2" x-collapse class="px-6 pb-4 text-gray-600 text-sm border-t pt-4" style="display: none;">
                    Pembayaran melalui transfer bank, e-wallet, atau QRIS.
                </div>
            </div>
            <!-- Tambahkan FAQ lainnya... -->
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('faq') }}" class="inline-block border border-gray-300 text-brand-dark px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition">Lihat Semua FAQ</a>
        </div>
    </section>

    <!-- CTA BAWAH -->
    <section class="px-4 pb-20">
        <div class="max-w-5xl mx-auto bg-brand-dark rounded-3xl p-12 text-center relative overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-white mb-4 relative z-10">Siap Mendaki Rinjani?</h2>
            <p class="text-gray-300 mb-8 relative z-10 max-w-xl mx-auto">Pesan pemandu lokal bersertifikat dan sewa alat selengkapnya untuk memastikan kelancaran dan keselamatan ekspedisimu.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                <a href="{{ route('guide') }}" class="bg-brand-orange text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">Cari Pemandu</a>
                <a href="{{ route('rental') }}" class="bg-white text-brand-dark px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Sewa Alat</a>
            </div>
        </div>
    </section>
@endsection