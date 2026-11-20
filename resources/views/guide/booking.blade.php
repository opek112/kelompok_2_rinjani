@extends('layouts.app')

@section('content')
    @php
        use Modules\Guide\Support\Formatter;
    @endphp

    <section class="bg-gradient-to-br from-brand-dark via-brand-green to-[#20402f] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <a href="{{ route('guide.detail', $pemandu) }}"
                class="inline-flex items-center gap-2 text-xs font-semibold text-gray-200 hover:text-brand-orange mb-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Profil Pemandu
            </a>
            <h1 class="text-3xl md:text-4xl font-serif font-bold">Pesan Pemandu</h1>
            <p class="text-gray-300 mt-2 max-w-2xl text-sm md:text-base">
                Lengkapi data rombongan, pilih jalur dan tanggal, lalu lanjutkan ke pembayaran QRIS.
                Jadwal pemandu otomatis dikunci setelah pembayaran terverifikasi.
            </p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-10">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-2xl px-5 py-4 mb-6">
                <p class="font-semibold mb-1">Periksa kembali data Anda:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guide.booking.store', $pemandu) }}" method="POST" enctype="multipart/form-data"
            x-data="{
                tarif: {{ (float) $pemandu->tarif_harian }},
                mulai: '{{ $mulai->toDateString() }}',
                selesai: '{{ $selesai->toDateString() }}',
                get hari() {
                    if (!this.mulai || !this.selesai) return 0;
                    const a = new Date(this.mulai), b = new Date(this.selesai);
                    if (isNaN(a) || isNaN(b) || b < a) return 0;
                    return Math.round((b - a) / 86400000) + 1;
                },
                get total() { return this.tarif * this.hari; },
                get totalTagihan() { return this.total + 5000; },
                rupiah(n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(n || 0); }
            }">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-xl font-serif font-bold text-brand-dark mb-1">Jadwal & Jalur</h2>
                        <p class="text-sm text-gray-500 mb-5">Tanggal yang sudah dipesan atau ditandai libur tidak dapat dipilih.</p>

                        <div class="space-y-4">
                            <div>
                                <label for="rute" class="block text-xs font-semibold text-gray-500 mb-1">Jalur Pendakian</label>
                                <select id="rute" name="rute" required
                                    class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                    @foreach ($pemandu->ruteList() as $rute)
                                        <option value="{{ $rute }}" {{ old('rute') === $rute ? 'selected' : '' }}>{{ $rute }}</option>
                                    @endforeach
                                </select>
                                @error('rute') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tanggal_mulai" class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                                        min="{{ today()->toDateString() }}"
                                        value="{{ old('tanggal_mulai', $mulai->toDateString()) }}" x-model="mulai"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                    @error('tanggal_mulai') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="tanggal_selesai" class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Selesai</label>
                                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                                        min="{{ today()->toDateString() }}"
                                        value="{{ old('tanggal_selesai', $selesai->toDateString()) }}" x-model="selesai"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                    @error('tanggal_selesai') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-xl font-serif font-bold text-brand-dark mb-1">Identitas Ketua Rombongan</h2>
                        <p class="text-sm text-gray-500 mb-5">Data dipakai untuk SIMAKSI, asuransi, dan serah terima di basecamp.</p>

                        <div class="space-y-4">
                            <div>
                                <label for="nama_ketua" class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap (Sesuai KTP)</label>
                                <input type="text" id="nama_ketua" name="nama_ketua" required
                                    value="{{ old('nama_ketua', auth()->user()?->nama) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                @error('nama_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="telepon_ketua" class="block text-xs font-semibold text-gray-500 mb-1">Nomor WhatsApp</label>
                                    <input type="text" id="telepon_ketua" name="telepon_ketua" required
                                        value="{{ old('telepon_ketua', auth()->user()?->no_telepon) }}" placeholder="081234567890"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                    @error('telepon_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email_ketua" class="block text-xs font-semibold text-gray-500 mb-1">Alamat Email</label>
                                    <input type="email" id="email_ketua" name="email_ketua" required
                                        value="{{ old('email_ketua', auth()->user()?->email) }}" placeholder="nama@email.com"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                    @error('email_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="nik_ketua" class="block text-xs font-semibold text-gray-500 mb-1">NIK (16 digit)</label>
                                <input type="text" id="nik_ketua" name="nik_ketua" required maxlength="16" inputmode="numeric"
                                    value="{{ old('nik_ketua') }}" placeholder="5201021908950001"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange">
                                @error('nik_ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="foto_ktp" class="block text-xs font-semibold text-gray-500 mb-1">Foto KTP (opsional)</label>
                                <input type="file" id="foto_ktp" name="foto_ktp" accept="image/*"
                                    class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-dark file:text-white hover:file:bg-brand-green">
                                <p class="text-[11px] text-gray-500 mt-1">Disimpan di penyimpanan privat, hanya dapat diakses pemandu yang ditugaskan.</p>
                                @error('foto_ktp') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                        <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-700">
                            <input type="checkbox" name="setuju" value="1" {{ old('setuju') ? 'checked' : '' }}
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-brand-dark">
                            <span>Saya menyetujui syarat & ketentuan pendakian TNGR, standar keselamatan APGI, dan kebijakan pembatalan pemesanan pemandu.</span>
                        </label>
                        @error('setuju') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm lg:sticky lg:top-24">
                        <div class="bg-brand-dark text-white px-5 py-4 flex items-center justify-between">
                            <h2 class="font-serif font-bold text-lg flex items-center gap-2">
                                <i class="fa-solid fa-file-invoice text-sm"></i> Ringkasan
                            </h2>
                            <span class="bg-white/15 text-[10px] font-bold px-2 py-1 rounded">PEMANDU</span>
                        </div>

                        <div class="p-5 space-y-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-brand-dark text-white flex items-center justify-center font-bold">
                                    {{ $pemandu->inisial() }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-brand-dark truncate">{{ $pemandu->user->nama ?? 'Pemandu' }}</p>
                                    <p class="text-[11px] text-gray-500">
                                        {{ $pemandu->nomor_lisensi ? 'Lisensi '.$pemandu->nomor_lisensi : 'Pemandu terverifikasi' }}
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-3 space-y-2 text-gray-600">
                                <div class="flex justify-between">
                                    <span>Tarif harian</span>
                                    <span class="font-semibold text-brand-dark">{{ Formatter::rupiah($pemandu->tarif_harian) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Durasi</span>
                                    <span class="font-semibold text-brand-dark" x-text="hari + ' hari'">0 hari</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Jasa pemandu</span>
                                    <span class="font-semibold text-brand-dark" x-text="rupiah(total)">Rp 0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya layanan</span>
                                    <span class="font-semibold text-brand-dark">{{ Formatter::rupiah(5000) }}</span>
                                </div>
                            </div>

                            <div class="border-t-2 border-dashed border-gray-200 pt-4 flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] font-bold tracking-widest text-gray-400">TOTAL BAYAR</p>
                                    <p class="text-[11px] text-gray-400">Belum termasuk tiket TNGR</p>
                                </div>
                                <p class="text-xl font-bold text-brand-orange" x-text="rupiah(totalTagihan)">Rp 0</p>
                            </div>

                            <button type="submit"
                                class="w-full bg-brand-orange text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2">
                                Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <p class="text-[11px] text-gray-500 text-center">
                                <i class="fa-solid fa-lock"></i> Jadwal dikunci setelah pembayaran terverifikasi.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 shrink-0">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-brand-dark">Kebijakan Pembatalan</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">
                                Pesanan yang belum dibayar kedaluwarsa dalam 15 menit dan tanggal pemandu otomatis dilepas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
