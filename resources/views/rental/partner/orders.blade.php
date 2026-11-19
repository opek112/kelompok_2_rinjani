@extends('layouts.rental')

@section('title', 'Pesanan Masuk')
@section('subtitle', 'Verifikasi pesanan, catat serah terima, dan pantau alat yang sedang dibawa pendaki.')

@section('content')
    @php
        use Modules\Booking\Models\Pemesanan;
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\StatusPesanan;
        use Modules\Rental\Support\Tanggal;

        $gayaTahap = [
            'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
            'sky' => 'bg-sky-50 text-sky-700 ring-sky-100',
            'amber' => 'bg-amber-50 text-amber-700 ring-amber-100',
            'slate' => 'bg-slate-100 text-slate-600 ring-slate-200',
            'red' => 'bg-red-50 text-red-600 ring-red-100',
        ];

        $inisial = fn (string $nama): string => collect(explode(' ', $nama))
            ->filter()
            ->take(2)
            ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
            ->implode('');

        $nomorWa = fn (string $telepon): string => '62'.ltrim(preg_replace('/\D/', '', $telepon), '0');

        $tabs = [
            'akan-datang' => ['label' => 'Akan Datang', 'ikon' => 'fa-hourglass-half'],
            'disewa' => ['label' => 'Sedang Disewa', 'ikon' => 'fa-person-hiking'],
            'selesai' => ['label' => 'Selesai', 'ikon' => 'fa-circle-check'],
        ];
    @endphp

    <!-- Ringkasan alur -->
    <section class="reveal mb-6 overflow-hidden rounded-2xl border border-line/14 bg-panel/80 p-4 backdrop-blur sm:p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ink text-champagne"><i class="fa-solid fa-route text-xs"></i></span>
                <div>
                    <p class="text-[13px] font-semibold text-ink">Alur singkat pengelolaan pesanan</p>
                    <p class="mt-0.5 text-[12px] text-ink/50">
                        <span class="font-medium text-ink/70">1.</span> Siapkan alat ·
                        <span class="font-medium text-ink/70">2.</span> Konfirmasi serah terima ·
                        <span class="font-medium text-ink/70">3.</span> Catat pengembalian.
                    </p>
                </div>
            </div>
            <div class="flex gap-4 text-[11px] text-ink/45">
                <span><span class="font-semibold text-ink">{{ $stats['disewa'] }}</span> unit di lapangan</span>
                <span><span class="font-semibold text-ink">{{ $stats['tersedia'] }}</span> unit siap</span>
            </div>
        </div>
    </section>

    <!-- Tab & pencarian -->
    <div class="reveal mb-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="inline-flex w-full gap-1 overflow-x-auto rounded-xl border border-line/14 bg-panel/80 p-1 lg:w-auto">
            @foreach ($tabs as $kode => $info)
                <a href="{{ route('rental.orders', array_filter(['tab' => $kode, 'q' => $pencarian])) }}"
                    class="flex flex-1 items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2 text-[13px] font-medium transition lg:flex-none
                        {{ $tab === $kode ? 'bg-ink text-white shadow-soft' : 'text-ink/55 hover:bg-sand hover:text-ink' }}">
                    <i class="fa-solid {{ $info['ikon'] }} text-[11px]"></i>
                    {{ $info['label'] }}
                    <span class="rounded-full px-1.5 py-0.5 text-[10px] font-bold {{ $tab === $kode ? 'bg-white/15 text-white' : 'bg-sand text-ink/55' }}">{{ $jumlah[$kode] }}</span>
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('rental.orders') }}" class="flex items-center gap-2">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <label class="relative flex items-center">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 text-xs text-ink/30"></i>
                <input type="search" name="q" value="{{ $pencarian }}" placeholder="Cari kode, nama, atau telepon..."
                    class="w-full rounded-xl border border-line/14 bg-panel/80 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15 lg:w-72">
            </label>
            <button type="submit" class="rounded-xl bg-ink px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-moss">Cari</button>
        </form>
    </div>

    @if ($pesanan->isEmpty())
        <section class="reveal card px-6 py-16 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sand text-ink/25">
                <i class="fa-regular fa-clipboard text-xl"></i>
            </div>
            <h2 class="mt-5 font-serif text-2xl text-ink">
                @if ($pencarian !== '')
                    Pesanan tidak ditemukan
                @else
                    Belum ada pesanan di tahap ini
                @endif
            </h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-ink/50">
                @if ($pencarian !== '')
                    Coba kata kunci lain atau lihat seluruh pesanan pada tab lain.
                @elseif ($tab === 'akan-datang')
                    Setiap pesanan baru yang sudah dibayar akan muncul di sini untuk Anda siapkan.
                @elseif ($tab === 'disewa')
                    Alat yang sudah diserahkan akan tercatat di sini sampai pendaki mengembalikannya.
                @else
                    Riwayat pesanan yang sudah selesai atau dibatalkan akan tampil di sini.
                @endif
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('rental.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-line/22 px-5 py-2.5 text-sm font-medium text-ink/70 transition hover:border-ink/30 hover:text-ink">
                    <i class="fa-solid fa-tent text-xs"></i> Lihat Inventaris
                </a>
                @if ($pencarian !== '')
                    <a href="{{ route('rental.orders', ['tab' => $tab]) }}" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                        <i class="fa-solid fa-arrow-rotate-left text-xs"></i> Reset Pencarian
                    </a>
                @endif
            </div>
        </section>
    @else
        <div class="space-y-4">
            @foreach ($pesanan as $index => $order)
                @php
                    $tahap = StatusPesanan::tahap($order);
                    $lunas = $order->pembayaran?->status_pembayaran === 'settlement';
                @endphp
                <article class="card card-lift reveal overflow-hidden" style="--d: {{ min($index * 60, 240) }}ms">
                    <!-- Baris atas -->
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 border-b border-line/10 px-5 py-3">
                        <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink/55">{{ $order->kode_pemesanan }}</span>
                        <span class="hidden h-3 w-px bg-line/18 sm:block"></span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] {{ $lunas ? 'text-emerald-700' : 'text-amber-700' }}">
                            <i class="fa-solid {{ $lunas ? 'fa-circle-check' : 'fa-clock' }} text-[10px]"></i>
                            {{ $lunas ? 'Lunas via QRIS' : 'Menunggu Pembayaran' }}
                        </span>
                        <span class="chip {{ $gayaTahap[$tahap['tone']] ?? $gayaTahap['slate'] }} ring-1 ml-auto">
                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span> {{ $tahap['label'] }}
                        </span>
                    </div>

                    <!-- Detail -->
                    <div class="grid gap-5 p-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sand text-[11px] font-bold text-ink/60">{{ $inisial($order->nama_ketua) }}</span>
                            <div class="min-w-0">
                                <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Pelanggan</p>
                                <p class="truncate text-[13px] font-semibold text-ink">{{ $order->nama_ketua }}</p>
                                <p class="truncate text-[11px] text-ink/45">{{ $order->telepon_ketua ?: $order->email_ketua }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Jadwal Sewa</p>
                            <p class="mt-1 text-[13px] font-semibold text-ink">{{ Tanggal::rentang($order->tanggal_mulai, $order->tanggal_selesai) }}</p>
                            <p class="text-[11px] text-ink/45">{{ $order->total_hari }} hari · Pos {{ $order->items->first()?->peralatan?->pos ?? $toko->nama_toko }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Titik Penyerahan</p>
                            <p class="mt-1 text-[13px] font-semibold text-ink">{{ $toko->nama_toko }}</p>
                            <p class="line-clamp-2 text-[11px] text-ink/45">{{ $toko->alamat ?: 'Basecamp mitra' }}</p>
                        </div>

                        <div class="lg:text-right">
                            <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Nilai Pesanan</p>
                            <p class="mt-1 text-[15px] font-semibold text-ink">{{ Rupiah::format($order->total_tagihan) }}</p>
                            <p class="text-[11px] text-ink/45">{{ $order->items->sum('jumlah') }} unit alat</p>
                        </div>
                    </div>

                    <!-- Alat -->
                    <div class="border-t border-line/10 px-5 py-3.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="mr-1 inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-ink/35">
                                <i class="fa-solid fa-list-check"></i> Alat
                            </span>
                            @foreach ($order->items as $item)
                                <span class="inline-flex items-center gap-2 rounded-lg border border-line/14 bg-sand/60 px-2.5 py-1 text-[11px] text-ink/70">
                                    {{ $item->peralatan?->nama ?? 'Alat dihapus' }}
                                    <span class="rounded bg-panel px-1.5 py-0.5 text-[10px] font-bold text-ink/60">{{ $item->jumlah }}×</span>
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="flex flex-col gap-3 border-t border-line/10 bg-sand/40 px-5 py-3.5 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-[11px] {{ $tahap['kode'] === 'terlambat' ? 'font-medium text-red-600' : 'text-ink/45' }}">
                            <i class="fa-regular fa-clock mr-1"></i> {{ $tahap['catatan'] }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            @if ($order->telepon_ketua)
                                <a href="https://wa.me/{{ $nomorWa($order->telepon_ketua) }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-2 rounded-lg border border-line/22 bg-panel px-3.5 py-2 text-[12px] font-medium text-ink/70 transition hover:border-ink/30 hover:text-ink">
                                    <i class="fa-brands fa-whatsapp text-[12px]"></i> Hubungi Pemesan
                                </a>
                            @endif

                            @if ($tahap['kode'] === 'siap-diserahkan')
                                <form action="{{ route('rental.orders.deliver', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-lg px-4 py-2 text-[12px] font-semibold text-white">
                                        <i class="fa-solid fa-handshake-angle text-[11px]"></i> Konfirmasi Serah Terima
                                    </button>
                                </form>
                            @elseif (in_array($tahap['kode'], ['disewa', 'terlambat'], true))
                                <a href="{{ route('rental.returns.show', $order) }}"
                                    class="btn-primary sheen inline-flex items-center gap-2 rounded-lg px-4 py-2 text-[12px] font-semibold text-white">
                                    <i class="fa-solid fa-rotate-left text-[11px]"></i> Catat Pengembalian
                                </a>
                            @elseif ($order->status === 'completed')
                                <a href="{{ route('rental.returns.show', $order) }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-line/22 bg-panel px-3.5 py-2 text-[12px] font-medium text-ink/70 transition hover:border-ink/30 hover:text-ink">
                                    <i class="fa-solid fa-file-lines text-[11px]"></i> Lihat Bukti Pengembalian
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-lg border border-line/14 bg-panel px-3.5 py-2 text-[12px] font-medium text-ink/35">
                                    <i class="fa-solid fa-check text-[11px]"></i> Tidak ada tindakan
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Paginasi -->
        @if ($pesanan->hasPages())
            <div class="mt-6 flex items-center justify-between gap-3 text-[11px] text-ink/50">
                @if ($pesanan->onFirstPage())
                    <span class="inline-flex items-center gap-2 rounded-lg border border-line/10 px-3 py-1.5 opacity-40">
                        <i class="fa-solid fa-chevron-left text-[9px]"></i> Sebelumnya
                    </span>
                @else
                    <a href="{{ $pesanan->previousPageUrl() }}" class="inline-flex items-center gap-2 rounded-lg border border-line/16 px-3 py-1.5 transition hover:border-brand-orange/40 hover:text-brand-orange">
                        <i class="fa-solid fa-chevron-left text-[9px]"></i> Sebelumnya
                    </a>
                @endif

                <span>Halaman {{ $pesanan->currentPage() }} dari {{ $pesanan->lastPage() }}</span>

                @if ($pesanan->hasMorePages())
                    <a href="{{ $pesanan->nextPageUrl() }}" class="inline-flex items-center gap-2 rounded-lg border border-line/16 px-3 py-1.5 transition hover:border-brand-orange/40 hover:text-brand-orange">
                        Berikutnya <i class="fa-solid fa-chevron-right text-[9px]"></i>
                    </a>
                @else
                    <span class="inline-flex items-center gap-2 rounded-lg border border-line/10 px-3 py-1.5 opacity-40">
                        Berikutnya <i class="fa-solid fa-chevron-right text-[9px]"></i>
                    </span>
                @endif
            </div>
        @endif
    @endif
@endsection
