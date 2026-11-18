@extends('layouts.app')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;
    @endphp

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-serif font-bold text-brand-dark">Keranjang Pemesanan</h1>
                    <p class="text-gray-500 mt-2 max-w-xl">
                        Periksa kembali pesanan Anda sebelum checkout. Pastikan ketersediaan jadwal serta penjemputan alat sudah sesuai.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 shrink-0">
                    <p class="text-[10px] font-bold tracking-widest text-brand-orange">PROSES RESERVASI</p>
                    <div class="flex items-center gap-3 mt-2 text-sm">
                        <span class="flex items-center gap-2 font-semibold text-brand-dark">
                            <span class="w-6 h-6 rounded-full bg-brand-dark text-white text-[11px] flex items-center justify-center">1</span> Keranjang
                        </span>
                        <i class="fa-solid fa-arrow-right text-[10px] text-gray-400"></i>
                        <span class="flex items-center gap-2 text-gray-400">
                            <span class="w-6 h-6 rounded-full bg-gray-100 text-[11px] flex items-center justify-center">2</span> Data Pemesanan
                        </span>
                        <i class="fa-solid fa-arrow-right text-[10px] text-gray-400"></i>
                        <span class="flex items-center gap-2 text-gray-400">
                            <span class="w-6 h-6 rounded-full bg-gray-100 text-[11px] flex items-center justify-center">3</span> QRIS
                        </span>
                    </div>
                </div>
            </div>

            @if ($items->isEmpty())
                <div class="bg-white border border-gray-200 rounded-2xl p-14 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto text-2xl text-gray-400">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h2 class="text-xl font-bold text-brand-dark mt-5">Keranjang masih kosong</h2>
                    <p class="text-sm text-gray-500 mt-2">Pilih alat outdoor yang ingin disewa dari katalog rental.</p>
                    <a href="{{ route('rental') }}" class="inline-flex items-center gap-2 bg-brand-orange text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition mt-6">
                        <i class="fa-solid fa-tent"></i> Lihat Katalog Rental
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-5">
                        <!-- Jadwal sewa -->
                        <div class="bg-white border border-gray-200 rounded-2xl">
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h2 class="font-bold text-brand-dark flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days text-brand-orange"></i> Jadwal Sewa
                                </h2>
                                <span class="text-xs text-gray-500">{{ Tanggal::rentang($mulai, $selesai) }} · {{ $durasi }} Hari</span>
                            </div>
                            <form action="{{ route('rental.cart.dates') }}" method="POST" class="p-5 grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ $mulai->toDateString() }}" min="{{ now()->toDateString() }}"
                                        class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" value="{{ $selesai->toDateString() }}" min="{{ now()->toDateString() }}"
                                        class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                </div>
                                <button type="submit" class="border border-brand-dark text-brand-dark px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-brand-dark hover:text-white transition">
                                    Perbarui Jadwal
                                </button>
                            </form>
                        </div>

                        <!-- Alat sewa -->
                        <div class="bg-white border border-gray-200 rounded-2xl">
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h2 class="font-bold text-brand-dark flex items-center gap-2">
                                    <i class="fa-solid fa-tent text-brand-orange"></i> Alat Sewa
                                    <span class="text-[11px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $items->count() }} Item, {{ $items->sum('jumlah') }} Unit</span>
                                </h2>
                                <span class="text-xs text-green-700 font-semibold"><i class="fa-solid fa-circle-check"></i> Standar Bersih & Steril</span>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @foreach ($items as $item)
                                    @php $alat = $item['peralatan']; @endphp
                                    <div class="p-5 flex flex-col md:flex-row gap-4">
                                        <a href="{{ route('rental.detail', $alat) }}" class="w-full md:w-24 h-24 rounded-xl overflow-hidden shrink-0 block">
                                            <img src="{{ $alat->fotoUtama() }}" alt="{{ $alat->nama }}" class="w-full h-full object-cover">
                                        </a>

                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <h3 class="font-bold text-brand-dark">
                                                        <a href="{{ route('rental.detail', $alat) }}" class="hover:text-brand-orange transition">{{ $alat->nama }}</a>
                                                    </h3>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $alat->toko?->nama_toko }}
                                                        <span class="inline-flex items-center gap-1 text-green-700 font-semibold ml-1"><i class="fa-solid fa-circle-check"></i> Terverifikasi Mitra TNGR</span>
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-location-dot mr-1"></i> Titik Ambil: {{ $alat->pos }}</p>
                                                    <p class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i> Durasi Sewa: {{ Tanggal::rentang($mulai, $selesai) }} ({{ $durasi }} Hari)</p>
                                                    <p class="text-xs text-gray-500">Tarif Sewa: {{ Rupiah::format($alat->tarif_harian) }} / unit / hari</p>
                                                </div>

                                                <div class="flex items-center gap-2 shrink-0">
                                                    <a href="{{ route('rental.detail', $alat) }}" class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-brand-orange" title="Ubah di halaman detail">
                                                        <i class="fa-solid fa-pen text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('rental.cart.destroy', $alat) }}" method="POST"
                                                        onsubmit="return confirm('Hapus {{ $alat->nama }} dari keranjang?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-red-500 hover:bg-red-50" title="Hapus">
                                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-3 border-t border-gray-100">
                                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                                    <form action="{{ route('rental.cart.update', $alat) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="jumlah" value="{{ max(1, $item['jumlah'] - 1) }}">
                                                        <button type="submit" class="w-9 h-9 text-gray-600 hover:bg-gray-50" @disabled($item['jumlah'] <= 1)>−</button>
                                                    </form>
                                                    <span class="w-10 text-center text-sm font-bold text-brand-dark border-x border-gray-200 py-2">{{ $item['jumlah'] }}</span>
                                                    <form action="{{ route('rental.cart.update', $alat) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="jumlah" value="{{ min($alat->jumlah_stok, $item['jumlah'] + 1) }}">
                                                        <button type="submit" class="w-9 h-9 text-gray-600 hover:bg-gray-50" @disabled($item['jumlah'] >= $alat->jumlah_stok)>+</button>
                                                    </form>
                                                </div>

                                                <div class="ml-auto text-right">
                                                    <p class="text-[11px] text-gray-500">{{ $item['jumlah'] }} unit × {{ $durasi }} hari × {{ Rupiah::format($alat->tarif_harian) }}</p>
                                                    <p class="font-bold text-brand-orange text-lg">{{ Rupiah::format($item['subtotal']) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('rental') }}"
                            class="flex items-center justify-center gap-2 w-full border-2 border-dashed border-gray-300 rounded-2xl py-5 text-sm font-semibold text-gray-600 hover:border-brand-orange hover:text-brand-orange transition">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Alat Lain dari Katalog Rental (Matras, Kompor, Sleeping Bag)
                        </a>

                        <details class="bg-white border border-gray-200 rounded-2xl px-5 py-4">
                            <summary class="text-sm font-semibold text-brand-dark cursor-pointer flex items-center gap-2">
                                <i class="fa-regular fa-circle-question text-gray-400"></i> Tinjauan Panduan: Jika Keranjang Kosong
                            </summary>
                            <p class="text-sm text-gray-500 mt-3">
                                Slot alat baru terkunci setelah pembayaran QRIS berhasil. Jika waktu pembayaran habis, keranjang
                                akan dikosongkan dan kuota alat dikembalikan ke katalog.
                            </p>
                        </details>
                    </div>

                    <!-- Ringkasan -->
                    <div class="space-y-4">
                        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden lg:sticky lg:top-24">
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h2 class="font-serif font-bold text-xl text-brand-dark">Ringkasan Pesanan</h2>
                                <i class="fa-solid fa-file-invoice text-gray-400"></i>
                            </div>
                            <div class="p-5 space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Tanggal Pendakian</span>
                                    <span class="font-semibold text-brand-dark">{{ Tanggal::rentang($mulai, $selesai) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Durasi Ekspedisi</span>
                                    <span class="font-semibold text-brand-dark">{{ $durasi }} Hari</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Pos Keberangkatan</span>
                                    <span class="bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $items->first()['peralatan']->pos }}</span>
                                </div>

                                <div class="border-t border-gray-100 pt-3 space-y-2">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal Alat ({{ $items->sum('jumlah') }} unit)</span>
                                        <span class="font-semibold text-brand-dark">{{ Rupiah::format($subtotal) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span class="inline-flex items-center gap-1">
                                            Biaya Layanan & Asuransi
                                            <i class="fa-regular fa-circle-question text-[10px] text-gray-400"></i>
                                        </span>
                                        <span class="font-semibold text-brand-dark">{{ Rupiah::format($biayaLayanan) }}</span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between">
                                    <span class="font-bold text-brand-dark">Total Biaya</span>
                                    <span class="font-bold text-brand-orange text-2xl">{{ Rupiah::format($total) }}</span>
                                </div>
                                <p class="text-[11px] text-green-700 bg-green-50 rounded-lg px-3 py-2 flex items-start gap-2">
                                    <i class="fa-solid fa-shield-halved mt-0.5"></i>
                                    Termasuk jaminan kebersihan alat & asuransi keselamatan ekspedisi.
                                </p>

                                <a href="{{ route('rental.checkout') }}"
                                    class="w-full bg-brand-orange text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                                    Lanjut Checkout <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                <p class="text-[11px] text-gray-500 text-center">
                                    <i class="fa-solid fa-lock"></i> Enkripsi Pembayaran Standar Bank Indonesia
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-brand-dark text-white flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-headset text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark text-sm">Butuh Bantuan Rute?</p>
                                <p class="text-xs text-gray-500 mt-1">Hubungi Pusat Informasi Pos Sembalun jika Anda memerlukan porter tambahan atau peralatan ekstrem.</p>
                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="text-xs font-semibold text-brand-orange hover:underline mt-2 inline-flex items-center gap-1">
                                    WhatsApp Radio Pos Sembalun <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bar bawah -->
                <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 mt-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Total Pembayaran ({{ $items->sum('jumlah') }} Unit):</p>
                        <p class="text-2xl font-bold text-brand-orange">{{ Rupiah::format($total) }}</p>
                    </div>
                    <a href="{{ route('rental.checkout') }}"
                        class="bg-brand-orange text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                        Lanjut ke Checkout <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
