@extends('layouts.flow')

@section('title', 'Checkout — RinjaniGuide & Rental')

@section('back', 'Kembali ke Keranjang')
@section('back-url', route('rental.cart'))

@section('header-right')
    <div class="hidden md:flex items-center gap-3 text-sm">
        <span class="flex items-center gap-2 font-semibold text-brand-orange">
            <span class="w-6 h-6 rounded-full bg-brand-orange text-white text-[11px] flex items-center justify-center">1</span> Data Pemesan
        </span>
        <span class="w-10 h-px bg-gray-200"></span>
        <span class="flex items-center gap-2 text-gray-400">
            <span class="w-6 h-6 rounded-full bg-gray-100 text-[11px] flex items-center justify-center">2</span> Pembayaran
        </span>
    </div>
    <span class="hidden lg:inline-flex items-center gap-2 bg-gray-100 text-gray-600 text-[11px] font-medium px-3 py-1.5 rounded-lg">
        <i class="fa-solid fa-lock"></i> Enkripsi SSL 256-bit
    </span>
@endsection

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $namaAwal = old('nama_ketua', auth()->user()?->nama);
        $emailAwal = old('email_ketua', auth()->user()?->email);
        $teleponAwal = old('telepon_ketua', auth()->user()?->no_telepon);
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 flex items-start gap-3 mb-6">
            <i class="fa-solid fa-triangle-exclamation text-yellow-600 mt-0.5"></i>
            <div class="text-sm">
                <p class="font-bold text-yellow-900">Penting: Verifikasi SIMAKSI & Tiket Asuransi</p>
                <p class="text-yellow-800 text-xs mt-0.5">
                    Data ini akan dikunci untuk e-voucher dan tidak dapat diubah setelah pembayaran. Pastikan identitas ketua
                    rombongan sesuai dengan dokumen identitas resmi untuk verifikasi di pos pendakian TNGR.
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">
                <p class="font-semibold mb-1">Periksa kembali data Anda:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rental.checkout.store') }}" method="POST" enctype="multipart/form-data"
            x-data="{
                pratinjau: null,
                namaBerkas: '',
                pilihBerkas(event) {
                    const file = event.target.files[0];
                    if (!file) { this.pratinjau = null; return; }
                    this.namaBerkas = file.name;
                    this.pratinjau = URL.createObjectURL(file);
                },
                hapusBerkas() {
                    this.pratinjau = null;
                    this.namaBerkas = '';
                    this.$refs.inputKtp.value = '';
                }
            }">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Identitas -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-2xl font-serif font-bold text-brand-dark">Identitas Ketua Rombongan</h2>
                            <span class="bg-orange-100 text-brand-orange text-[10px] font-bold px-2.5 py-1 rounded">WAJIB DIISI</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-6">
                            Ketua rombongan bertanggung jawab atas perizinan SIMAKSI dan koordinasi tim di basecamp.
                        </p>

                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center justify-between text-xs font-semibold text-gray-500 mb-1">
                                    <span>Nama Lengkap (Sesuai KTP / Paspor)</span>
                                    <span class="inline-flex items-center gap-1 text-green-700"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span>
                                </label>
                                <input type="text" name="nama_ketua" value="{{ $namaAwal }}" required
                                    placeholder="Nama sesuai identitas"
                                    class="w-full px-4 py-3 rounded-xl border @error('nama_ketua') border-red-400 @else border-gray-200 @enderror text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                @error('nama_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor WhatsApp Aktif</label>
                                    <div class="flex">
                                        <span class="px-3 py-3 border border-r-0 border-gray-200 rounded-l-xl bg-gray-50 text-sm text-gray-500">+62</span>
                                        <input type="text" name="telepon_ketua" value="{{ $teleponAwal }}" required placeholder="0812-3456-7890"
                                            class="w-full px-4 py-3 rounded-r-xl border @error('telepon_ketua') border-red-400 @else border-gray-200 @enderror text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-1">Untuk koordinasi darurat & briefing guide</p>
                                    @error('telepon_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Alamat Email</label>
                                    <input type="email" name="email_ketua" value="{{ $emailAwal }}" required placeholder="nama@email.com"
                                        class="w-full px-4 py-3 rounded-xl border @error('email_ketua') border-red-400 @else border-gray-200 @enderror text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                    <p class="text-[11px] text-gray-500 mt-1">E-voucher & tiket asuransi dikirim ke sini</p>
                                    @error('email_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="flex items-center justify-between text-xs font-semibold text-gray-500 mb-1">
                                    <span>Nomor Induk Kependudukan (NIK / Nomor Paspor)</span>
                                    <span class="text-[11px] text-gray-400">16 Digit Angka</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="nik_ketua" value="{{ old('nik_ketua') }}" required maxlength="16" inputmode="numeric"
                                        placeholder="5201021908950001"
                                        class="w-full px-4 py-3 pr-12 rounded-xl border @error('nik_ketua') border-red-400 @else border-gray-200 @enderror text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                                    <i class="fa-regular fa-id-card absolute right-4 top-3.5 text-gray-400"></i>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-shield-halved"></i> NIK harus 16 digit angka sesuai KTP (Terverifikasi di Dukcapil NTB)
                                </p>
                                @error('nik_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload KTP -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-2xl font-serif font-bold text-brand-dark">Unggah Foto KTP / Paspor</h2>
                        <p class="text-sm text-gray-500 mt-1 mb-5">
                            Dibutuhkan oleh Balai Taman Nasional Gunung Rinjani untuk penerbitan asuransi dan SIMAKSI.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="cursor-pointer border-2 border-dashed border-green-200 bg-green-50/40 rounded-2xl p-8 flex flex-col items-center justify-center text-center hover:border-brand-orange transition">
                                <input type="file" name="foto_ktp" accept="image/*" class="hidden" x-ref="inputKtp" @change="pilihBerkas">
                                <span class="w-12 h-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-camera text-gray-500"></i>
                                </span>
                                <span class="font-semibold text-brand-dark text-sm">Klik untuk unggah atau seret file ke sini</span>
                                <span class="text-xs text-gray-500 mt-1">Format JPG, JPEG, atau PNG, maksimal ukuran 2 MB</span>
                            </label>

                            <div class="border border-gray-200 rounded-2xl p-4" x-show="pratinjau" x-cloak>
                                <div class="rounded-xl overflow-hidden bg-gray-100 relative">
                                    <img :src="pratinjau" alt="Pratinjau KTP" class="w-full h-32 object-cover opacity-80">
                                    <span class="absolute inset-0 flex items-center justify-center text-[11px] font-bold text-white tracking-wide bg-black/30">HANYA UNTUK VERIFIKASI TNGR</span>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-green-700 flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> KTP Terverifikasi</p>
                                        <p class="text-[11px] text-gray-500 truncate" x-text="namaBerkas"></p>
                                    </div>
                                    <button type="button" @click="hapusBerkas()" class="w-8 h-8 rounded-lg border border-gray-200 text-red-500 flex items-center justify-center hover:bg-red-50">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="border border-dashed border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center" x-show="!pratinjau">
                                <i class="fa-regular fa-image text-2xl text-gray-300"></i>
                                <p class="text-xs text-gray-400 mt-2">Pratinjau foto KTP akan tampil di sini.</p>
                            </div>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-4 flex items-center gap-2">
                            <i class="fa-regular fa-circle-question"></i>
                            Ukuran file maksimal 2 MB • Format didukung: JPG, PNG • Dokumen disimpan dengan enkripsi end-to-end.
                        </p>
                        @error('foto_ktp') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Persetujuan -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                        <h3 class="font-bold text-brand-dark flex items-center gap-2 mb-4">
                            <i class="fa-regular fa-square-check"></i> Pernyataan & Persetujuan Ketentuan
                        </h3>
                        <div class="space-y-3 text-sm text-gray-700">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" checked disabled class="mt-1 w-4 h-4 text-brand-dark rounded border-gray-300">
                                <span>Saya menyatakan data yang diisi benar dan sesuai kartu identitas resmi untuk keperluan pendaftaran SIMAKSI.</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" checked disabled class="mt-1 w-4 h-4 text-brand-dark rounded border-gray-300">
                                <span>Saya menyetujui syarat & ketentuan pendakian TNGR, standar keselamatan APGI, dan kebijakan sewa alat operasional.</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="setuju" value="1" {{ old('setuju') ? 'checked' : '' }} class="mt-1 w-4 h-4 text-brand-dark rounded border-gray-300">
                                <span>Data terkunci untuk e-voucher dan tidak dapat diubah setelah pembayaran, serta saya memahami seluruh rincian biaya sewa alat.</span>
                            </label>
                        </div>
                        @error('setuju') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Ringkasan -->
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden lg:sticky lg:top-24">
                        <div class="bg-brand-dark text-white px-5 py-4 flex items-center justify-between">
                            <h2 class="font-serif font-bold text-lg flex items-center gap-2"><i class="fa-solid fa-file-invoice text-sm"></i> Ringkasan Pesanan</h2>
                            <span class="bg-white/15 text-[10px] font-bold px-2 py-1 rounded">{{ $items->sum('jumlah') }} ITEM TERPILIH</span>
                        </div>

                        <div class="p-5 space-y-4 text-sm">
                            @foreach ($items as $item)
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-tent text-brand-orange text-xs"></i>
                                    </div>
                                    <div class="min-w-0 flex-grow">
                                        <p class="font-semibold text-brand-dark truncate">{{ $item['peralatan']->nama }}</p>
                                        <p class="text-[11px] text-gray-500">{{ $item['peralatan']->toko?->nama_toko }} (Pos {{ $item['peralatan']->pos }})</p>
                                        <p class="text-[11px] text-gray-500">{{ $item['jumlah'] }} Unit × {{ $durasi }} Hari</p>
                                    </div>
                                    <span class="font-semibold text-brand-dark whitespace-nowrap">{{ Rupiah::format($item['subtotal']) }}</span>
                                </div>
                            @endforeach

                            <div class="border-t border-gray-100 pt-3 space-y-2 text-gray-600">
                                <div class="flex justify-between">
                                    <span>Subtotal Alat</span>
                                    <span class="font-semibold text-brand-dark">{{ Rupiah::format($subtotal) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="inline-flex items-center gap-1">Biaya Layanan & Asuransi TNGR</span>
                                    <span class="font-semibold text-brand-dark">{{ Rupiah::format($biayaLayanan) }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span>Jadwal</span>
                                    <span class="font-semibold text-brand-dark">{{ Tanggal::rentang($mulai, $selesai) }}</span>
                                </div>
                            </div>

                            <div class="border-t-2 border-dashed border-gray-200 pt-4 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] font-bold tracking-widest text-gray-400">TOTAL BIAYA</p>
                                    <p class="text-[11px] text-gray-400">Sudah termasuk pajak & perizinan</p>
                                </div>
                                <p class="text-2xl font-bold text-brand-orange">{{ Rupiah::format($total) }}</p>
                            </div>

                            <button type="submit"
                                class="w-full bg-brand-orange text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                                Lanjut ke Pembayaran QRIS <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <p class="text-[11px] text-gray-500 text-center">
                                <i class="fa-solid fa-lock"></i> Enkripsi Pembayaran Aman via QRIS Nasional + Tiket Resmi TNGR
                            </p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 shrink-0">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-brand-dark">Jaminan Layanan Standar APGI</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">Alat terverifikasi & logistik diverifikasi langsung di pintu registrasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 mt-6 flex flex-col md:flex-row md:items-center justify-between gap-4 sticky bottom-3 shadow-lg">
                <div>
                    <p class="text-xs text-gray-500">Total Pembayaran ({{ $items->sum('jumlah') }} Unit):</p>
                    <p class="text-2xl font-bold text-brand-orange">{{ Rupiah::format($total) }} <span class="text-xs font-semibold text-green-700">• Bebas Biaya Admin</span></p>
                </div>
                <button type="submit" class="bg-brand-orange text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                    Bayar Sekarang (Lanjut ke QRIS) <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
