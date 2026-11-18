@extends('layouts.app')

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-12">
        <a href="{{ route('guide') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-brand-orange mb-6">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Pemandu
        </a>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="w-24 h-24 bg-brand-dark text-white rounded-full flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    {{ $pemandu->inisial() }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-serif font-bold text-brand-dark flex items-center gap-2">
                        {{ $pemandu->user->nama ?? 'Pemandu' }}
                        <i class="fa-solid fa-circle-check text-blue-500 text-lg"></i>
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $pemandu->nomor_lisensi ? 'Lisensi Kepemanduan '.$pemandu->nomor_lisensi : 'Pemandu lokal terverifikasi' }}
                    </p>
                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $tersediaHariIni ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $tersediaHariIni ? 'Tersedia hari ini' : 'Tidak tersedia hari ini' }}
                        </span>
                        @foreach ($pemandu->ruteList() as $rute)
                            <span class="bg-green-50 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $rute }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xs text-gray-500">Tarif harian</p>
                    <p class="text-3xl font-bold text-brand-orange">{{ \Modules\Guide\Support\Formatter::rupiah($pemandu->tarif_harian) }}</p>
                    <p class="text-xs text-gray-500">per hari pendampingan</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-lg font-bold text-brand-dark mb-3">Tentang Pemandu</h2>
                <p class="text-sm text-gray-600 leading-relaxed mb-6">
                    {{ $pemandu->bio ?: 'Pemandu lokal berpengalaman di kawasan Taman Nasional Gunung Rinjani.' }}
                </p>

                <h2 class="text-lg font-bold text-brand-dark mb-3">Keahlian Jalur</h2>
                <div class="flex flex-wrap gap-2 mb-6">
                    @forelse ($pemandu->ruteList() as $rute)
                        <span class="bg-brand-dark text-white text-xs font-semibold px-3 py-1.5 rounded-full">{{ $rute }}</span>
                    @empty
                        <span class="text-sm text-gray-500">Belum ada data jalur.</span>
                    @endforelse
                </div>

                <h2 class="text-lg font-bold text-brand-dark mb-3">Bahasa yang Dikuasai</h2>
                <div class="flex flex-wrap gap-2">
                    @forelse ($pemandu->bahasaList() as $bahasa)
                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-full">{{ $bahasa }}</span>
                    @empty
                        <span class="text-sm text-gray-500">Belum ada data bahasa.</span>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-lg font-bold text-brand-dark mb-4">Ajukan Pemesanan</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Hubungi pemandu untuk menanyakan ketersediaan tanggal pendakian Anda, atau masuk untuk melanjutkan pemesanan.
                </p>

                @php
                    $telepon = preg_replace('/[^0-9]/', '', (string) ($pemandu->user->no_telepon ?? ''));
                    if (str_starts_with($telepon, '0')) {
                        $telepon = '62'.substr($telepon, 1);
                    }
                @endphp

                @if ($telepon !== '')
                    <a href="https://wa.me/{{ $telepon }}" target="_blank" rel="noopener"
                        class="block text-center w-full bg-green-600 text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-green-700 transition mb-3">
                        <i class="fa-brands fa-whatsapp mr-2"></i> Hubungi via WhatsApp
                    </a>
                @endif

                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                    class="block text-center w-full border border-brand-dark text-brand-dark px-5 py-3 rounded-lg text-sm font-bold hover:bg-brand-dark hover:text-white transition">
                    {{ auth()->check() ? 'Buka Dashboard' : 'Masuk untuk Memesan' }}
                </a>

                <div class="border-t border-gray-100 mt-6 pt-4 text-sm text-gray-600 space-y-2">
                    <p><i class="fa-solid fa-shield-halved text-brand-orange mr-2"></i>Diverifikasi admin RinjaniGuide</p>
                    <p><i class="fa-solid fa-route text-brand-orange mr-2"></i>{{ count($pemandu->ruteList()) }} jalur dikuasai</p>
                    <p><i class="fa-solid fa-language text-brand-orange mr-2"></i>{{ count($pemandu->bahasaList()) }} bahasa</p>
                </div>
            </div>
        </div>
    </section>
@endsection
