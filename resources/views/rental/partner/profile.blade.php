@extends('layouts.rental')

@section('title', 'Profil Toko')
@section('subtitle', 'Kelola informasi publik dan jam operasional toko rental Anda.')

@section('content')
    <form action="{{ route('rental.profile.update') }}" method="POST" enctype="multipart/form-data" x-data="{ panjang: {{ mb_strlen((string) old('deskripsi', $toko->deskripsi)) }} }">
        @csrf

        {{-- Kartu identitas toko --}}
        <section class="reveal card card-lift overflow-hidden">
            <div class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:p-8">
                <div class="relative shrink-0" style="--d: 40ms">
                    @if ($toko->path_logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($toko->path_logo) }}"
                            alt="Foto {{ $toko->nama_toko }}"
                            class="h-28 w-28 rounded-2xl object-cover shadow-lift">
                    @else
                        <div class="flex h-28 w-28 items-center justify-center rounded-2xl bg-gradient-to-br from-moss to-ink font-serif text-3xl text-champagne shadow-lift">
                            {{ $toko->inisial() }}
                        </div>
                    @endif

                    <label for="foto_toko"
                        class="absolute -bottom-2 -right-2 flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl bg-brand-orange text-white shadow-lg shadow-orange-900/25 transition hover:-translate-y-0.5"
                        title="Ganti foto toko">
                        <i class="fa-solid fa-camera text-xs"></i>
                        <input id="foto_toko" type="file" name="foto_toko" accept="image/png,image/jpeg" class="hidden">
                    </label>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="font-serif text-2xl text-ink">{{ $toko->nama_toko }}</h2>
                        @if ($toko->status === 'active')
                            <span class="chip bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                                <i class="fa-solid fa-circle-check text-[9px]"></i> Terverifikasi
                            </span>
                        @else
                            <span class="chip bg-amber-50 text-amber-700 ring-1 ring-amber-100">
                                <i class="fa-solid fa-hourglass-half text-[9px]"></i> Menunggu Verifikasi
                            </span>
                        @endif
                        <span class="chip bg-slate-100 text-slate-600">Bergabung {{ $toko->created_at?->translatedFormat('Y') ?? now()->year }}</span>
                    </div>
                    <p class="mt-1 text-[13px] text-ink/50">
                        {{ $toko->penanggung_jawab ?: auth()->user()->nama }} (Penanggung Jawab Operasional)
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <label for="foto_toko"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-line/20 px-4 py-2 text-[13px] font-medium text-ink/75 transition hover:border-ink/35 hover:text-ink">
                            <i class="fa-regular fa-image text-xs"></i> Ganti Foto
                        </label>
                        @if ($toko->path_logo)
                            <button type="submit" form="hapus-foto" class="inline-flex items-center gap-2 text-[13px] font-medium text-red-600 transition hover:text-red-700">
                                <i class="fa-solid fa-trash-can text-xs"></i> Hapus Foto
                            </button>
                        @endif
                    </div>
                    <p class="mt-2 text-[11px] text-ink/40">Format JPG, JPEG, atau PNG. Ukuran maksimal 2 MB.</p>
                    @error('foto_toko') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Data toko --}}
        <section class="reveal card mt-6 p-6 sm:p-8" style="--d: 80ms">
            <div class="mb-6">
                <h3 class="font-serif text-xl text-ink">Data Toko</h3>
                <p class="mt-1 text-[12px] text-ink/50">Data ini akan tampil di katalog publik dan dapat dilihat calon pendaki.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="nama_toko">Nama Toko</label>
                    <input id="nama_toko" type="text" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" required class="field">
                    @error('nama_toko') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label" for="penanggung_jawab">Nama Pemilik</label>
                    <input id="penanggung_jawab" type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $toko->penanggung_jawab) }}" required class="field">
                    @error('penanggung_jawab') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="field-label" for="email_operasional">Email Operasional</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-ink/35"></i>
                        <input id="email_operasional" type="email" value="{{ auth()->user()->email }}" readonly
                            class="field cursor-not-allowed pl-10 text-ink/55" title="Email akun tidak dapat diubah dari halaman ini">
                    </div>
                </div>

                <div>
                    <label class="field-label" for="telepon_toko">No. WhatsApp Bisnis</label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[13px] text-emerald-600"></i>
                        <input id="telepon_toko" type="text" name="telepon_toko" value="{{ old('telepon_toko', $toko->telepon_toko) }}" required class="field pl-10" placeholder="0819-8765-4321">
                    </div>
                    @error('telepon_toko') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="field-label" for="lokasi_pos">Lokasi Pos Operasional</label>
                    <select id="lokasi_pos" name="lokasi_pos" required class="field">
                        @foreach (['Sembalun', 'Senaru', 'Torean', 'Timbanuh', 'Aik Berik'] as $pos)
                            <option value="{{ $pos }}" @selected(old('lokasi_pos', $toko->lokasi_pos) === $pos)>{{ $pos }}</option>
                        @endforeach
                    </select>
                    @error('lokasi_pos') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="field-label" for="alamat">Alamat Lengkap Basecamp / Toko</label>
                    <textarea id="alamat" name="alamat" rows="2" required class="field">{{ old('alamat', $toko->alamat) }}</textarea>
                    @error('alamat') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <div class="mb-1 flex items-baseline justify-between">
                        <label class="field-label mb-0" for="deskripsi">Deskripsi Toko</label>
                        <span class="text-[11px] text-ink/40"><span x-text="panjang"></span> / 300 karakter</span>
                    </div>
                    <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="300" x-on:input="panjang = $event.target.value.length"
                        class="field" placeholder="Ceritakan keunggulan dan kelengkapan alat toko Anda.">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Jam operasional --}}
        <section class="reveal card mt-6 p-6 sm:p-8" style="--d: 120ms">
            <div class="mb-6">
                <h3 class="font-serif text-xl text-ink">Jam Operasional Toko</h3>
                <p class="mt-1 text-[12px] text-ink/50">Tentukan ketersediaan petugas penyerahan dan penerimaan alat di basecamp.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="hari_buka">Hari Operasional</label>
                    <input id="hari_buka" type="text" name="hari_buka" value="{{ old('hari_buka', $toko->hari_buka) }}" required class="field" placeholder="Senin – Sabtu">
                    @error('hari_buka') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="field-label" for="jam_buka">Jam Buka</label>
                    <div class="relative">
                        <i class="fa-regular fa-clock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-ink/35"></i>
                        <input id="jam_buka" type="time" name="jam_buka" value="{{ old('jam_buka', $toko->jam_buka) }}" required class="field pl-10">
                    </div>
                    @error('jam_buka') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="field-label" for="jam_tutup">Jam Tutup</label>
                    <div class="relative">
                        <i class="fa-regular fa-clock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-ink/35"></i>
                        <input id="jam_tutup" type="time" name="jam_tutup" value="{{ old('jam_tutup', $toko->jam_tutup) }}" required class="field pl-10">
                    </div>
                    @error('jam_tutup') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[12px] leading-relaxed text-amber-700">
                <i class="fa-regular fa-circle-exclamation mt-0.5"></i>
                <span>Jam operasional akan ditampilkan secara publik pada kartu sewa dan e-voucher pendaki. Pengembalian di luar jam ini wajib konfirmasi via WhatsApp.</span>
            </div>
        </section>

        {{-- Aksi --}}
        <section class="reveal card mt-6 flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between" style="--d: 160ms">
            <p class="flex items-start gap-2 text-[11px] leading-relaxed text-ink/45">
                <i class="fa-solid fa-shield-halved mt-0.5"></i>
                <span>Untuk memperbarui dokumen legalitas (NIB, SIUP), verifikasi APGI, atau rekening pencairan bank, kunjungi menu <a href="{{ route('rental.settings', ['tab' => 'legalitas']) }}" class="font-semibold text-ink/75 underline decoration-dotted">Pengaturan</a>.</span>
            </p>
            <div class="flex shrink-0 items-center gap-3">
                <a href="{{ route('rental.profile') }}" class="rounded-xl border border-line/22 px-5 py-2.5 text-sm font-medium text-ink/65 transition hover:border-ink/35 hover:text-ink">Batal</a>
                <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                    <i class="fa-regular fa-floppy-disk text-xs"></i> Simpan Perubahan
                </button>
            </div>
        </section>
    </form>

    @if ($toko->path_logo)
        <form id="hapus-foto" action="{{ route('rental.profile.foto.hapus') }}" method="POST" class="hidden"
            onsubmit="return confirm('Hapus foto toko? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
