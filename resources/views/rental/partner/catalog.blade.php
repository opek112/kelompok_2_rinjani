@extends('layouts.rental')

@section('title', 'Katalog Barang Sewa')
@section('subtitle', 'Tampilan barang Anda di katalog publik, lengkap dengan sisa stok per tanggal.')

@php
    use Modules\Rental\Support\Rupiah;

    $urlFilter = function (array $overrides = []) {
        $params = array_merge(request()->except(array_keys($overrides)), $overrides);
        $params = array_filter($params, fn ($value) => $value !== null && $value !== '' && $value !== 'Semua');

        return route('rental.catalog', $params);
    };
@endphp

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-[12px] text-ink/50">
                <span class="font-semibold text-ink">{{ $peralatan->total() }}</span> jenis alat terdaftar di toko {{ $toko->nama_toko }}.
            </p>
            <div class="mt-2 flex flex-wrap items-center gap-2 text-[11px]">
                @if ($tampilPublik)
                    <span class="chip bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                        <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Tampil di katalog publik
                    </span>
                @else
                    <span class="chip bg-amber-50 text-amber-700 ring-1 ring-amber-100">
                        <i class="fa-solid fa-eye-slash text-[9px]"></i> Belum tampil publik
                    </span>
                    <a href="{{ route('rental.settings', ['tab' => 'keamanan']) }}" class="text-[11px] font-semibold text-brand-orange hover:underline">Aktifkan toko</a>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('rental') }}" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 rounded-xl border border-line/20 px-4 py-2.5 text-[12px] font-semibold text-ink/70 transition hover:border-ink/35 hover:text-ink">
                <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i> Katalog Publik
            </a>
            <a href="{{ route('rental.equipment.create') }}" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-[12px] font-semibold text-white">
                <i class="fa-solid fa-plus text-[11px]"></i> Tambah Alat
            </a>
        </div>
    </div>

    {{-- Filter & rentang tanggal --}}
    <section class="reveal card mt-5 p-4 sm:p-5" style="--d: 40ms">
        <form action="{{ route('rental.catalog') }}" method="GET" class="flex flex-col gap-3 xl:flex-row xl:items-end">
            <div class="flex-1">
                <label class="field-label" for="q">Cari alat</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-ink/35"></i>
                    <input id="q" type="text" name="q" value="{{ $pencarian }}" placeholder="Cari nama atau deskripsi alat..." class="field pl-10">
                </div>
            </div>

            <div>
                <label class="field-label" for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="field min-w-[9rem]">
                    <option value="Semua">Semua kategori</option>
                    @foreach ($daftarKategori as $satuKategori)
                        <option value="{{ $satuKategori }}" @selected($kategori === $satuKategori)>{{ $satuKategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="field-label" for="mulai">Cek stok mulai</label>
                <input id="mulai" type="date" name="mulai" value="{{ $mulai->toDateString() }}" class="field">
            </div>

            <div>
                <label class="field-label" for="selesai">sampai</label>
                <input id="selesai" type="date" name="selesai" value="{{ $selesai->toDateString() }}" class="field">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-ink px-4 py-2.5 text-[12px] font-semibold text-white transition hover:opacity-90">
                    <i class="fa-solid fa-sliders text-[11px]"></i> Terapkan
                </button>
                <a href="{{ route('rental.catalog') }}" class="inline-flex items-center rounded-xl border border-line/20 px-4 py-2.5 text-[12px] font-medium text-ink/60 transition hover:border-ink/35 hover:text-ink">Reset</a>
            </div>
        </form>

        <p class="mt-3 border-t border-line/10 pt-3 text-[11px] text-ink/45">
            <i class="fa-regular fa-circle-question mr-1"></i>
            Sisa stok dihitung dari jumlah stok dikurangi pesanan beririsan berstatus <span class="font-semibold text-ink/65">dibayar</span> atau <span class="font-semibold text-ink/65">menunggu pembayaran yang belum kedaluwarsa</span>.
        </p>
    </section>

    {{-- Kartu alat --}}
    @if ($peralatan->isEmpty())
        <section class="reveal card mt-6 px-6 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-sand text-ink/35">
                <i class="fa-solid fa-tent"></i>
            </div>
            <h3 class="mt-4 font-serif text-xl text-ink">Belum ada alat yang cocok</h3>
            <p class="mx-auto mt-2 max-w-sm text-[12px] leading-relaxed text-ink/50">
                Tambahkan alat baru atau ubah kata kunci pencarian Anda.
            </p>
            <a href="{{ route('rental.equipment.create') }}" class="btn-primary sheen mt-5 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Alat
            </a>
        </section>
    @else
        <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($peralatan as $item)
                @php $sisa = $sisaStok[$item->id] ?? $item->jumlah_stok; @endphp
                <article class="reveal card card-lift overflow-hidden" style="--d: {{ 70 + $loop->index * 40 }}ms">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $item->fotoUtama() }}" alt="{{ $item->nama }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        <span class="absolute left-3 top-3 chip bg-panel/90 text-ink/75 backdrop-blur">
                            <i class="fa-solid fa-location-dot text-[9px]"></i> Pos {{ $item->pos ?? $toko->lokasi_pos }}
                        </span>
                        <span class="absolute right-3 top-3 chip {{ $sisa > 3 ? 'bg-emerald-50 text-emerald-700' : ($sisa > 0 ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-600') }}">
                            <i class="fa-solid fa-cubes text-[9px]"></i> Sisa {{ $sisa }} unit
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-center gap-2 text-[11px] text-ink/45">
                            <span class="chip bg-sand text-ink/60">{{ $item->kategori ?? 'Lainnya' }}</span>
                            <span class="ml-auto flex items-center gap-1 font-semibold text-ink/60">
                                <i class="fa-solid fa-star text-[10px] text-amber-500"></i>
                                {{ number_format((float) $item->rating, 1, ',', '.') }} ({{ (int) $item->jumlah_ulasan }})
                            </span>
                        </div>

                        <h3 class="mt-2 font-serif text-lg leading-snug text-ink">{{ $item->nama }}</h3>
                        <p class="mt-1 line-clamp-2 flex-1 text-[12px] leading-relaxed text-ink/50">{{ $item->deskripsi ?: 'Belum ada deskripsi alat.' }}</p>

                        <div class="mt-4 flex items-end justify-between gap-3 border-t border-line/10 pt-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-ink/40">Tarif Sewa</p>
                                <p class="text-[15px] font-bold text-brand-orange">
                                    {{ Rupiah::format($item->tarif_harian) }}<span class="text-[11px] font-normal text-ink/45">/hari</span>
                                </p>
                                <p class="mt-0.5 text-[10px] text-ink/40">Total stok {{ $item->jumlah_stok }} unit</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('rental.detail', $item) }}" target="_blank" rel="noopener"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-line/20 text-ink/55 transition hover:border-ink/35 hover:text-ink"
                                    title="Lihat di katalog publik">
                                    <i class="fa-regular fa-eye text-[11px]"></i>
                                </a>
                                <a href="{{ route('rental.equipment.edit', $item) }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-line/20 px-3 py-2 text-[11px] font-semibold text-ink/70 transition hover:border-ink/35 hover:text-ink">
                                    <i class="fa-regular fa-pen-to-square text-[10px]"></i> Kelola
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $peralatan->links() }}
        </div>
    @endif
@endsection
