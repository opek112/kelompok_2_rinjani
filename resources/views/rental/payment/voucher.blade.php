@extends('layouts.flow')

@section('title', 'E-Voucher '.$kode.' — RinjaniGuide & Rental')

@section('header-right')
    <span class="hidden md:inline-flex items-center gap-2 bg-green-50 text-green-700 text-[11px] font-bold px-3 py-1.5 rounded-lg">
        <i class="fa-solid fa-circle-check"></i> Pembayaran Lunas
    </span>
@endsection

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $tautanVoucher = route('rental.voucher', $kode);
        $pesanWa = 'E-Voucher RinjaniGuide & Rental '.$kode.' — '.$tautanVoucher;
    @endphp

    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="text-center mb-6">
            <span class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-4 py-2 rounded-full">
                <i class="fa-solid fa-circle-check"></i> E-Voucher Terverifikasi Otomatis
            </span>
            <p class="text-xs text-green-700/80 mt-2 max-w-lg mx-auto">
                E-voucher aktif sejak pembayaran terverifikasi otomatis. Berlaku sebagai bukti sah reservasi SIMAKSI dan pengambilan alat.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100" id="kartu-voucher">
            <!-- Kepala voucher -->
            <div class="bg-brand-dark text-white px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-300 flex items-center gap-2">
                            <i class="fa-solid fa-mountain-sun text-brand-orange"></i> RINJANIGUIDE &amp; RENTAL
                        </p>
                        <h1 class="font-serif text-4xl font-bold mt-2 tracking-wide">E-VOUCHER</h1>
                        <p class="text-[11px] text-gray-300 mt-1">Taman Nasional Gunung Rinjani • Official Booking Pass</p>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="inline-flex items-center gap-1 bg-green-500/20 text-green-300 text-[10px] font-bold px-2.5 py-1 rounded-full">
                            <i class="fa-solid fa-circle text-[6px]"></i> VALID / RESMI
                        </span>
                        <p class="text-[9px] font-bold tracking-widest text-gray-400 mt-4">KODE VOUCHER</p>
                        <p class="bg-black/30 border border-white/10 rounded-lg px-3 py-1.5 font-bold text-sm mt-1">{{ $kode }}</p>
                    </div>
                </div>
            </div>

            <!-- QR -->
            <div class="px-6 py-7 text-center bg-white">
                <div class="w-48 h-48 mx-auto rounded-2xl border border-gray-200 p-3 relative">
                    @include('rental.payment.qr', ['kode' => $kode, 'warna' => 'bg-brand-dark'])
                    <span class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <span class="w-8 h-8 rounded-md bg-white flex items-center justify-center">
                            <i class="fa-solid fa-mountain-sun text-brand-orange"></i>
                        </span>
                    </span>
                </div>

                <div class="mt-4 inline-flex items-center gap-2 bg-green-600 text-white text-xs font-bold px-6 py-2 rounded-full">
                    <i class="fa-solid fa-circle-check"></i> LUNAS / VERIFIED
                </div>
                <p class="text-[11px] text-gray-500 mt-2">Tunjukkan QR ini ke pemandu dan pengelola rental di basecamp pos pendakian.</p>
            </div>

            <!-- Perforasi -->
            <div class="relative border-t-2 border-dashed border-gray-200 mx-6">
                <span class="absolute -left-9 -top-2.5 w-5 h-5 rounded-full bg-[#F6F5F1]"></span>
                <span class="absolute -right-9 -top-2.5 w-5 h-5 rounded-full bg-[#F6F5F1]"></span>
            </div>

            <!-- Data reservasi -->
            <div class="px-6 py-6">
                <h2 class="font-bold text-brand-dark flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-brand-orange"></i> Data Reservasi Utama
                </h2>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-3 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400">NAMA KETUA ROMBONGAN</p>
                        <p class="font-bold text-brand-dark mt-1 flex items-center gap-1.5">
                            <i class="fa-regular fa-user text-gray-400 text-xs"></i> {{ $pemesanan->nama_ketua }}
                        </p>
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded mt-1.5">
                            <i class="fa-solid fa-circle-check"></i> KTP Terverifikasi
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400">NO. WHATSAPP</p>
                        <p class="font-bold text-brand-dark mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-phone text-gray-400 text-xs"></i> {{ $pemesanan->telepon_ketua }}
                        </p>
                        <p class="text-[10px] text-gray-500 mt-1.5">Aktif untuk koordinasi grup</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400">TANGGAL PENDAKIAN</p>
                        <p class="font-bold text-brand-dark mt-1 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                            {{ Tanggal::rentang($pemesanan->tanggal_mulai, $pemesanan->tanggal_selesai) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400">TOTAL DURASI &amp; POS</p>
                        <p class="font-bold text-brand-dark mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-gray-400 text-xs"></i>
                            {{ $pemesanan->total_hari }} Hari / {{ max(1, $pemesanan->total_hari - 1) }} Malam
                            (Pos {{ $pemesanan->items->first()?->peralatan?->pos ?? 'Sembalun' }})
                        </p>
                    </div>
                    <div class="md:col-span-2 border-t border-gray-200 pt-3 flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-500">Total Biaya Lunas:</p>
                        <p class="font-bold text-brand-orange text-xl">{{ Rupiah::format($pembayaran->nominal) }}</p>
                    </div>
                </div>

                @if ($pemesanan->pemandu_id !== null)
                    <h2 class="font-bold text-brand-dark flex items-center gap-2 mt-6">
                        <i class="fa-solid fa-person-hiking text-brand-orange"></i> Pemandu Pendamping
                        <span class="ml-auto bg-green-100 text-green-700 text-[10px] font-bold px-2.5 py-1 rounded">Terjadwal</span>
                    </h2>
                    <div class="border border-gray-200 rounded-xl p-4 mt-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold text-brand-dark">{{ $pemesanan->pemandu?->user?->nama ?? 'Pemandu' }}</p>
                            <p class="text-[11px] text-gray-500 mt-1">
                                Lisensi {{ $pemesanan->pemandu?->nomor_lisensi ?: '-' }} · Jalur {{ $pemesanan->rute ?? '-' }}
                            </p>
                            <p class="text-[11px] text-gray-500">Meeting point: Basecamp {{ $pemesanan->rute ?? 'Sembalun' }} (07.00 WITA)</p>
                        </div>
                        <span class="bg-gray-50 border border-gray-200 text-brand-dark text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">{{ $pemesanan->total_hari }} Hari</span>
                    </div>
                @endif

                @if ($pemesanan->items->isNotEmpty())
                <!-- Peralatan -->
                <h2 class="font-bold text-brand-dark flex items-center gap-2 mt-6">
                    <i class="fa-solid fa-tent text-brand-orange"></i> Sewa Perlengkapan Outdoor
                    <span class="ml-auto bg-green-100 text-green-700 text-[10px] font-bold px-2.5 py-1 rounded">Siap Ambil</span>
                </h2>

                <div class="border border-gray-200 rounded-xl divide-y divide-gray-100 mt-3">
                    @foreach ($pemesanan->items as $item)
                        <div class="p-4 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-brand-dark flex items-center gap-2">
                                    <i class="fa-solid fa-tent text-gray-400 text-xs"></i> {{ $item->peralatan?->nama }}
                                </p>
                                <p class="text-[11px] text-gray-500 mt-1">Toko Rental Mitra: {{ $item->peralatan?->toko?->nama_toko }}</p>
                                <p class="text-[11px] text-gray-500">Pos Pengambilan: Pos Registrasi {{ $item->peralatan?->pos }} (Meja 3)</p>
                            </div>
                            <span class="bg-gray-50 border border-gray-200 text-brand-dark text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">{{ $item->jumlah }} Unit</span>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Barcode -->
            <div class="bg-gray-50 px-6 py-5 text-center border-t border-gray-100">
                <div class="h-12 w-56 mx-auto" style="background: repeating-linear-gradient(90deg, #1A3626 0 2px, transparent 2px 4px, #1A3626 4px 5px, transparent 5px 8px, #1A3626 8px 11px, transparent 11px 13px);"></div>
                <p class="text-[10px] text-gray-500 mt-3 max-w-sm mx-auto">
                    Data telah terkunci dan tidak dapat diubah • Hak cipta Balai TNGR &amp; RinjaniGuide &amp; Rental.
                </p>
            </div>
        </div>

        <!-- Aksi -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-5 no-print">
            <button type="button" onclick="window.print()" class="w-full sm:w-auto bg-brand-orange text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-download"></i> Unduh Voucher
            </button>
            <a href="https://wa.me/?text={{ urlencode($pesanWa) }}" target="_blank" rel="noopener"
                class="w-full sm:w-auto bg-white border border-gray-300 text-brand-dark px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp text-green-600"></i> Bagikan via WA
            </a>
            <button type="button" onclick="salinTautan()" class="w-12 h-12 bg-white border border-gray-300 rounded-xl flex items-center justify-center text-gray-600 hover:bg-gray-50" title="Salin tautan voucher">
                <i class="fa-regular fa-copy"></i>
            </button>
        </div>

        <p class="text-xs text-gray-500 text-center mt-4">
            <i class="fa-regular fa-life-ring"></i> Perlu bantuan di basecamp? Hubungi Tim Hotline Pos Sembalun:
            <span class="font-semibold text-brand-dark">+62 812-3456-7890</span>
        </p>
    </div>
@endsection

@push('scripts')
    <script>
        function salinTautan() {
            navigator.clipboard.writeText(@js($tautanVoucher)).then(function () {
                alert('Tautan e-voucher disalin.');
            });
        }
    </script>
@endpush
