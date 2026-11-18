@extends('layouts.app')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;

        $urlFilter = function (array $overrides = []) {
            $params = array_merge(request()->except(array_keys($overrides)), $overrides);
            $params = array_filter($params, fn ($value) => $value !== null && $value !== '' && $value !== 'Semua');

            return route('rental', $params);
        };
    @endphp

    <section class="pt-10 pb-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white border border-gray-200 text-brand-dark text-[11px] font-bold tracking-wider px-3 py-1.5 rounded-full">
                        <i class="fa-solid fa-circle-check text-green-600"></i> STANDAR PERLENGKAPAN RESMI LINGKAR RINJANI
                    </span>
                    <h1 class="text-4xl md:text-5xl font-serif font-bold text-brand-dark mt-4">Sewa Alat Outdoor</h1>
                    <p class="text-gray-500 mt-3 max-w-2xl">
                        Alat berkualitas dari toko rental di lingkar Rinjani terawat, bersih, dan siap untuk ekspedisi ekstrem.
                    </p>
                </div>
                <a href="{{ route('rental.cart') }}" class="inline-flex items-center gap-2 bg-brand-dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-green transition">
                    <i class="fa-solid fa-cart-shopping"></i> Keranjang
                    @if (array_sum(session('rental_cart.items', [])) > 0)
                        <span class="bg-brand-orange text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ array_sum(session('rental_cart.items', [])) }}</span>
                    @endif
                </a>
            </div>

            <!-- Panel Pencarian & Filter -->
            <div class="bg-white rounded-2xl border border-gray-200 p-4 mt-8 shadow-sm" x-data="{ lanjutan: {{ ($tokoId || $hargaMaksimal) ? 'true' : 'false' }} }">
                <form action="{{ route('rental') }}" method="GET">
                    @if ($kategoriAktif && $kategoriAktif !== 'Semua')
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                    @endif
                    @if ($posAktif && $posAktif !== 'Semua')
                        <input type="hidden" name="pos" value="{{ $posAktif }}">
                    @endif

                    <div class="flex flex-col lg:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
                            <input type="text" name="q" value="{{ $pencarian }}" placeholder="Cari alat..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-brand-orange focus:border-brand-orange outline-none text-sm">
                        </div>

                        <div class="flex gap-3">
                            <div class="relative">
                                <select name="urutkan" onchange="this.form.submit()"
                                    class="appearance-none pl-4 pr-10 py-3 rounded-xl border border-gray-200 text-sm bg-white focus:ring-brand-orange focus:border-brand-orange outline-none">
                                    <option value="terlaris" @selected(! $urutkan || $urutkan === 'terlaris')>Urutkan: Terlaris</option>
                                    <option value="termurah" @selected($urutkan === 'termurah')>Urutkan: Termurah</option>
                                    <option value="termahal" @selected($urutkan === 'termahal')>Urutkan: Termahal</option>
                                    <option value="rating" @selected($urutkan === 'rating')>Urutkan: Rating</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 text-xs pointer-events-none"></i>
                            </div>

                            <button type="button" @click="lanjutan = !lanjutan"
                                class="inline-flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 text-sm font-medium hover:border-brand-orange transition">
                                <i class="fa-solid fa-sliders"></i> Filter Lanjutan
                            </button>
                            <button type="submit" class="bg-brand-dark text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-brand-green transition">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                    <div x-show="lanjutan" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3 pt-3 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Tarif maksimal per hari</label>
                            <select name="maksimal"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm bg-white focus:ring-brand-orange focus:border-brand-orange outline-none">
                                <option value="">Semua tarif</option>
                                <option value="20000" @selected($hargaMaksimal === 20000)>Di bawah Rp 20.000</option>
                                <option value="30000" @selected($hargaMaksimal === 30000)>Di bawah Rp 30.000</option>
                                <option value="40000" @selected($hargaMaksimal === 40000)>Di bawah Rp 40.000</option>
                                <option value="50000" @selected($hargaMaksimal === 50000)>Di bawah Rp 50.000</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Toko rental mitra</label>
                            <select name="toko"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm bg-white focus:ring-brand-orange focus:border-brand-orange outline-none">
                                <option value="">Semua toko</option>
                                @foreach ($daftarToko as $toko)
                                    <option value="{{ $toko->id }}" @selected($tokoId === $toko->id)>{{ $toko->nama_toko }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-brand-orange text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">Terapkan Filter</button>
                            <a href="{{ route('rental') }}" class="px-4 py-2.5 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 transition">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="flex flex-col xl:flex-row xl:items-center gap-4 mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold tracking-wider text-gray-400 mr-1">KATEGORI:</span>
                        <a href="{{ $urlFilter(['kategori' => null]) }}"
                            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ ! $kategoriAktif || $kategoriAktif === 'Semua' ? 'bg-brand-orange text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
                        @foreach ($daftarKategori as $kategori)
                            <a href="{{ $urlFilter(['kategori' => $kategori]) }}"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $kategoriAktif === $kategori ? 'bg-brand-orange text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $kategori }}</a>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap items-center gap-2 xl:ml-auto">
                        <span class="text-[11px] font-bold tracking-wider text-gray-400 mr-1">POS:</span>
                        <a href="{{ $urlFilter(['pos' => null]) }}"
                            class="px-4 py-1.5 rounded-lg border text-sm font-medium transition {{ ! $posAktif || $posAktif === 'Semua' ? 'border-brand-dark bg-brand-dark text-white' : 'border-gray-200 text-gray-600 hover:border-brand-dark' }}">Semua Pos</a>
                        @foreach ($daftarPos as $pos)
                            <a href="{{ $urlFilter(['pos' => $pos]) }}"
                                class="px-4 py-1.5 rounded-lg border text-sm font-medium transition {{ $posAktif === $pos ? 'border-brand-dark bg-brand-dark text-white' : 'border-gray-200 text-gray-600 hover:border-brand-dark' }}">{{ $pos }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <p class="text-sm text-gray-500 mt-6">
                Menampilkan <span class="font-semibold text-brand-dark">{{ $peralatan->count() }}</span> dari
                <span class="font-semibold text-brand-dark">{{ $total }}</span> alat siap sewa.
            </p>

            @if ($peralatan->isEmpty())
                <div class="bg-white border border-dashed border-gray-300 rounded-2xl p-14 text-center mt-6">
                    <i class="fa-solid fa-tent text-3xl text-gray-300"></i>
                    <h3 class="font-bold text-brand-dark mt-4">Tidak ada alat yang cocok</h3>
                    <p class="text-sm text-gray-500 mt-1">Coba kata kunci lain atau reset filter pencarian.</p>
                    <a href="{{ route('rental') }}" class="inline-block mt-5 bg-brand-orange text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">Reset Filter</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @foreach ($peralatan as $item)
                        @php $detailUrl = route('rental.detail', $item); @endphp
                        <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
                            <a href="{{ $detailUrl }}" class="relative block h-52 overflow-hidden">
                                <img src="{{ $item->fotoUtama() }}" alt="{{ $item->nama }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                <span class="absolute top-3 left-3 inline-flex items-center gap-1 bg-white/95 text-brand-dark text-[11px] font-bold px-2.5 py-1 rounded-full">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i> Pos {{ $item->pos ?? $item->toko?->nama_toko }}
                                </span>
                                <span class="absolute top-3 right-3 inline-flex items-center gap-1 {{ $item->jumlah_stok <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }} text-[11px] font-bold px-2.5 py-1 rounded-full">
                                    <i class="fa-solid fa-cubes text-[10px]"></i> {{ $item->labelStok() }}{{ $item->jumlah_stok <= 10 ? ' (Terbatas)' : '' }}
                                </span>
                            </a>

                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="font-semibold text-brand-dark">{{ $item->toko?->nama_toko }}</span>
                                    <span class="inline-flex items-center gap-1 text-green-700 text-[11px] font-semibold bg-green-50 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-brand-dark mt-2">
                                    <a href="{{ $detailUrl }}" class="hover:text-brand-orange transition">{{ $item->nama }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1 flex-grow">{{ $item->deskripsi }}</p>

                                <div class="flex items-end justify-between gap-3 mt-6 pt-4 border-t border-gray-100">
                                    <div>
                                        <p class="text-[10px] font-bold tracking-wider text-gray-400">TARIF SEWA</p>
                                        <p class="font-bold text-brand-orange text-lg leading-tight">
                                            {{ Rupiah::format($item->tarif_harian) }}
                                            <span class="text-xs text-gray-500 font-normal">/hari</span>
                                        </p>
                                    </div>
                                    <a href="{{ $detailUrl }}" class="inline-flex items-center gap-2 bg-brand-orange text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">
                                        <i class="fa-solid fa-tent"></i> Sewa Alat
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            @if ($total > $tampil)
                <div class="text-center mt-10">
                    <a href="{{ $urlFilter(['tampil' => $tampilBerikutnya]) }}"
                        class="inline-flex items-center gap-2 bg-white border border-gray-800 text-brand-dark px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Muat Lebih Banyak <i class="fa-solid fa-chevron-down text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
