@extends('layouts.rental')

@section('title', $judul)
@section('subtitle', 'Halaman ini sedang disiapkan dan akan aktif pada tahap berikutnya.')

@section('content')
    <section class="reveal card relative overflow-hidden px-6 py-16 text-center">
        <div class="orb pointer-events-none absolute -right-16 -top-16 h-56 w-56 bg-champagne/25" data-parallax="0.06"></div>
        <div class="orb pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 bg-emerald-300/20" data-parallax="0.04"></div>

        <div class="relative z-10 mx-auto max-w-md">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-ink text-champagne shadow-lift">
                <i class="fa-solid {{ $ikon }} text-xl"></i>
            </div>
            <p class="mt-6 text-[10px] font-bold uppercase tracking-[0.24em] text-brand-orange">Segera Hadir</p>
            <h2 class="mt-2 font-serif text-3xl text-ink">{{ $judul }}</h2>
            <p class="mt-3 text-sm leading-relaxed text-ink/50">
                Modul ini belum diaktifkan pada tahap ini. Untuk sementara, semua kebutuhan operasional harian
                bisa diselesaikan dari Dashboard dan halaman Pesanan.
            </p>

            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('rental.dashboard') }}"
                    class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                    <i class="fa-solid fa-table-cells-large text-xs"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('rental.orders') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-line/22 px-5 py-2.5 text-sm font-medium text-ink/70 transition hover:border-ink/30 hover:text-ink">
                    <i class="fa-solid fa-box-open text-xs"></i> Lihat Pesanan
                </a>
            </div>
        </div>
    </section>
@endsection
