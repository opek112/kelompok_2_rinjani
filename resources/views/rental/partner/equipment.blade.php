@extends('layouts.rental')

@php
    $mengubah = $peralatan->exists;
@endphp

@section('title', $mengubah ? 'Ubah Alat' : 'Tambah Alat Baru')
@section('subtitle', $mengubah ? 'Perbarui data '.$peralatan->nama.' di inventaris toko.' : 'Lengkapi data alat agar tampil rapi di katalog rental.')

@section('content')
    <form method="POST"
        action="{{ $mengubah ? route('rental.equipment.update', $peralatan) : route('rental.equipment.store') }}"
        class="reveal"
        x-data="{
            foto: @js($peralatan->path_gambar ?? ''),
            cadangan: @js($peralatan->fotoKategori()),
            deskripsi: @js(old('deskripsi', $peralatan->deskripsi ?? ''))
        }">
        @csrf
        @if ($mengubah)
            @method('PUT')
        @endif

        <div class="grid gap-5 lg:grid-cols-[1.6fr_1fr]">
            <!-- Kolom utama -->
            <div class="space-y-5">
                <section class="card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-2">
                        <span class="h-1 w-6 rounded-full bg-champagne"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink/40">Informasi Dasar</h2>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="nama" class="mb-1.5 block text-xs font-semibold text-ink/60">Nama Alat</label>
                            <input id="nama" name="nama" type="text" required value="{{ old('nama', $peralatan->nama) }}"
                                placeholder="Contoh: Tenda Dome 4P"
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                        </div>

                        <div>
                            <label for="kategori" class="mb-1.5 block text-xs font-semibold text-ink/60">Kategori</label>
                            <input id="kategori" name="kategori" list="daftar-kategori" required value="{{ old('kategori', $peralatan->kategori) }}"
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                            <datalist id="daftar-kategori">
                                @foreach ($daftarKategori as $namaKategori)
                                    <option value="{{ $namaKategori }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div>
                            <label for="pos" class="mb-1.5 block text-xs font-semibold text-ink/60">Pos Penyerahan</label>
                            <select id="pos" name="pos" required
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel">
                                @foreach ($daftarPos as $pos)
                                    <option value="{{ $pos }}" @selected(old('pos', $peralatan->pos) === $pos)>{{ $pos }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tarif_harian" class="mb-1.5 block text-xs font-semibold text-ink/60">Tarif per Hari (Rp)</label>
                            <input id="tarif_harian" name="tarif_harian" type="number" min="0" step="500" required
                                value="{{ old('tarif_harian', (int) $peralatan->tarif_harian) }}"
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                        </div>

                        <div>
                            <label for="jumlah_stok" class="mb-1.5 block text-xs font-semibold text-ink/60">Jumlah Stok (unit)</label>
                            <input id="jumlah_stok" name="jumlah_stok" type="number" min="0" required
                                value="{{ old('jumlah_stok', $peralatan->jumlah_stok) }}"
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                        </div>

                        <div class="sm:col-span-2">
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="deskripsi" class="block text-xs font-semibold text-ink/60">Deskripsi Singkat</label>
                                <span class="text-[10px] text-ink/35"><span x-text="deskripsi.length"></span>/500</span>
                            </div>
                            <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="500" x-model="deskripsi"
                                placeholder="Contoh: Double layer waterproof 3000mm, ringan dan mudah dipasang."
                                class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15"></textarea>
                        </div>
                    </div>
                </section>

                <section class="card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-2">
                        <span class="h-1 w-6 rounded-full bg-champagne"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink/40">Spesifikasi Teknis</h2>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ([
                            ['name' => 'kapasitas', 'label' => 'Kapasitas', 'placeholder' => '4 Orang'],
                            ['name' => 'berat', 'label' => 'Berat', 'placeholder' => '3.5 kg'],
                            ['name' => 'material', 'label' => 'Material', 'placeholder' => 'Polyester 3000mm'],
                            ['name' => 'dimensi', 'label' => 'Dimensi', 'placeholder' => '210 x 210 x 130 cm'],
                        ] as $field)
                            <div>
                                <label for="{{ $field['name'] }}" class="mb-1.5 block text-xs font-semibold text-ink/60">{{ $field['label'] }}</label>
                                <input id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="text"
                                    value="{{ old($field['name'], $peralatan->{$field['name']}) }}"
                                    placeholder="{{ $field['placeholder'] }}"
                                    class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-sm outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                            </div>
                        @endforeach
                    </div>

                    <label class="mt-5 flex cursor-pointer items-start gap-3 rounded-xl border border-line/14 bg-sand/50 p-4">
                        <input type="checkbox" name="sorotan" value="1" @checked(old('sorotan', $peralatan->sorotan))
                            class="mt-0.5 h-4 w-4 rounded border-line/30 text-brand-orange focus:ring-brand-orange">
                        <span>
                            <span class="block text-[13px] font-semibold text-ink">Tampilkan sebagai alat sorotan</span>
                            <span class="block text-[11px] text-ink/45">Alat sorotan muncul lebih dulu di halaman katalog rental.</span>
                        </span>
                    </label>
                </section>
            </div>

            <!-- Kolom samping -->
            <div class="space-y-5">
                <section class="card p-5">
                    <div class="mb-4 flex items-center gap-2">
                        <span class="h-1 w-6 rounded-full bg-champagne"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink/40">Foto Alat</h2>
                    </div>

                    <div class="aspect-[4/3] overflow-hidden rounded-xl bg-sand ring-1 ring-line/12">
                        <img :src="foto || cadangan" alt="Pratinjau foto" class="h-full w-full object-cover">
                    </div>

                    <label for="path_gambar" class="mb-1.5 mt-4 block text-xs font-semibold text-ink/60">Tautan Foto (URL)</label>
                    <input id="path_gambar" name="path_gambar" type="url" x-model="foto"
                        placeholder="https://..."
                        class="w-full rounded-xl border border-line/16 bg-sand/40 px-4 py-2.5 text-[12px] outline-none transition focus:border-brand-orange/50 focus:bg-panel focus:ring-2 focus:ring-brand-orange/15">
                    <p class="mt-2 text-[11px] leading-relaxed text-ink/40">
                        Kosongkan untuk memakai foto bawaan kategori. Rasio yang disarankan 4:3.
                    </p>
                </section>

                <section class="card p-5">
                    <div class="mb-3 flex items-center gap-2">
                        <span class="h-1 w-6 rounded-full bg-champagne"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink/40">Ringkasan</h2>
                    </div>
                    <p class="text-[12px] leading-relaxed text-ink/50">
                        Data ini tampil di katalog publik. Pastikan tarif dan stok sesuai kondisi toko
                        <span class="font-semibold text-ink/70">{{ $toko->nama_toko }}</span>.
                    </p>
                    <div class="mt-3 flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-2 text-[11px] text-emerald-700">
                        <i class="fa-solid fa-shield-halved"></i> Alat langsung aktif setelah disimpan.
                    </div>
                </section>
            </div>
        </div>

        <!-- Bar aksi -->
        <div class="sticky bottom-4 z-20 mt-5">
            <div class="card flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[11px] text-ink/45">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    {{ $mengubah ? 'Perubahan langsung terlihat oleh calon penyewa.' : 'Alat baru langsung tersedia di katalog rental.' }}
                </p>
                <div class="flex flex-wrap items-center gap-2">
                    @if ($mengubah)
                        <button type="button"
                            onclick="if (confirm('Hapus {{ $peralatan->nama }} dari inventaris?')) document.getElementById('form-hapus-alat').submit();"
                            class="inline-flex items-center gap-2 rounded-xl border border-red-200 px-4 py-2.5 text-[13px] font-medium text-red-600 transition hover:bg-red-50">
                            <i class="fa-regular fa-trash-can text-xs"></i> Hapus
                        </button>
                    @endif
                    <a href="{{ route('rental.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-line/22 px-4 py-2.5 text-[13px] font-medium text-ink/65 transition hover:border-ink/30 hover:text-ink">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-[13px] font-semibold text-white">
                        <i class="fa-solid fa-floppy-disk text-xs"></i> {{ $mengubah ? 'Simpan Perubahan' : 'Simpan Alat' }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if ($mengubah)
        <form id="form-hapus-alat" action="{{ route('rental.equipment.destroy', $peralatan) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
