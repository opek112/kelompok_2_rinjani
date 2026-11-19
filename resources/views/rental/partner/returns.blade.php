@extends('layouts.rental')

@section('title', 'Pengembalian Alat')
@section('subtitle', 'Catat kondisi alat yang kembali dari pendaki dan pantau denda keterlambatan.')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;
    @endphp

    <!-- Ringkasan -->
    <section class="mb-7 grid gap-4 sm:grid-cols-3">
        <div class="card stat-card reveal p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-ink/40">Menunggu Kembali</p>
                    <p class="mt-2 text-2xl font-semibold text-ink" data-count="{{ $menunggu->count() }}">{{ $menunggu->count() }}</p>
                    <p class="mt-1 text-[11px] text-ink/45">pesanan masih di lapangan</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sand text-ink/60"><i class="fa-solid fa-person-hiking text-sm"></i></span>
            </div>
        </div>

        <div class="card stat-card reveal p-5" style="--d: 80ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-ink/40">Lewat Jadwal</p>
                    <p class="mt-2 text-2xl font-semibold {{ $terlambat > 0 ? 'text-red-600' : 'text-ink' }}">{{ $terlambat }}</p>
                    <p class="mt-1 text-[11px] text-ink/45">perlu dihubungi hari ini</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600"><i class="fa-solid fa-clock text-sm"></i></span>
            </div>
        </div>

        <div class="card stat-card reveal p-5" style="--d: 160ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-ink/40">Total Denda Tercatat</p>
                    <p class="mt-2 text-2xl font-semibold text-ink">{{ Rupiah::format($totalDenda) }}</p>
                    <p class="mt-1 text-[11px] text-ink/45">dari seluruh pengembalian</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-champagne/15 text-[#8a6d29]"><i class="fa-solid fa-receipt text-sm"></i></span>
            </div>
        </div>
    </section>

    <!-- Daftar menunggu pengembalian -->
    <section class="mb-4 flex items-end justify-between gap-3">
        <div>
            <h2 class="font-serif text-xl text-ink">Menunggu Pengembalian</h2>
            <p class="mt-1 text-[12px] text-ink/45">Alat yang sudah diserahkan dan belum kembali ke toko.</p>
        </div>
        <a href="{{ route('rental.orders', ['tab' => 'disewa']) }}"
            class="hidden items-center gap-2 text-[12px] font-medium text-ink/55 transition hover:text-brand-orange sm:inline-flex">
            Lihat di Pesanan <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </section>

    @if ($menunggu->isEmpty())
        <section class="reveal card px-6 py-14 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sand text-ink/25">
                <i class="fa-solid fa-rotate-left text-xl"></i>
            </div>
            <h2 class="mt-5 font-serif text-2xl text-ink">Belum ada alat di lapangan</h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-ink/50">
                Begitu Anda mencatat serah terima di halaman Pesanan, pesanan tersebut akan muncul di sini sampai alatnya dikembalikan.
            </p>
            <a href="{{ route('rental.orders') }}" class="btn-primary sheen mt-6 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                <i class="fa-solid fa-box-open text-xs"></i> Buka Pesanan
            </a>
        </section>
    @else
        <div class="space-y-4">
            @foreach ($menunggu as $index => $pesanan)
                @php
                    $lewat = $pesanan->tanggal_selesai->lt(today());
                    $selisih = $pesanan->tanggal_selesai->diffInDays(today());
                @endphp
                <article class="card card-lift reveal overflow-hidden" style="--d: {{ min($index * 60, 240) }}ms">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 border-b border-line/10 px-5 py-3">
                        <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink/55">{{ $pesanan->kode_pemesanan }}</span>
                        <span class="hidden h-3 w-px bg-line/16 sm:block"></span>
                        <span class="text-[11px] text-ink/45">{{ $pesanan->nama_ketua }}</span>
                        <span class="chip ml-auto ring-1 {{ $lewat ? 'bg-red-50 text-red-600 ring-red-100' : 'bg-emerald-50 text-emerald-700 ring-emerald-100' }}">
                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                            {{ $lewat ? 'Terlambat '.$selisih.' hari' : 'Dalam masa sewa' }}
                        </span>
                    </div>

                    <div class="grid gap-5 p-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Jadwal Sewa</p>
                            <p class="mt-1 text-[13px] font-semibold text-ink">{{ Tanggal::rentang($pesanan->tanggal_mulai, $pesanan->tanggal_selesai) }}</p>
                            <p class="text-[11px] text-ink/45">{{ $pesanan->total_hari }} hari</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Kembali Dijadwalkan</p>
                            <p class="mt-1 text-[13px] font-semibold {{ $lewat ? 'text-red-600' : 'text-ink' }}">{{ Tanggal::panjang($pesanan->tanggal_selesai) }}</p>
                            <p class="text-[11px] text-ink/45">{{ $pesanan->waktu_serah_terima?->translatedFormat('d M Y, H:i') }} WIB diserahkan</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Alat Dibawa</p>
                            <p class="mt-1 text-[13px] font-semibold text-ink">{{ $pesanan->items->sum('jumlah') }} unit</p>
                            <p class="text-[11px] text-ink/45">{{ $pesanan->items->count() }} jenis alat</p>
                        </div>
                        <div class="flex items-end lg:justify-end">
                            <a href="{{ route('rental.returns.show', $pesanan) }}"
                                class="btn-primary sheen inline-flex items-center gap-2 rounded-lg px-4 py-2 text-[12px] font-semibold text-white">
                                <i class="fa-solid fa-clipboard-check text-[11px]"></i> Catat Pengembalian
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-line/10 bg-sand/40 px-5 py-3">
                        <div class="flex flex-wrap items-center gap-2">
                            @foreach ($pesanan->items as $item)
                                <span class="inline-flex items-center gap-2 rounded-lg border border-line/12 bg-panel px-2.5 py-1 text-[11px] text-ink/70">
                                    {{ $item->peralatan?->nama ?? 'Alat dihapus' }}
                                    <span class="rounded bg-sand px-1.5 py-0.5 text-[10px] font-bold text-ink/60">{{ $item->jumlah }}×</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    <!-- Riwayat -->
    <section class="mb-4 mt-10 flex items-end justify-between gap-3">
        <div>
            <h2 class="font-serif text-xl text-ink">Riwayat Pengembalian</h2>
            <p class="mt-1 text-[12px] text-ink/45">Catatan kondisi alat yang sudah selesai diperiksa.</p>
        </div>
    </section>

    @if ($riwayat->isEmpty())
        <section class="reveal card px-6 py-10 text-center text-sm text-ink/45">
            Belum ada pengembalian yang tercatat.
        </section>
    @else
        <div class="reveal card overflow-hidden">
            <div class="divide-y divide-line/12">
                @foreach ($riwayat as $pesanan)
                    @php
                        $rusak = $pesanan->items->sum(fn ($item) => $item->pengembalian?->jumlah_rusak ?? 0);
                        $hilang = $pesanan->items->sum(fn ($item) => $item->pengembalian?->jumlah_hilang ?? 0);
                    @endphp
                    <a href="{{ route('rental.returns.show', $pesanan) }}"
                        class="row-hover flex flex-wrap items-center gap-3 px-5 py-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-700">
                            <i class="fa-solid fa-check text-[11px]"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[13px] font-semibold text-ink">{{ $pesanan->kode_pemesanan }}</p>
                            <p class="text-[11px] text-ink/45">{{ $pesanan->nama_ketua }} · {{ $pesanan->waktu_pengembalian?->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="ml-auto flex flex-wrap items-center gap-2 text-[11px]">
                            @if ($rusak > 0)
                                <span class="chip bg-amber-50 text-amber-700 ring-1 ring-amber-100">{{ $rusak }} rusak</span>
                            @endif
                            @if ($hilang > 0)
                                <span class="chip bg-red-50 text-red-600 ring-1 ring-red-100">{{ $hilang }} hilang</span>
                            @endif
                            <span class="font-semibold text-ink">{{ Rupiah::format($pesanan->denda_total) }}</span>
                            <i class="fa-solid fa-chevron-right text-[9px] text-ink/30"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
