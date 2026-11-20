@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-brand-dark via-brand-green to-[#20402f] text-white py-14 px-4">
        <div class="max-w-7xl mx-auto">
            <span class="inline-block bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
                <i class="fa-solid fa-person-hiking mr-2 text-brand-orange"></i>Pemandu Berlisensi TNGR & APGI
            </span>
            <h1 class="text-4xl font-serif font-bold mb-3">Temukan Pemandu Rinjani</h1>
            <p class="text-gray-300 max-w-2xl">Pilih pemandu lokal bersertifikat sesuai jalur, bahasa, dan anggaran Anda. Semua pemandu telah diverifikasi admin.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 -mt-8 mb-16">
        <!-- Filter -->
        <form method="GET" action="{{ route('guide') }}" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label for="rute" class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Jalur</label>
                <select id="rute" name="rute" class="w-full border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange">
                    <option value="">Semua jalur</option>
                    @foreach ($ruteTersedia as $rute)
                        <option value="{{ $rute }}" {{ ($filter['rute'] ?? '') === $rute ? 'selected' : '' }}>{{ $rute }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="bahasa" class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Bahasa</label>
                <select id="bahasa" name="bahasa" class="w-full border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange">
                    <option value="">Semua bahasa</option>
                    @foreach ($bahasaTersedia as $bahasa)
                        <option value="{{ $bahasa }}" {{ ($filter['bahasa'] ?? '') === $bahasa ? 'selected' : '' }}>{{ $bahasa }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tarif_min" class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Tarif Min (Rp)</label>
                <input type="number" min="0" step="50000" id="tarif_min" name="tarif_min" value="{{ $filter['tarif_min'] ?? '' }}"
                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange" placeholder="350000">
            </div>
            <div>
                <label for="tarif_max" class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Tarif Max (Rp)</label>
                <input type="number" min="0" step="50000" id="tarif_max" name="tarif_max" value="{{ $filter['tarif_max'] ?? '' }}"
                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange" placeholder="500000">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-brand-orange text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Cari
                </button>
                <a href="{{ route('guide') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
            </div>
        </form>

        <div class="flex justify-between items-center mb-6">
            <p class="text-sm text-gray-500"><span class="font-bold text-brand-dark">{{ $daftar->count() }}</span> pemandu ditemukan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($daftar as $pemandu)
                <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col kartu-modern">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-brand-dark text-white rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                            {{ $pemandu->inisial() }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-lg text-brand-dark flex items-center gap-1 truncate">
                                {{ $pemandu->user->nama ?? 'Pemandu' }}
                                <i class="fa-solid fa-circle-check text-blue-500 text-sm"></i>
                            </h3>
                            <p class="text-xs text-gray-500 truncate">{{ $pemandu->nomor_lisensi ? 'Lisensi '.$pemandu->nomor_lisensi : 'Pemandu lokal' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach ($pemandu->ruteList() as $rute)
                            <span class="bg-green-50 text-green-700 text-[11px] font-semibold px-2 py-1 rounded">{{ $rute }}</span>
                        @endforeach
                    </div>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $pemandu->bio ?: 'Pemandu lokal berpengalaman di kawasan Taman Nasional Gunung Rinjani.' }}</p>

                    <div class="mt-auto border-t border-gray-100 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500">Mulai dari</p>
                            <p class="font-bold text-brand-orange">{{ \Modules\Guide\Support\Formatter::rupiah($pemandu->tarif_harian) }} <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        </div>
                        <a href="{{ route('guide.detail', $pemandu) }}" class="bg-brand-orange text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 bg-white border border-gray-200 rounded-2xl p-12 text-center">
                    <div class="text-4xl mb-3">🔍</div>
                    <p class="font-bold text-brand-dark mb-2">Pemandu tidak ditemukan</p>
                    <p class="text-sm text-gray-500">Coba ubah filter jalur, bahasa, atau rentang tarif Anda.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
