@extends('layouts.rental')

@section('title', 'Dashboard Inventaris')
@section('subtitle', 'Kelola stok unit, tarif sewa, dan kesiapan alat ekspedisi '.$toko->nama_toko.'.')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;

        $kondisi = function (int $stok): array {
            return match (true) {
                $stok <= 0 => ['label' => 'Habis', 'class' => 'bg-red-50 text-red-600 ring-red-100', 'dot' => 'bg-red-500'],
                $stok <= 3 => ['label' => 'Terbatas', 'class' => 'bg-amber-50 text-amber-700 ring-amber-100', 'dot' => 'bg-amber-500'],
                default => ['label' => 'Baik', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-100', 'dot' => 'bg-emerald-500'],
            };
        };

        $adaFilter = $pencarian !== '' || ($kategori !== '' && $kategori !== 'Semua') || $urutkan !== '';
    @endphp

    <!-- HERO -->
    <section class="reveal relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-[#0C2A21] via-[#0A231B] to-[#123B2C] text-white">
        <div class="orb pointer-events-none absolute -left-10 -top-16 h-56 w-56 bg-champagne/25" data-parallax="0.05"></div>
        <div class="orb floaty pointer-events-none absolute -bottom-24 right-6 h-64 w-64 bg-emerald-400/20" data-parallax="0.09"></div>

        <!-- Ornamen garis kontur -->
        <svg class="pointer-events-none absolute inset-x-0 bottom-0 h-40 w-full text-white/[.07]" viewBox="0 0 800 160" fill="none" data-parallax="0.14">
            <path d="M0 140 L120 76 L186 112 L280 42 L360 100 L430 60 L520 118 L610 66 L700 108 L800 48" stroke="currentColor" stroke-width="1.5" />
            <path d="M0 158 L140 104 L210 132 L300 72 L380 124 L470 84 L560 138 L650 92 L740 128 L800 96" stroke="currentColor" stroke-width="1" />
        </svg>

        <div class="relative z-10 grid gap-8 p-7 sm:p-9 lg:grid-cols-[1.35fr_1fr] lg:items-center">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/[.07] px-3 py-1.5 text-[10px] uppercase tracking-[0.2em] text-white/70 backdrop-blur">
                    <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-400"></span> {{ $toko->nama_toko }}
                </span>

                <h2 class="mt-5 font-serif text-3xl leading-tight sm:text-[2.35rem]">
                    Selamat datang,<br class="hidden sm:block"> {{ Str::of(auth()->user()->nama)->explode(' ')->first() }}.
                </h2>
                <p class="mt-3 max-w-md text-sm leading-relaxed text-white/55">
                    Semua alat, pesanan, dan penyerahan di satu tempat. Siapkan perlengkapan sebelum pendaki tiba di pos.
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ route('rental.orders') }}"
                        class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold">
                        <i class="fa-solid fa-box-open text-xs"></i> Lihat Pesanan Aktif
                    </a>
                    <a href="{{ route('rental.inventory.export') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-5 py-2.5 text-sm font-medium text-white/80 transition hover:border-white/40 hover:text-white">
                        <i class="fa-solid fa-download text-xs"></i> Unduh Laporan Stok
                    </a>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                <div class="hairline rounded-2xl bg-white/[.06] p-4 backdrop-blur">
                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/45">Perlu Tindakan</p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-2xl font-semibold">{{ $sedangDikemas }}</span>
                        <span class="text-[11px] text-white/50">pesanan menunggu serah terima</span>
                    </div>
                </div>
                <div class="hairline rounded-2xl bg-white/[.06] p-4 backdrop-blur">
                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/45">Kapasitas Tersedia</p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-2xl font-semibold">{{ $stats['tersedia'] }}</span>
                        <span class="text-[11px] text-white/50">unit siap disewakan hari ini</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTIK -->
    <section class="mb-9 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ([
            ['ikon' => 'fa-layer-group', 'label' => 'Jenis Alat', 'nilai' => $stats['jenis'], 'catatan' => 'Kategori terdaftar', 'warna' => 'bg-orange-50 text-brand-orange'],
            ['ikon' => 'fa-boxes-stacked', 'label' => 'Total Unit', 'nilai' => $stats['total'], 'catatan' => 'Unit fisik di toko', 'warna' => 'bg-sand/70 text-moss'],
            ['ikon' => 'fa-clock-rotate-left', 'label' => 'Sedang Disewa', 'nilai' => $stats['disewa'], 'catatan' => 'Dibawa pendaki', 'warna' => 'bg-amber-50 text-amber-600'],
            ['ikon' => 'fa-circle-check', 'label' => 'Tersedia', 'nilai' => $stats['tersedia'], 'catatan' => 'Siap diserahkan', 'warna' => 'bg-emerald-50 text-emerald-600'],
        ] as $index => $kartu)
            <div class="card stat-card card-lift reveal p-5" style="--d: {{ $index * 70 }}ms">
                <div class="flex items-start justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $kartu['warna'] }} text-sm">
                        <i class="fa-solid {{ $kartu['ikon'] }}"></i>
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.16em] text-ink/30">Live</span>
                </div>
                <p class="mt-4 text-3xl font-semibold leading-none text-ink">
                    <span data-count="{{ $kartu['nilai'] }}">{{ $kartu['nilai'] }}</span>
                </p>
                <p class="mt-2 text-[13px] font-medium text-ink/70">{{ $kartu['label'] }}</p>
                <p class="mt-0.5 text-[11px] text-ink/40">{{ $kartu['catatan'] }}</p>
            </div>
        @endforeach
    </section>

    <!-- INVENTARIS -->
    <section class="reveal">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl text-ink">Inventaris Alat</h2>
                <p class="mt-1 text-[13px] text-ink/50">Pantau stok, tarif harian, dan kondisi fisik setiap alat.</p>
            </div>
            <a href="{{ route('rental.equipment.create') }}"
                class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Alat Baru
            </a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('rental.dashboard') }}"
            class="card mb-5 grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-[minmax(0,1fr)_11rem_11rem_auto]">
            <label class="relative flex items-center">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 text-xs text-ink/30"></i>
                <input type="search" name="q" value="{{ $pencarian }}" placeholder="Cari nama alat atau deskripsi..."
                    class="w-full rounded-xl border border-line/14 bg-sand/50 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
            </label>

            <select name="kategori" onchange="this.form.submit()"
                class="rounded-xl border border-line/14 bg-sand/50 px-3 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel">
                <option value="Semua">Semua Kategori</option>
                @foreach ($daftarKategori as $namaKategori)
                    <option value="{{ $namaKategori }}" @selected($kategori === $namaKategori)>{{ $namaKategori }}</option>
                @endforeach
            </select>

            <select name="urutkan" onchange="this.form.submit()"
                class="rounded-xl border border-line/14 bg-sand/50 px-3 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel">
                <option value="">Terbaru</option>
                <option value="nama" @selected($urutkan === 'nama')>Nama A–Z</option>
                <option value="stok" @selected($urutkan === 'stok')>Stok Terbanyak</option>
                <option value="termurah" @selected($urutkan === 'termurah')>Tarif Termurah</option>
                <option value="termahal" @selected($urutkan === 'termahal')>Tarif Termahal</option>
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 rounded-xl bg-ink px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-moss">
                    Cari
                </button>
                @if ($adaFilter)
                    <a href="{{ route('rental.dashboard') }}"
                        class="flex items-center justify-center rounded-xl border border-line/22 px-3 text-sm text-ink/60 transition hover:border-brand-orange/40 hover:text-brand-orange"
                        title="Reset filter">
                        <i class="fa-solid fa-arrow-rotate-left text-xs"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel -->
        <div class="card overflow-hidden">
            @if ($peralatan->isEmpty())
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-sand text-ink/30">
                        <i class="fa-solid fa-tent text-lg"></i>
                    </div>
                    <h3 class="mt-4 font-serif text-xl text-ink">Belum ada alat yang cocok</h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm text-ink/50">
                        @if ($adaFilter)
                            Coba ubah kata kunci atau reset filter untuk melihat seluruh inventaris.
                        @else
                            Tambahkan alat pertama Anda agar pendaki bisa menyewa dari toko ini.
                        @endif
                    </p>
                    <a href="{{ route('rental.equipment.create') }}"
                        class="btn-primary sheen mt-6 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah Alat
                    </a>
                </div>
            @else
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-line/10 text-[10px] uppercase tracking-[0.14em] text-ink/35">
                                <th class="px-5 py-4 font-semibold">Foto</th>
                                <th class="px-3 py-4 font-semibold">Nama Alat</th>
                                <th class="px-3 py-4 font-semibold">Kategori</th>
                                <th class="px-3 py-4 font-semibold">Harga / Hari</th>
                                <th class="px-3 py-4 font-semibold">Stok</th>
                                <th class="px-3 py-4 font-semibold">Kondisi</th>
                                <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line/12">
                            @foreach ($peralatan as $alat)
                                @php $status = $kondisi($alat->jumlah_stok); @endphp
                                <tr class="row-hover">
                                    <td class="px-5 py-3">
                                        <img src="{{ $alat->fotoUtama() }}" alt="{{ $alat->nama }}"
                                            class="h-12 w-12 rounded-xl object-cover ring-1 ring-line/12" loading="lazy">
                                    </td>
                                    <td class="max-w-[18rem] px-3 py-3">
                                        <p class="font-semibold text-ink">{{ $alat->nama }}</p>
                                        <p class="mt-0.5 truncate text-[11px] text-ink/45">{{ $alat->deskripsi ?: 'Tanpa deskripsi' }}</p>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="chip bg-sand text-ink/60 ring-1 ring-line/12">{{ $alat->kategori ?: 'Umum' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-3 font-semibold text-brand-orange">{{ Rupiah::format($alat->tarif_harian) }}</td>
                                    <td class="whitespace-nowrap px-3 py-3">
                                        <span class="font-semibold text-ink">{{ $alat->jumlah_stok }}</span>
                                        <span class="text-[11px] text-ink/40">unit</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="chip {{ $status['class'] }} ring-1">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span> {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('rental.detail', $alat) }}" target="_blank" rel="noopener"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-line/14 text-ink/45 transition hover:border-brand-orange/40 hover:text-brand-orange" title="Lihat di katalog">
                                                <i class="fa-regular fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('rental.equipment.edit', $alat) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-line/14 text-ink/55 transition hover:border-ink/30 hover:text-ink" title="Ubah alat">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>
                                            <form action="{{ route('rental.equipment.destroy', $alat) }}" method="POST"
                                                onsubmit="return confirm('Hapus {{ $alat->nama }} dari inventaris?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-line/14 text-ink/40 transition hover:border-red-200 hover:bg-red-50 hover:text-red-500" title="Hapus alat">
                                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Kartu mobile -->
                <div class="divide-y divide-line/12 md:hidden">
                    @foreach ($peralatan as $alat)
                        @php $status = $kondisi($alat->jumlah_stok); @endphp
                        <div class="flex gap-3 p-4">
                            <img src="{{ $alat->fotoUtama() }}" alt="{{ $alat->nama }}"
                                class="h-16 w-16 shrink-0 rounded-xl object-cover ring-1 ring-line/12" loading="lazy">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="truncate font-semibold text-ink">{{ $alat->nama }}</p>
                                    <span class="chip {{ $status['class'] }} ring-1 shrink-0">{{ $status['label'] }}</span>
                                </div>
                                <p class="mt-0.5 text-[11px] text-ink/45">{{ $alat->kategori ?: 'Umum' }} · {{ $alat->jumlah_stok }} unit</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="font-semibold text-brand-orange">{{ Rupiah::format($alat->tarif_harian) }}<span class="text-[10px] font-normal text-ink/40"> /hari</span></span>
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('rental.equipment.edit', $alat) }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-line/14 text-ink/60">
                                            <i class="fa-solid fa-pen text-[11px]"></i>
                                        </a>
                                        <form action="{{ route('rental.equipment.destroy', $alat) }}" method="POST"
                                            onsubmit="return confirm('Hapus {{ $alat->nama }} dari inventaris?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg border border-line/14 text-red-500">
                                                <i class="fa-regular fa-trash-can text-[11px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginasi -->
                <div class="flex items-center justify-between gap-3 border-t border-line/10 px-4 py-3 text-[11px] text-ink/50 sm:px-5">
                    @if ($peralatan->onFirstPage())
                        <span class="inline-flex items-center gap-2 rounded-lg border border-line/10 px-3 py-1.5 opacity-40">
                            <i class="fa-solid fa-chevron-left text-[9px]"></i> Sebelumnya
                        </span>
                    @else
                        <a href="{{ $peralatan->previousPageUrl() }}" class="inline-flex items-center gap-2 rounded-lg border border-line/16 px-3 py-1.5 transition hover:border-brand-orange/40 hover:text-brand-orange">
                            <i class="fa-solid fa-chevron-left text-[9px]"></i> Sebelumnya
                        </a>
                    @endif

                    <span>Halaman {{ $peralatan->currentPage() }} dari {{ max(1, $peralatan->lastPage()) }} · {{ $peralatan->total() }} alat</span>

                    @if ($peralatan->hasMorePages())
                        <a href="{{ $peralatan->nextPageUrl() }}" class="inline-flex items-center gap-2 rounded-lg border border-line/16 px-3 py-1.5 transition hover:border-brand-orange/40 hover:text-brand-orange">
                            Berikutnya <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-2 rounded-lg border border-line/10 px-3 py-1.5 opacity-40">
                            Berikutnya <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- AKSI CEPAT -->
    <section class="reveal mt-8">
        <div class="card p-5 sm:p-6">
            <div class="mb-4 flex items-center gap-2">
                <span class="h-1 w-6 rounded-full bg-champagne"></span>
                <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink/40">Aksi Cepat</h3>
            </div>

            <div class="grid gap-3 sm:grid-cols-3">
                <a href="{{ route('rental.orders') }}"
                    class="group flex items-center gap-3 rounded-xl border border-line/16 px-4 py-3.5 text-sm font-medium text-ink/75 transition hover:-translate-y-0.5 hover:border-ink/25 hover:text-ink hover:shadow-soft">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sand text-ink/60 transition group-hover:bg-ink group-hover:text-white">
                        <i class="fa-regular fa-clipboard text-xs"></i>
                    </span>
                    Lihat Pesanan Aktif
                    <i class="fa-solid fa-arrow-right ml-auto text-[10px] text-ink/25 transition group-hover:translate-x-0.5 group-hover:text-brand-orange"></i>
                </a>

                <a href="{{ route('rental.returns') }}"
                    class="group flex items-center gap-3 rounded-xl border border-line/16 px-4 py-3.5 text-sm font-medium text-ink/75 transition hover:-translate-y-0.5 hover:border-ink/25 hover:text-ink hover:shadow-soft">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sand text-ink/60 transition group-hover:bg-ink group-hover:text-white">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </span>
                    Catat Pengembalian
                    <i class="fa-solid fa-arrow-right ml-auto text-[10px] text-ink/25 transition group-hover:translate-x-0.5 group-hover:text-brand-orange"></i>
                </a>

                <a href="{{ route('rental.inventory.export') }}"
                    class="group flex items-center gap-3 rounded-xl border border-line/16 px-4 py-3.5 text-sm font-medium text-ink/75 transition hover:-translate-y-0.5 hover:border-ink/25 hover:text-ink hover:shadow-soft">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sand text-ink/60 transition group-hover:bg-ink group-hover:text-white">
                        <i class="fa-solid fa-download text-xs"></i>
                    </span>
                    Unduh Laporan
                    <i class="fa-solid fa-arrow-right ml-auto text-[10px] text-ink/25 transition group-hover:translate-x-0.5 group-hover:text-brand-orange"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
