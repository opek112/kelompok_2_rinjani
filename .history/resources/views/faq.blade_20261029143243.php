@extends('layouts.app')

@section('content')
    <!-- Header FAQ -->
    <section class="bg-brand-dark py-20 text-center text-white relative">
        <div class="relative z-10">
            <span class="bg-white/10 px-4 py-1.5 rounded-full text-xs tracking-wider mb-4 inline-block"><i class="fa-regular fa-circle-question mr-2"></i> LAYANAN RESMI PENDAKI</span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">Pusat Bantuan</h1>
            <p class="text-gray-300">Temukan jawaban atau hubungi tim kami.</p>
        </div>
    </section>

    <!-- Tab Navigasi -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-3xl mx-auto flex justify-center space-x-8">
            <a href="#" class="py-4 border-b-2 border-brand-orange text-brand-orange font-semibold flex items-center gap-2"><i class="fa-solid fa-file-lines"></i> FAQ</a>
            <a href="#" class="py-4 border-b-2 border-transparent text-gray-500 hover:text-brand-dark font-semibold flex items-center gap-2"><i class="fa-solid fa-headset"></i> Kontak</a>
        </div>
    </div>

    <!-- Konten FAQ -->
    <section class="py-12 px-4 bg-brand-light" x-data="{ activeFaq: '1-1' }">
        <div class="max-w-3xl mx-auto">
            <!-- Search Bar -->
            <div class="relative mb-8">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
                <input type="text" placeholder="Cari pertanyaan..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-brand-orange focus:border-brand-orange outline-none shadow-sm">
            </div>

            <!-- Kategori Pill -->
            <div class="flex flex-wrap gap-2 mb-8">
                <button class="bg-brand-orange text-white px-4 py-1.5 rounded-full text-sm font-medium">Semua</button>
                <button class="bg-white text-gray-600 border border-gray-200 hover:border-brand-orange px-4 py-1.5 rounded-full text-sm font-medium transition">Pemesanan</button>
                <button class="bg-white text-gray-600 border border-gray-200 hover:border-brand-orange px-4 py-1.5 rounded-full text-sm font-medium transition">Pembayaran</button>
                <button class="bg-white text-gray-600 border border-gray-200 hover:border-brand-orange px-4 py-1.5 rounded-full text-sm font-medium transition">Pemandu</button>
            </div>

            <!-- List FAQ -->
            <div class="space-y-3">
                <!-- Kategori 1: Pemesanan -->
                <h3 class="font-bold text-brand-dark mb-3 mt-6 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-brand-orange"></span> Pemesanan</h3>
                
                <!-- FAQ Item -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <button @click="activeFaq = (activeFaq === '1-1' ? null : '1-1')" class="w-full px-5 py-4 text-left font-semibold text-brand-dark flex justify-between items-center focus:outline-none">
                        Bagaimana cara memesan pemandu?
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="activeFaq === '1-1' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === '1-1'" x-collapse class="px-5 pb-4 text-gray-600 text-sm border-t pt-4" style="display: none;">
                        Pilih pemandu di halaman Guide, tentukan tanggal, lalu tambahkan ke keranjang. Isi data pemesan, lalu bayar via QRIS.
                    </div>
                </div>
                
                <!-- FAQ Item -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <button @click="activeFaq = (activeFaq === '1-2' ? null : '1-2')" class="w-full px-5 py-4 text-left font-semibold text-brand-dark flex justify-between items-center focus:outline-none">
                        Apakah bisa pesan pemandu saja tanpa alat?
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="activeFaq === '1-2' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeFaq === '1-2'" x-collapse class="px-5 pb-4 text-gray-600 text-sm border-t pt-4" style="display: none;">
                        Tentu saja. Anda bisa memilih hanya pemandu saja pada saat proses pemesanan tanpa harus menyewa alat.
                    </div>
                </div>
                
                <!-- Ulangi format di atas untuk kategori Pembayaran, Pemandu, Rental, dll -->
            </div>

            <!-- CTA Bantuan -->
            <div class="bg-brand-light border border-gray-200 rounded-2xl p-8 text-center mt-12">
                <div class="w-12 h-12 bg-brand-dark text-white rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-headset text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-brand-dark mb-2">Belum Terjawab?</h3>
                <p class="text-gray-500 text-sm mb-6">Tim kami siap membantu Anda dengan layanan konsultasi jalur, logistik, dan persiapan ekspedisi.</p>
                <a href="#" class="inline-block bg-brand-orange text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition">
                    <i class="fa-brands fa-whatsapp mr-2"></i> Hubungi Admin via WhatsApp
                </a>
            </div>
        </div>
    </section>
@endsection