@extends('layouts.rental')

@section('title', 'Notifikasi')
@section('subtitle', 'Pusat informasi dan aktivitas toko rental Anda.')

@php
    $toneKelas = [
        'orange' => 'bg-orange-50 text-brand-orange',
        'red' => 'bg-red-50 text-red-500',
        'amber' => 'bg-amber-50 text-amber-600',
        'sky' => 'bg-sky-50 text-sky-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
    ];

    $tabUrl = fn (string $nilai) => route('rental.notifications', $nilai === 'semua' ? [] : ['tab' => $nilai]);
@endphp

@section('content')
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
        <div>
            {{-- Bar atas --}}
            <section class="reveal card flex flex-col gap-3 p-4 sm:flex-row sm:items-center" style="--d: 0ms">
                <div class="flex items-center gap-2 text-[13px] font-semibold text-ink">
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-orange"></span>
                    {{ $jumlah['belum'] }} notifikasi belum dibaca
                    <span class="hidden text-[11px] font-normal text-ink/40 sm:inline">• Periksa aksi penyiapan alat pendakian dan keterlambatan</span>
                </div>

                <form action="{{ route('rental.notifications.baca-semua') }}" method="POST" class="sm:ml-auto">
                    @csrf
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-brand-orange/40 px-4 py-2 text-[12px] font-semibold text-brand-orange transition hover:bg-orange-50 disabled:cursor-not-allowed disabled:opacity-50"
                        @disabled($jumlah['belum'] === 0)>
                        <i class="fa-solid fa-check-double text-[11px]"></i> Tandai Semua Dibaca
                    </button>
                </form>
            </section>

            {{-- Tabs --}}
            <nav class="reveal mt-5 flex gap-6 border-b border-line/12 text-[13px] font-semibold" style="--d: 50ms">
                @foreach (['semua' => 'Semua', 'belum' => 'Belum Dibaca', 'sudah' => 'Sudah Dibaca'] as $kunci => $label)
                    <a href="{{ $tabUrl($kunci) }}"
                        class="flex items-center gap-2 pb-3 transition {{ $tab === $kunci ? 'border-b-2 border-brand-orange text-brand-orange' : 'text-ink/50 hover:text-ink/80' }}">
                        {{ $label }}
                        <span class="rounded px-2 py-0.5 text-[10px] {{ $tab === $kunci ? ($kunci === 'belum' ? 'bg-brand-orange text-white' : 'bg-sand text-ink/60') : 'bg-sand text-ink/50' }}">{{ $jumlah[$kunci] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Daftar notifikasi --}}
            <div class="mt-5 space-y-3">
                @forelse ($notifikasi as $item)
                    @php $belumDibaca = ! in_array($item['id'], $dibaca, true); @endphp
                    <article class="reveal relative flex gap-4 rounded-xl border p-5 transition {{ $belumDibaca ? 'border-emerald-200/70 bg-emerald-50/60 shadow-soft' : 'border-line/12 bg-panel/94' }}"
                        style="--d: {{ 70 + $loop->index * 40 }}ms">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $toneKelas[$item['tone']] ?? 'bg-sand text-ink/60' }}">
                            <i class="fa-solid {{ $item['ikon'] }}"></i>
                        </span>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-[14px] font-semibold text-ink">{{ $item['judul'] }}</h3>
                                <span class="chip bg-sand text-ink/55">{{ ucfirst($item['jenis']) }}</span>
                            </div>
                            <p class="mt-1 text-[13px] leading-relaxed text-ink/65">{{ $item['pesan'] }}</p>

                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] text-ink/45">
                                <span class="inline-flex items-center gap-1.5"><i class="fa-regular fa-clock"></i> {{ $item['waktu_relatif'] }}</span>
                                <span class="inline-flex items-center gap-1.5 text-ink/55">
                                    <span class="h-1.5 w-1.5 rounded-full bg-brand-orange"></span> {{ $item['label'] }}
                                </span>
                                <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1.5 font-semibold text-brand-orange transition hover:underline">
                                    Buka Detail <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                                </a>
                            </div>
                        </div>

                        @if ($belumDibaca)
                            <div class="flex shrink-0 flex-col items-end gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-brand-orange" aria-label="Belum dibaca"></span>
                                <form action="{{ route('rental.notifications.baca', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-semibold text-ink/40 transition hover:text-ink/70" title="Tandai sudah dibaca">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </article>
                @empty
                    <section class="reveal card px-6 py-14 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-sand text-ink/35">
                            <i class="fa-regular fa-bell-slash"></i>
                        </div>
                        <h3 class="mt-4 font-serif text-xl text-ink">{{ $tab === 'belum' ? 'Semua notifikasi sudah dibaca' : 'Belum ada notifikasi' }}</h3>
                        <p class="mx-auto mt-2 max-w-sm text-[12px] leading-relaxed text-ink/50">
                            Notifikasi pesanan, pengembalian, dan stok alat akan muncul otomatis di sini.
                        </p>
                        <a href="{{ route('rental.orders') }}" class="btn-primary sheen mt-5 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                            <i class="fa-solid fa-box-open text-xs"></i> Lihat Pesanan
                        </a>
                    </section>
                @endforelse
            </div>
        </div>

        {{-- Panel samping --}}
        <aside class="space-y-4 xl:sticky xl:top-24 xl:self-start">
            <section class="reveal card p-6 text-center" style="--d: 120ms">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-ink/40">Pratinjau Kondisi Bersih</p>
                <div class="relative mx-auto mt-5 flex h-20 w-20 items-center justify-center rounded-2xl border border-line/15 bg-canvas text-ink/30">
                    <i class="fa-regular fa-bell text-2xl"></i>
                    <span class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500 text-[10px] text-white">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>
                <h3 class="mt-4 font-serif text-lg text-ink">{{ $jumlah['belum'] === 0 ? 'Tidak Ada Notifikasi Baru' : $jumlah['belum'].' Notifikasi Menunggu' }}</h3>
                <p class="mx-auto mt-2 max-w-[15rem] text-[11px] leading-relaxed text-ink/45">
                    {{ $jumlah['belum'] === 0
                        ? 'Semua notifikasi sudah dibaca. Notifikasi sewa baru akan muncul otomatis di sini.'
                        : 'Periksa pesanan baru, jadwal pengembalian, dan stok alat sebelum menerima pendaki berikutnya.' }}
                </p>
                <div class="mt-4 flex items-center justify-center gap-2 border-t border-line/10 pt-3 text-[11px] font-semibold text-emerald-600">
                    <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Sinkronisasi real-time aktif
                </div>
            </section>

            <section class="reveal relative overflow-hidden rounded-2xl bg-ink p-6 text-white" style="--d: 160ms">
                <div class="orb pointer-events-none absolute -right-10 -top-10 h-32 w-32 bg-champagne/25"></div>
                <p class="relative text-[10px] font-bold uppercase tracking-[0.18em] text-white/45">SOP Penyiapan Alat</p>
                <p class="relative mt-3 text-[12px] leading-relaxed text-white/70">
                    Pastikan tenda, sleeping bag, dan kompor portable dicek fisik serta dibersihkan sebelum diserahkan kepada pendaki di pos kedatangan.
                </p>
                <div class="relative mt-5 flex items-center justify-between border-t border-white/10 pt-3 text-[11px]">
                    <span class="text-white/40">Pos Layanan:</span>
                    <span class="font-semibold">{{ $toko->lokasi_pos ?: 'Sembalun' }} &amp; Senaru</span>
                </div>
            </section>

            <section class="reveal rounded-2xl border border-amber-200/70 bg-amber-50/60 p-5" style="--d: 200ms">
                <div class="flex items-start gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-orange text-white">
                        <i class="fa-solid fa-headset text-xs"></i>
                    </span>
                    <div>
                        <p class="text-[12px] font-semibold text-ink">Kendala Verifikasi atau Sewa?</p>
                        <p class="mt-1 text-[11px] leading-relaxed text-ink/55">
                            Hubungi Helpdesk Operasional TNGR —
                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="font-semibold text-brand-orange hover:underline">WhatsApp Mitra</a>.
                        </p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@endsection
