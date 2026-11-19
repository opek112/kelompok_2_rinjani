@extends('layouts.rental')

@section('title', 'Bukti Pengembalian')
@section('subtitle', 'Ringkasan kondisi alat dan denda yang tercatat untuk pesanan ini.')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $nomorWa = '62'.ltrim(preg_replace('/\D/', '', (string) $pesanan->telepon_ketua), '0');
        $totalRusak = $pesanan->items->sum(fn ($item) => $item->pengembalian?->jumlah_rusak ?? 0);
        $totalHilang = $pesanan->items->sum(fn ($item) => $item->pengembalian?->jumlah_hilang ?? 0);
    @endphp

    <a href="{{ route('rental.returns') }}"
        class="reveal mb-5 inline-flex items-center gap-2 text-[12px] font-medium text-ink/55 transition hover:text-brand-orange">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Daftar Pengembalian
    </a>

    <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr] lg:items-start">
        <div class="space-y-6">
            <section class="reveal card overflow-hidden">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 border-b border-line/10 px-5 py-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink/55">{{ $pesanan->kode_pemesanan }}</span>
                    <span class="chip ml-auto bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span> Selesai
                    </span>
                </div>
                <div class="grid gap-5 p-5 sm:grid-cols-3">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Pemesan</p>
                        <p class="mt-1 text-[13px] font-semibold text-ink">{{ $pesanan->nama_ketua }}</p>
                        <p class="text-[11px] text-ink/45">{{ $pesanan->telepon_ketua ?: $pesanan->email_ketua }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Jadwal Sewa</p>
                        <p class="mt-1 text-[13px] font-semibold text-ink">{{ Tanggal::rentang($pesanan->tanggal_mulai, $pesanan->tanggal_selesai) }}</p>
                        <p class="text-[11px] text-ink/45">{{ $pesanan->total_hari }} hari</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Waktu Pencatatan</p>
                        <p class="mt-1 text-[13px] font-semibold text-ink">{{ $pesanan->waktu_pengembalian?->translatedFormat('d M Y, H:i') }} WIB</p>
                        <p class="text-[11px] text-ink/45">oleh {{ $toko->penanggung_jawab ?: auth()->user()->nama }}</p>
                    </div>
                </div>
            </section>

            <section class="reveal card overflow-hidden">
                <div class="border-b border-line/10 px-5 py-4">
                    <h2 class="font-serif text-lg text-ink">Kondisi Alat</h2>
                    <p class="mt-0.5 text-[12px] text-ink/45">Hasil pemeriksaan saat alat kembali ke toko.</p>
                </div>
                <div class="divide-y divide-line/12">
                    @foreach ($pesanan->items as $item)
                        @php
                            $kembali = $item->pengembalian;
                            $rusak = $kembali?->jumlah_rusak ?? 0;
                            $hilang = $kembali?->jumlah_hilang ?? 0;
                        @endphp
                        <div class="flex flex-wrap items-start gap-3 px-5 py-4">
                            <img src="{{ $item->peralatan?->fotoUtama() }}" alt="{{ $item->peralatan?->nama }}"
                                class="h-12 w-12 shrink-0 rounded-lg object-cover ring-1 ring-line/12" loading="lazy">
                            <div class="min-w-0 flex-1">
                                <p class="text-[13px] font-semibold text-ink">{{ $item->peralatan?->nama ?? 'Alat dihapus' }}</p>
                                <p class="text-[11px] text-ink/45">Jumlah disewa: {{ $item->jumlah }} unit</p>
                                @if ($kembali?->catatan)
                                    <p class="mt-1 text-[11px] text-ink/55"><i class="fa-solid fa-pen-to-square mr-1 text-ink/30"></i>{{ $kembali->catatan }}</p>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="chip bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">{{ $kembali?->jumlah_baik ?? 0 }} baik</span>
                                @if ($rusak > 0)
                                    <span class="chip bg-amber-50 text-amber-700 ring-1 ring-amber-100">{{ $rusak }} rusak</span>
                                @endif
                                @if ($hilang > 0)
                                    <span class="chip bg-red-50 text-red-600 ring-1 ring-red-100">{{ $hilang }} hilang</span>
                                @endif
                                <span class="w-24 text-right text-[12px] font-semibold text-ink">{{ Rupiah::format($kembali?->denda ?? 0) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between border-t border-line/10 bg-sand/40 px-5 py-4">
                    <span class="text-[12px] font-semibold uppercase tracking-[0.12em] text-ink/45">Total Denda</span>
                    <span class="text-lg font-semibold text-brand-orange">{{ Rupiah::format($pesanan->denda_total) }}</span>
                </div>
            </section>

            @if ($pesanan->catatan_pengembalian)
                <section class="reveal card p-5">
                    <h2 class="font-serif text-lg text-ink">Catatan Pengembalian</h2>
                    <p class="mt-2 text-[12px] leading-relaxed text-ink/55">{{ $pesanan->catatan_pengembalian }}</p>
                </section>
            @endif

            @if (! empty($pesanan->foto_pengembalian))
                <section class="reveal card p-5">
                    <h2 class="font-serif text-lg text-ink">Foto Bukti</h2>
                    <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        @foreach ($pesanan->foto_pengembalian as $foto)
                            <a href="{{ asset('storage/'.$foto) }}" target="_blank" rel="noopener"
                                class="aspect-square overflow-hidden rounded-xl border border-line/12">
                                <img src="{{ asset('storage/'.$foto) }}" alt="Foto bukti pengembalian"
                                    class="h-full w-full object-cover transition duration-500 hover:scale-105" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <aside class="space-y-4 lg:sticky lg:top-24">
            <section class="reveal card overflow-hidden">
                <div class="h-1 bg-gradient-to-r from-emerald-500 via-champagne to-brand-orange"></div>
                <div class="p-6 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                    <h2 class="mt-4 font-serif text-2xl text-ink">Pengembalian Berhasil Dicatat</h2>
                    <p class="mt-2 text-[12px] leading-relaxed text-ink/50">
                        Kondisi alat sudah tersimpan. Pesanan berubah menjadi <span class="font-semibold text-ink">Selesai</span> dan stok kembali tersedia.
                    </p>

                    <dl class="mt-5 space-y-2 rounded-xl border border-line/12 bg-sand/40 p-4 text-left text-[12px]">
                        <div class="flex justify-between gap-3">
                            <dt class="text-ink/45">Status akhir</dt>
                            <dd class="font-semibold text-ink">{{ $totalHilang > 0 ? $totalHilang.' hilang' : ($totalRusak > 0 ? $totalRusak.' rusak' : 'Semua baik') }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-ink/45">Total denda</dt>
                            <dd class="font-semibold text-brand-orange">{{ Rupiah::format($pesanan->denda_total) }}</dd>
                        </div>
                    </dl>

                    <a href="{{ route('rental.returns') }}"
                        class="btn-primary sheen mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar
                    </a>

                    @if ($pesanan->denda_total > 0)
                        <a href="https://wa.me/{{ $nomorWa }}?text={{ urlencode('Halo '.$pesanan->nama_ketua.', berikut rincian denda pengembalian pesanan '.$pesanan->kode_pemesanan.': '.Rupiah::format($pesanan->denda_total).'. Pembayaran dapat dilakukan tunai di basecamp atau melalui QRIS toko. Terima kasih.') }}"
                            target="_blank" rel="noopener"
                            class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-line/12 px-4 py-2.5 text-[12px] font-medium text-ink/70 transition hover:border-emerald-500/40 hover:text-emerald-700">
                            <i class="fa-brands fa-whatsapp"></i> Kirim Tagihan via WhatsApp
                        </a>
                    @endif
                </div>
            </section>

            <p class="reveal px-2 text-center text-[10px] leading-relaxed text-ink/35">
                <i class="fa-solid fa-shield-halved mr-1"></i>
                Catatan ini menjadi bukti resmi kondisi alat antara toko dan pemesan.
            </p>
        </aside>
    </div>
@endsection
