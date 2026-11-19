@extends('layouts.rental')

@section('title', 'Rekap Pendapatan')
@section('subtitle', 'Laporan keuangan dan pergerakan stok inventaris '.$toko->nama_toko.'.')

@php
    use Modules\Rental\Support\Rupiah;

    $ringkas = function (float $nilai): string {
        if ($nilai >= 1_000_000) {
            return 'Rp '.number_format($nilai / 1_000_000, 1, ',', '.').'jt';
        }

        if ($nilai >= 1_000) {
            return 'Rp '.number_format($nilai / 1_000, 0, ',', '.').'rb';
        }

        return $nilai > 0 ? Rupiah::format($nilai) : '—';
    };
@endphp

@section('content')
    {{-- Ringkasan --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <section class="reveal card stat-card card-lift p-6" style="--d: 0ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-ink/45">Pendapatan Kotor</p>
                    <p class="mt-3 font-serif text-3xl text-ink">{{ Rupiah::format($laporan['kotor']) }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-brand-orange">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </span>
            </div>
            <p class="mt-4 flex items-center gap-2 text-[11px] text-ink/45">
                <i class="fa-regular fa-calendar"></i> {{ $laporan['awal']->translatedFormat('F Y') }}
            </p>
        </section>

        <section class="reveal card stat-card card-lift p-6" style="--d: 60ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-ink/45">Komisi Platform ({{ rtrim(rtrim(number_format($laporan['persenKomisi'], 1, ',', '.'), '0'), ',') }}%)</p>
                    <p class="mt-3 font-serif text-3xl text-ink">{{ Rupiah::format($laporan['komisi']) }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-500">
                    <i class="fa-solid fa-percent"></i>
                </span>
            </div>
            <p class="mt-4 flex items-center gap-2 text-[11px] text-ink/45">
                <i class="fa-regular fa-clock"></i> Dipotong otomatis per transaksi
            </p>
        </section>

        <section class="reveal relative overflow-hidden rounded-2xl border border-brand-orange/45 bg-panel/94 p-6 shadow-soft sm:col-span-2 xl:col-span-1" style="--d: 120ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-ink/45">Pendapatan Bersih</p>
                    <p class="mt-3 font-serif text-3xl text-brand-orange">{{ Rupiah::format($laporan['bersih']) }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-brand-orange">
                    <i class="fa-solid fa-wallet"></i>
                </span>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2 text-[11px]">
                <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-700">
                    <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Siap Dicairkan
                </span>
                <a href="{{ route('rental.reports.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="font-semibold text-ink/55 underline decoration-dotted transition hover:text-brand-orange">Unduh</a>
            </div>
        </section>
    </div>

    {{-- Filter periode --}}
    <section class="reveal card mt-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center" style="--d: 160ms">
        <form action="{{ route('rental.reports') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <span class="flex items-center gap-2 text-[12px] font-semibold text-ink/55">
                <i class="fa-solid fa-calendar-days"></i> Periode:
            </span>
            <select name="bulan" onchange="this.form.submit()" class="field w-auto min-w-[9rem] py-2">
                @foreach ($daftarBulan as $nilai => $nama)
                    <option value="{{ $nilai }}" @selected((int) $bulan === (int) $nilai)>{{ $nama }}</option>
                @endforeach
            </select>
            <select name="tahun" onchange="this.form.submit()" class="field w-auto min-w-[6rem] py-2">
                @foreach ($daftarTahun as $tahunPilihan)
                    <option value="{{ $tahunPilihan }}" @selected((int) $tahun === (int) $tahunPilihan)>{{ $tahunPilihan }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-line/22 px-4 py-2 text-[12px] font-semibold text-ink/70 transition hover:border-ink/35 hover:text-ink">
                <i class="fa-solid fa-check text-[11px]"></i> Terapkan
            </button>
        </form>

        <a href="{{ route('rental.reports.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
            class="btn-primary sheen inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white sm:ml-auto">
            <i class="fa-solid fa-download text-xs"></i> Unduh Laporan
        </a>
    </section>

    {{-- Grafik 6 bulan --}}
    <section class="reveal card mt-6 p-6 sm:p-8" style="--d: 200ms">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h3 class="font-serif text-xl text-ink">Pendapatan 6 Bulan Terakhir</h3>
                <p class="mt-1 text-[12px] text-ink/50">Total pendapatan bersih per bulan.</p>
            </div>
            <div class="flex items-center gap-4 text-[11px] text-ink/50">
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-sm bg-moss/80"></span> Bulan Lalu</span>
                <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-sm bg-brand-orange"></span> Bulan Berjalan</span>
            </div>
        </div>

        <div class="mt-8 flex h-64 items-end gap-3 sm:gap-6">
            @foreach ($laporan['grafik'] as $titik)
                <div class="group flex flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-[10px] font-semibold {{ $titik['aktif'] ? 'text-brand-orange' : 'text-ink/55' }}">
                        {{ $ringkas((float) $titik['nilai']) }}
                    </span>
                    <div class="relative flex w-full max-w-[56px] items-end justify-center" style="height: 100%">
                        <div class="w-full rounded-t-lg transition-all duration-700 ease-out {{ $titik['aktif'] ? 'bg-brand-orange shadow-[0_14px_30px_-16px_rgba(242,122,33,.9)]' : 'bg-moss/80 group-hover:bg-moss' }}"
                            style="height: {{ $titik['tinggi'] }}%"></div>
                    </div>
                    <span class="text-[10px] {{ $titik['aktif'] ? 'font-bold text-brand-orange' : 'text-ink/45' }}">{{ $titik['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-2 border-t border-line/10 pt-4 text-[11px] text-ink/45">
            <span class="inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-trend-up text-emerald-600"></i>
                @if ($laporan['pertumbuhan'] === null)
                    Belum ada pembanding bulan sebelumnya.
                @else
                    Pertumbuhan bulan ini {{ $laporan['pertumbuhan'] >= 0 ? '+' : '' }}{{ number_format($laporan['pertumbuhan'], 1, ',', '.') }}% dibanding bulan lalu.
                @endif
            </span>
            <span>Tertinggi: {{ $laporan['tertinggi']['label'] }} ({{ Rupiah::format($laporan['tertinggi']['nilai']) }})</span>
        </div>
    </section>

    {{-- Mutasi inventaris --}}
    <section class="reveal card mt-6 overflow-hidden" style="--d: 240ms">
        <div class="flex flex-wrap items-center justify-between gap-3 p-6 sm:p-8 sm:pb-4">
            <div>
                <h3 class="font-serif text-xl text-ink">Mutasi Inventaris</h3>
                <p class="mt-1 text-[12px] text-ink/50">Pergerakan stok alat keluar–masuk.</p>
            </div>
            <a href="{{ route('rental.catalog') }}" class="inline-flex items-center gap-2 rounded-xl border border-line/20 px-4 py-2 text-[12px] font-medium text-ink/65 transition hover:border-ink/35 hover:text-ink">
                <i class="fa-solid fa-tags text-[11px]"></i> Lihat Katalog
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-[12px]">
                <thead>
                    <tr class="border-b border-line/10 text-[10px] uppercase tracking-[0.12em] text-ink/40">
                        <th class="px-6 py-3 font-semibold sm:px-8">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Nama Alat</th>
                        <th class="px-4 py-3 font-semibold">Jenis Mutasi</th>
                        <th class="px-4 py-3 font-semibold">Jumlah</th>
                        <th class="px-4 py-3 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan['mutasi'] as $mutasi)
                        <tr class="row-hover border-b border-line/5">
                            <td class="px-6 py-3 text-ink/60 sm:px-8">{{ \Illuminate\Support\Carbon::parse($mutasi['tanggal'])->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 font-medium text-ink/80">{{ $mutasi['nama'] }}</td>
                            <td class="px-4 py-3">
                                <span class="chip {{ $mutasi['tone'] === 'emerald' ? 'bg-emerald-50 text-emerald-700' : ($mutasi['tone'] === 'amber' ? 'bg-amber-50 text-amber-700' : ($mutasi['tone'] === 'red' ? 'bg-red-50 text-red-600' : 'bg-orange-50 text-brand-orange')) }}">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span> {{ $mutasi['jenis'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-ink/75">{{ $mutasi['jumlah'] }} unit</td>
                            <td class="px-4 py-3 text-ink/50">{{ $mutasi['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-ink/45 sm:px-8">
                                <i class="fa-solid fa-boxes-stacked mb-2 block text-xl text-ink/25"></i>
                                Belum ada mutasi inventaris pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Riwayat pendapatan --}}
    <section class="reveal card mt-6 overflow-hidden" style="--d: 280ms">
        <div class="p-6 sm:p-8 sm:pb-4">
            <h3 class="font-serif text-xl text-ink">Riwayat Pendapatan</h3>
            <p class="mt-1 text-[12px] text-ink/50">Rincian pendapatan per pesanan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-left text-[12px]">
                <thead>
                    <tr class="border-b border-line/10 text-[10px] uppercase tracking-[0.12em] text-ink/40">
                        <th class="px-6 py-3 font-semibold sm:px-8">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Kode Pesanan</th>
                        <th class="px-4 py-3 font-semibold">Pemesan</th>
                        <th class="px-4 py-3 font-semibold">Alat Disewa</th>
                        <th class="px-4 py-3 font-semibold">Pendapatan Kotor</th>
                        <th class="px-4 py-3 font-semibold">Komisi</th>
                        <th class="px-4 py-3 pr-6 font-semibold sm:pr-8">Pendapatan Bersih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan['riwayat'] as $baris)
                        <tr class="row-hover border-b border-line/5">
                            <td class="px-6 py-3 text-ink/60 sm:px-8">
                                {{ \Illuminate\Support\Carbon::parse($baris['mulai'])->translatedFormat('d') }}–{{ \Illuminate\Support\Carbon::parse($baris['selesai'])->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="chip bg-sand text-ink/70">{{ $baris['kode'] }}</span>
                            </td>
                            <td class="px-4 py-3 font-medium text-ink/80">{{ $baris['pemesan'] }}</td>
                            <td class="px-4 py-3 text-ink/60">{{ $baris['unit'] }} unit</td>
                            <td class="px-4 py-3 text-ink/70">{{ Rupiah::format($baris['kotor']) }}</td>
                            <td class="px-4 py-3 text-ink/45">{{ Rupiah::format($baris['komisi']) }}</td>
                            <td class="px-4 py-3 pr-6 font-semibold text-ink sm:pr-8">{{ Rupiah::format($baris['bersih']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-ink/45 sm:px-8">
                                <i class="fa-regular fa-file-lines mb-2 block text-xl text-ink/25"></i>
                                Belum ada pendapatan tercatat pada {{ $laporan['awal']->translatedFormat('F Y') }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($laporan['riwayat']->isNotEmpty())
                    <tfoot>
                        <tr class="bg-sand/60 text-[12px] font-semibold">
                            <td colspan="4" class="px-6 py-3 text-ink/60 sm:px-8">Total periode</td>
                            <td class="px-4 py-3 text-ink/80">{{ Rupiah::format($laporan['kotor']) }}</td>
                            <td class="px-4 py-3 text-ink/45">{{ Rupiah::format($laporan['komisi']) }}</td>
                            <td class="px-4 py-3 pr-6 text-brand-orange sm:pr-8">{{ Rupiah::format($laporan['bersih']) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>
@endsection
