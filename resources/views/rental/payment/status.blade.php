@extends('layouts.flow')

@section('title', 'Status Pembayaran '.$kode.' — RinjaniGuide & Rental')
@section('back', $state === 'expired' ? 'Kembali ke Beranda' : 'Kembali ke Keranjang')
@section('back-url', $state === 'expired' ? route('home') : route('rental.cart'))

@section('header-right')
    <span class="hidden lg:inline-flex items-center gap-2 bg-gray-100 text-gray-600 text-[11px] font-medium px-3 py-1.5 rounded-lg">
        <i class="fa-solid fa-lock"></i> 256-Bit Encrypted
    </span>
@endsection

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $subtotalAlat = $pemesanan->items->sum('subtotal');
        $biayaPemandu = (float) ($pemesanan->biaya_pemandu_snapshot ?? 0);
        $isPemandu = $pemesanan->pemandu_id !== null;
        $biayaLayanan = max(0, $pembayaran->nominal - $subtotalAlat - $biayaPemandu);
        $jumlahUnit = $pemesanan->items->sum('jumlah');
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-8">
            <div>
                <span class="inline-flex items-center gap-2 bg-brand-dark text-white text-[10px] font-bold tracking-wider px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-circle-check"></i> GERBANG PEMBAYARAN RESMI TNGR
                </span>
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-brand-dark mt-4">Status &amp; Gateway Pembayaran QRIS</h1>
                <p class="text-gray-500 mt-2 max-w-2xl">
                    Simulasi visual alur transaksi ekspedisi Gunung Rinjani dengan verifikasi instan lintas platform e-wallet &amp; perbankan nasional.
                </p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 text-right shrink-0">
                <p class="text-xs font-bold text-brand-dark flex items-center justify-end gap-1"><i class="fa-solid fa-lock text-green-600"></i> 256-Bit Encrypted</p>
                <p class="text-[10px] text-gray-500">Bank Indonesia &amp; ASPI Compliant</p>
            </div>
        </div>

        @if (session('error'))
            <div class="max-w-md mx-auto bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="max-w-md mx-auto"
            @if ($state !== 'expired')
                x-data="hitungMundur({{ $sisaDetik }}, {{ $state === 'waiting' ? 120 : 0 }})" x-init="mulai()"
            @endif
        >
            <div class="bg-white rounded-2xl border {{ $state === 'critical' ? 'border-yellow-400 ring-2 ring-yellow-100' : 'border-gray-200' }} shadow-sm overflow-hidden">

                <!-- Langkah -->
                <div class="flex items-center justify-between text-[11px] font-semibold px-5 py-4 border-b border-gray-100">
                    <span class="flex items-center gap-1.5 {{ $state === 'expired' ? 'text-gray-400' : 'text-brand-dark' }}">
                        <i class="fa-solid fa-circle-check {{ $state === 'expired' ? 'text-gray-300' : 'text-green-600' }}"></i> Data Pemesanan
                    </span>
                    <span class="flex-1 h-px mx-2 {{ $state === 'expired' ? 'bg-gray-200' : ($state === 'critical' ? 'bg-red-200' : 'bg-green-200') }}"></span>
                    @if ($state === 'expired')
                        <span class="flex items-center gap-1.5 text-gray-400"><i class="fa-solid fa-circle-xmark"></i> Dibatalkan</span>
                    @else
                        <span class="flex items-center gap-1.5 {{ $state === 'critical' ? 'text-red-600' : 'text-brand-orange' }}">
                            <span class="w-5 h-5 rounded-full {{ $state === 'critical' ? 'bg-red-600' : 'bg-brand-orange' }} text-white flex items-center justify-center text-[10px]">2</span> Pembayaran
                        </span>
                    @endif
                </div>

                <div class="p-5 space-y-4">
                    @if ($state === 'critical')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 text-xs text-yellow-900">
                            <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-yellow-600"></i> Waktu hampir habis! Segera selesaikan pembayaran sebelum transaksi otomatis dibatalkan sistem.</p>
                        </div>
                    @endif

                    <!-- Kode & hitung mundur -->
                    <div class="rounded-xl border p-4 {{ $state === 'expired' ? 'bg-gray-50 border-gray-200' : ($state === 'critical' ? 'bg-red-50 border-red-200' : 'bg-green-50/70 border-green-200') }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold tracking-widest text-gray-500">KODE PESANAN</p>
                                <p class="font-bold text-brand-dark">{{ $kode }}</p>
                            </div>
                            @if ($state === 'waiting')
                                <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2.5 py-1 rounded-full"><i class="fa-solid fa-clock"></i> Menunggu Pembayaran</span>
                            @elseif ($state === 'critical')
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-bold px-2.5 py-1 rounded-full"><i class="fa-solid fa-circle-exclamation"></i> Segera Kedaluwarsa</span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-200 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-full"><i class="fa-solid fa-clock-rotate-left"></i> Kedaluwarsa</span>
                            @endif
                        </div>

                        <p class="text-4xl font-bold mt-3 tabular-nums {{ $state === 'expired' ? 'text-gray-400' : ($state === 'critical' ? 'text-red-600' : 'text-brand-dark') }}"
                            @if ($state !== 'expired') x-text="teks" @endif>
                            {{ sprintf('%02d:%02d', intdiv($sisaDetik, 60), $sisaDetik % 60) }}
                        </p>
                        <p class="text-[11px] mt-1 {{ $state === 'expired' ? 'text-gray-400' : 'text-gray-600' }}">
                            @if ($state === 'expired')
                                Batas waktu reservasi telah berakhir
                            @elseif ($state === 'critical')
                                Sisa waktu kritis pembayaran
                            @else
                                Sisa waktu pembayaran tiket &amp; perlengkapan
                            @endif
                        </p>

                        <div class="h-1.5 rounded-full mt-3 overflow-hidden {{ $state === 'expired' ? 'bg-gray-200' : ($state === 'critical' ? 'bg-red-100' : 'bg-green-100') }}">
                            @if ($state === 'expired')
                                <div class="h-full w-0 bg-gray-300"></div>
                            @else
                                <div class="h-full {{ $state === 'critical' ? 'bg-red-500' : 'bg-brand-orange' }}" :style="'width: ' + persen + '%'"></div>
                            @endif
                        </div>
                    </div>

                    @if ($state === 'expired')
                        <!-- State 3: kedaluwarsa -->
                        <div class="bg-brand-dark rounded-xl p-8 text-center text-white">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-hourglass-end text-brand-orange text-xl"></i>
                            </div>
                            <h2 class="font-serif text-xl font-bold">Waktu Pembayaran Habis</h2>
                            <p class="text-sm text-gray-300 mt-2">
                                Pesanan Anda dibatalkan otomatis oleh sistem TNGR karena melewati batas waktu 15 menit.
                            </p>
                            <a href="{{ route('rental') }}" class="inline-flex items-center justify-center gap-2 bg-brand-orange text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition mt-5 w-full">
                                <i class="fa-solid fa-rotate-right"></i> Buat Pesanan Baru
                            </a>
                        </div>

                        <div class="border border-gray-200 rounded-xl p-4 text-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-[10px] font-bold tracking-widest text-gray-400">STATUS DOKUMEN</p>
                                <span class="text-xs font-bold text-red-500">Tagihan Tidak Berlaku</span>
                            </div>
                            <div class="mt-3 space-y-2 text-gray-400 line-through">
                                <div class="flex justify-between">
                                    <span>Jasa Pendakian &amp; Sewa Alat</span>
                                    <span>{{ Rupiah::format($pembayaran->nominal) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total Pembayaran</span>
                                    <span>{{ Rupiah::format($pembayaran->nominal) }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('home') }}" class="w-full border border-gray-300 text-brand-dark py-3 rounded-xl font-semibold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                        </a>

                        <p class="text-[11px] text-gray-500 flex items-start gap-2">
                            <i class="fa-regular fa-clipboard mt-0.5"></i>
                            Slot pemandu &amp; kuota alat telah dikembalikan ke sistem reservasi publik Taman Nasional Gunung Rinjani.
                        </p>
                    @else
                        <!-- State 1 & 2: QR aktif -->
                        <div class="border border-gray-200 rounded-xl p-4 text-center">
                            <p class="font-bold text-brand-dark text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-qrcode {{ $state === 'critical' ? 'text-red-500' : 'text-brand-dark' }}"></i> Scan untuk Bayar
                            </p>
                            <p class="text-[11px] text-gray-500 mt-1">
                                @if ($state === 'critical')
                                    <span class="text-red-600 font-semibold">QR berlaku &lt; 2 Menit</span> — segera konfirmasi nominal sebelum kode kedaluwarsa.
                                @else
                                    Buka aplikasi bank atau e-wallet apa pun yang mendukung QRIS, lalu scan kode di bawah.
                                @endif
                            </p>

                            <div class="mt-4 mx-auto w-56 h-56 rounded-xl border-4 {{ $state === 'critical' ? 'border-red-500' : 'border-gray-200' }} p-3 relative bg-white">
                                @include('rental.payment.qr', ['kode' => $kode, 'warna' => 'bg-brand-dark'])
                                <span class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <span class="bg-white border {{ $state === 'critical' ? 'border-red-500 text-red-600' : 'border-brand-dark text-brand-dark' }} text-[9px] font-bold px-1.5 py-0.5 rounded">QRIS</span>
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-4 text-xs font-semibold">
                                <button type="button" onclick="window.print()" class="border border-gray-200 rounded-lg py-2 text-gray-700 hover:bg-gray-50 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-download"></i> Unduh QR
                                </button>
                                <button type="button" data-nominal="{{ Rupiah::format($pembayaran->nominal) }}" onclick="salinNominal(this)"
                                    class="border border-gray-200 rounded-lg py-2 text-gray-700 hover:bg-gray-50 flex items-center justify-center gap-1.5">
                                    <i class="fa-regular fa-copy"></i> Salin Nominal
                                </button>
                            </div>

                            <div class="border-t border-gray-100 mt-4 pt-3">
                                <p class="text-[9px] font-bold tracking-widest text-gray-400">DIDUKUNG APLIKASI PEMBAYARAN</p>
                                <div class="flex flex-wrap justify-center gap-1.5 mt-2">
                                    @foreach (['BCA', 'Mandiri', 'BRI', 'GoPay', 'OVO', 'DANA'] as $aplikasi)
                                        <span class="bg-gray-100 text-gray-600 text-[10px] font-semibold px-2 py-1 rounded">{{ $aplikasi }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Rincian -->
                        <div class="border border-gray-200 rounded-xl p-4 text-sm space-y-2">
                            @if ($isPemandu)
                                <div class="flex justify-between gap-3 text-gray-600">
                                    <span class="min-w-0">
                                        <span class="block truncate">Jasa Pemandu ({{ $pemesanan->pemandu?->user?->nama ?? 'Pemandu' }})</span>
                                        <span class="text-[10px] text-gray-400">{{ $pemesanan->total_hari }} hari · jalur {{ $pemesanan->rute ?? '-' }}</span>
                                    </span>
                                    <span class="font-semibold text-brand-dark whitespace-nowrap">{{ Rupiah::format($biayaPemandu) }}</span>
                                </div>
                            @else
                                @foreach ($pemesanan->items as $item)
                                    <div class="flex justify-between gap-3 text-gray-600">
                                        <span class="min-w-0">
                                            <span class="block truncate">Sewa Alat ({{ $item->peralatan?->nama }})</span>
                                            <span class="text-[10px] text-gray-400">{{ $item->jumlah }} unit × {{ $pemesanan->total_hari }} hari</span>
                                        </span>
                                        <span class="font-semibold text-brand-dark whitespace-nowrap">{{ Rupiah::format($item->subtotal) }}</span>
                                    </div>
                                @endforeach
                            @endif
                            @if ($biayaLayanan > 0)
                                <div class="flex justify-between text-gray-600">
                                    <span>Biaya Layanan TNGR Protection</span>
                                    <span class="font-semibold text-brand-dark">{{ Rupiah::format($biayaLayanan) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-1">
                                <span class="font-bold text-brand-dark">Total Pembayaran</span>
                                <span class="font-bold text-brand-orange text-xl">{{ Rupiah::format($pembayaran->nominal) }}</span>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-500 pt-1">
                                <span>Metode Pembayaran</span>
                                <span>QRIS Dinamis (Otomatis)</span>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-500">
                                <span>Berlaku Hingga</span>
                                <span>{{ $pembayaran->kedaluwarsa_pada->format('H:i') }} WIB ({{ Tanggal::panjang($pembayaran->kedaluwarsa_pada) }})</span>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-500">
                                <span>{{ $isPemandu ? 'Durasi Pendampingan' : 'Jumlah Unit Disewa' }}</span>
                                <span>{{ $isPemandu ? $pemesanan->total_hari.' hari' : $jumlahUnit.' unit · '.$pemesanan->total_hari.' hari' }}</span>
                            </div>
                        </div>

                        <form action="{{ route('rental.payment.confirm', $kode) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition
                                {{ $state === 'critical' ? 'bg-brand-dark text-white hover:bg-brand-green' : 'border border-brand-dark text-brand-dark hover:bg-gray-50' }}">
                                <i class="fa-solid fa-circle-check"></i>
                                Saya Sudah Bayar
                                @if ($state === 'critical')
                                    <span class="tabular-nums" x-text="'(' + teks + ')'"></span>
                                @endif
                            </button>
                        </form>

                        <form action="{{ route('rental.payment.cancel', $kode) }}" method="POST"
                            onsubmit="return confirm('Batalkan pesanan {{ $kode }}? Slot alat akan dikembalikan ke sistem.')">
                            @csrf
                            <button type="submit" class="w-full text-center text-xs font-semibold text-red-500 hover:text-red-600 py-1">
                                Batalkan Pesanan
                            </button>
                        </form>

                        <p class="text-[10px] text-gray-500 text-center flex items-start justify-center gap-1.5">
                            <i class="fa-regular fa-circle-question mt-0.5"></i>
                            Pembayaran diverifikasi otomatis oleh server bank. E-voucher resmi pendakian dikirim setelah status lunas.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Catatan bawah -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
            @foreach ([
                ['fa-solid fa-headset', 'Kendala Pembayaran?', 'Tim Pos Sembalun dan Senaru siap membantu konfirmasi manual melalui WhatsApp resmi 24/7.'],
                ['fa-solid fa-ticket', 'Bukti Masuk TNGR Sah', 'QRIS terhubung ke sistem e-Tiket Simaksi resmi Kementerian Lingkungan Hidup & Kehutanan.'],
                ['fa-solid fa-shield-halved', 'Garansi Peralatan Bersih', 'Peralatan sewa yang telah dibayar diterbitkan dan disiapkan di pos briefing 4 jam sebelum pendakian.'],
            ] as [$ikon, $judul, $isi])
                <div class="flex items-start gap-3">
                    <i class="{{ $ikon }} text-brand-dark mt-1"></i>
                    <div>
                        <p class="font-bold text-brand-dark text-sm">{{ $judul }}</p>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $isi }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    @if ($state !== 'expired')
        <script>
            function salinNominal(tombol) {
                navigator.clipboard.writeText(tombol.dataset.nominal).then(function () {
                    const teksAwal = tombol.innerHTML;
                    tombol.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin';
                    setTimeout(() => { tombol.innerHTML = teksAwal; }, 2000);
                });
            }

            function hitungMundur(sisaDetik, ambang) {
                return {
                    sisa: sisaDetik,
                    get menit() { return String(Math.floor(this.sisa / 60)).padStart(2, '0'); },
                    get detik() { return String(this.sisa % 60).padStart(2, '0'); },
                    get teks() { return this.menit + ':' + this.detik; },
                    get persen() { return Math.max(0, Math.min(100, (this.sisa / 900) * 100)); },
                    mulai() {
                        const jam = setInterval(() => {
                            this.sisa = Math.max(0, this.sisa - 1);

                            if (this.sisa === 0 || (ambang > 0 && this.sisa === ambang)) {
                                clearInterval(jam);
                                window.location.reload();
                            }
                        }, 1000);
                    },
                };
            }
        </script>
    @endif
@endpush
