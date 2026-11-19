@extends('layouts.rental')

@section('title', 'Pengaturan')
@section('subtitle', 'Kelola data legalitas, rekening pencairan, keamanan akun, dan preferensi toko Anda.')

@section('content')
    @php
        $tabs = [
            'legalitas' => ['label' => 'Legalitas & Dokumen', 'ikon' => 'fa-file-shield'],
            'rekening' => ['label' => 'Rekening Pencairan', 'ikon' => 'fa-building-columns'],
            'keamanan' => ['label' => 'Keamanan Akun', 'ikon' => 'fa-shield-halved'],
            'preferensi' => ['label' => 'Preferensi', 'ikon' => 'fa-sliders'],
        ];
    @endphp

    <!-- Tab -->
    <nav class="reveal mb-6 flex gap-1 overflow-x-auto rounded-xl border border-line/12 bg-panel/80 p-1">
        @foreach ($tabs as $kode => $info)
            <a href="{{ route('rental.settings', ['tab' => $kode]) }}"
                class="flex flex-1 items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-[12.5px] font-medium transition
                    {{ $tab === $kode ? 'bg-ink text-white shadow-soft' : 'text-ink/55 hover:bg-sand hover:text-ink' }}">
                <i class="fa-solid {{ $info['ikon'] }} text-[11px]"></i> {{ $info['label'] }}
            </a>
        @endforeach
    </nav>

    @if ($tab === 'legalitas')
        <section class="reveal card overflow-hidden">
            <div class="border-b border-line/10 px-5 py-4">
                <h2 class="font-serif text-lg text-ink">Legalitas &amp; Dokumen</h2>
                <p class="mt-0.5 text-[12px] text-ink/45">Data ini dipakai admin untuk verifikasi dan ditampilkan pada halaman toko Anda.</p>
            </div>

            <form method="POST" action="{{ route('rental.settings.legalitas') }}" enctype="multipart/form-data" class="space-y-5 p-5">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="nama_toko">Nama toko</label>
                        <input id="nama_toko" name="nama_toko" type="text" required value="{{ old('nama_toko', $toko->nama_toko) }}" class="field">
                    </div>
                    <div>
                        <label class="field-label" for="penanggung_jawab">Penanggung jawab</label>
                        <input id="penanggung_jawab" name="penanggung_jawab" type="text" required value="{{ old('penanggung_jawab', $toko->penanggung_jawab) }}" class="field">
                    </div>
                    <div>
                        <label class="field-label" for="telepon_toko">Telepon toko / WhatsApp</label>
                        <input id="telepon_toko" name="telepon_toko" type="text" required value="{{ old('telepon_toko', $toko->telepon_toko) }}" class="field">
                    </div>
                    <div>
                        <label class="field-label" for="lokasi_pos">Pos pendakian</label>
                        <select id="lokasi_pos" name="lokasi_pos" required class="field">
                            @foreach (['Sembalun', 'Senaru', 'Torean', 'Timbanuh', 'Aik Berik'] as $pos)
                                <option value="{{ $pos }}" @selected(old('lokasi_pos', $toko->lokasi_pos) === $pos)>{{ $pos }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="field-label" for="alamat">Alamat basecamp</label>
                    <textarea id="alamat" name="alamat" rows="2" required class="field resize-none">{{ old('alamat', $toko->alamat) }}</textarea>
                </div>

                <div>
                    <label class="field-label" for="deskripsi">Deskripsi singkat toko</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="300" class="field resize-none"
                        placeholder="Contoh: Penyewaan alat pendakian lengkap dengan pengecekan sebelum diserahkan.">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="nib">NIB</label>
                        <input id="nib" name="nib" type="text" value="{{ old('nib', $toko->nib) }}" class="field" placeholder="Nomor Induk Berusaha">
                    </div>
                    <div>
                        <label class="field-label" for="npwp">NPWP</label>
                        <input id="npwp" name="npwp" type="text" value="{{ old('npwp', $toko->npwp) }}" class="field" placeholder="Nomor NPWP badan usaha">
                    </div>
                </div>

                <div class="rounded-xl border border-line/12 bg-sand/40 p-4">
                    <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink/40">Dokumen legalitas</p>
                    @if ($toko->path_berkas_legalitas)
                        <a href="{{ asset('storage/'.$toko->path_berkas_legalitas) }}" target="_blank" rel="noopener"
                            class="mt-2 inline-flex items-center gap-2 text-[12px] font-medium text-brand-orange hover:underline">
                            <i class="fa-solid fa-file-lines"></i> Lihat dokumen tersimpan
                        </a>
                    @else
                        <p class="mt-2 text-[12px] text-ink/45">Belum ada dokumen diunggah.</p>
                    @endif

                    <label for="file_legalitas" class="field-label mt-3">Ganti dokumen (JPG, PNG, PDF · maks 5 MB)</label>
                    <input id="file_legalitas" name="file_legalitas" type="file" accept=".jpg,.jpeg,.png,.pdf"
                        class="block w-full text-[12px] text-ink/60 file:mr-3 file:rounded-lg file:border-0 file:bg-ink file:px-3 file:py-2 file:text-[12px] file:font-semibold file:text-white">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                        <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Data Legalitas
                    </button>
                </div>
            </form>
        </section>
    @endif

    @if ($tab === 'rekening')
        <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-start">
            <section class="reveal card overflow-hidden">
                <div class="border-b border-line/10 px-5 py-4">
                    <h2 class="font-serif text-lg text-ink">Rekening Pencairan</h2>
                    <p class="mt-0.5 text-[12px] text-ink/45">Pendapatan sewa ditransfer ke rekening ini setiap pencairan.</p>
                </div>

                <form method="POST" action="{{ route('rental.settings.rekening') }}" class="space-y-5 p-5">
                    @csrf

                    <div>
                        <label class="field-label" for="nama_bank">Nama bank</label>
                        <select id="nama_bank" name="nama_bank" required class="field">
                            @foreach (['BCA', 'BRI', 'BNI', 'Mandiri', 'BSI', 'Bank NTB Syariah'] as $bank)
                                <option value="{{ $bank }}" @selected(old('nama_bank', $toko->nama_bank) === $bank)>{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="field-label" for="nomor_rekening">Nomor rekening</label>
                        <input id="nomor_rekening" name="nomor_rekening" type="text" required
                            value="{{ old('nomor_rekening', $toko->nomor_rekening) }}" class="field font-mono tracking-wide" placeholder="0123456789">
                    </div>

                    <div>
                        <label class="field-label" for="nama_pemilik_rekening">Nama pemilik rekening</label>
                        <input id="nama_pemilik_rekening" name="nama_pemilik_rekening" type="text" required
                            value="{{ old('nama_pemilik_rekening', $toko->nama_pemilik_rekening) }}" class="field">
                        <p class="mt-1 text-[11px] text-ink/40">Nama harus sama dengan data rekening bank agar pencairan tidak gagal.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                            <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Rekening
                        </button>
                    </div>
                </form>
            </section>

            <aside class="reveal card p-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-ink/35">Status rekening</p>
                <div class="mt-3 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $toko->rekeningLengkap() ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        <i class="fa-solid fa-{{ $toko->rekeningLengkap() ? 'circle-check' : 'triangle-exclamation' }} text-sm"></i>
                    </span>
                    <div>
                        <p class="text-[13px] font-semibold text-ink">{{ $toko->rekeningLengkap() ? 'Siap menerima pencairan' : 'Rekening belum lengkap' }}</p>
                        <p class="text-[11px] text-ink/45">{{ $toko->nama_bank ? $toko->nama_bank.' · '.$toko->nomor_rekening : 'Lengkapi data rekening' }}</p>
                    </div>
                </div>

                <ul class="mt-4 space-y-2 border-t border-line/10 pt-4 text-[11px] leading-relaxed text-ink/50">
                    <li><i class="fa-solid fa-check mr-1 text-emerald-600"></i> Pencairan diproses setiap hari kerja.</li>
                    <li><i class="fa-solid fa-check mr-1 text-emerald-600"></i> Komisi platform dipotong otomatis.</li>
                    <li><i class="fa-solid fa-check mr-1 text-emerald-600"></i> Perubahan rekening berlaku pada pencairan berikutnya.</li>
                </ul>
            </aside>
        </div>
    @endif

    @if ($tab === 'keamanan')
        <div class="space-y-6">
            <section class="reveal card overflow-hidden">
                <div class="border-b border-line/10 px-5 py-4">
                    <h2 class="font-serif text-lg text-ink">Ubah Kata Sandi</h2>
                    <p class="mt-0.5 text-[12px] text-ink/45">Perbarui kata sandi secara berkala untuk menjaga keamanan data inventaris dan transaksi.</p>
                </div>

                <form method="POST" action="{{ route('rental.settings.keamanan') }}" class="grid gap-4 p-5 sm:grid-cols-3">
                    @csrf
                    <div>
                        <label class="field-label" for="password_lama">Kata sandi saat ini</label>
                        <input id="password_lama" name="password_lama" type="password" required autocomplete="current-password" class="field">
                    </div>
                    <div>
                        <label class="field-label" for="password">Kata sandi baru</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password" class="field">
                    </div>
                    <div>
                        <label class="field-label" for="password_confirmation">Konfirmasi kata sandi baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="field">
                    </div>

                    <p class="text-[11px] text-ink/40 sm:col-span-2">
                        <i class="fa-solid fa-circle-info mr-1"></i> Minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka.
                    </p>
                    <div class="sm:text-right">
                        <button type="submit" class="btn-primary sheen inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white sm:w-auto">
                            <i class="fa-solid fa-key text-xs"></i> Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </section>

            <section class="reveal card overflow-hidden">
                <div class="flex items-center justify-between border-b border-line/10 px-5 py-4">
                    <div>
                        <h2 class="font-serif text-lg text-ink">Sesi Aktif</h2>
                        <p class="mt-0.5 text-[12px] text-ink/45">Perangkat yang sedang masuk ke akun toko Anda.</p>
                    </div>
                    <form method="POST" action="{{ route('rental.settings.sesi.akhiri-lain') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 text-[11px] font-semibold text-red-600 transition hover:underline">
                            <i class="fa-solid fa-arrow-right-from-bracket text-[10px]"></i> Akhiri semua sesi lain
                        </button>
                    </form>
                </div>

                <div class="divide-y divide-line/12">
                    @forelse ($sesi as $item)
                        <div class="flex flex-wrap items-center gap-3 px-5 py-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sand text-ink/55">
                                <i class="fa-solid fa-{{ in_array($item['sistem'], ['Android', 'iOS'], true) ? 'mobile-screen' : 'laptop' }} text-[12px]"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[13px] font-semibold text-ink">{{ $item['peramban'] }} di {{ $item['sistem'] }}</p>
                                <p class="text-[11px] text-ink/45">{{ $item['alamat'] }} · {{ $item['terakhir'] }}</p>
                            </div>
                            <div class="ml-auto">
                                @if ($item['aktif'])
                                    <span class="chip bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span> Sesi saat ini
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('rental.settings.sesi.akhiri', $item['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] font-semibold text-red-600 transition hover:underline">Akhiri</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="px-5 py-6 text-center text-[12px] text-ink/45">Tidak ada sesi tercatat.</p>
                    @endforelse
                </div>
            </section>

            <section class="reveal overflow-hidden rounded-2xl border border-red-200 bg-red-50/80 p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    </span>
                    <div class="flex-1">
                        <h2 class="text-[15px] font-semibold text-red-700">{{ $toko->aktif ? 'Nonaktifkan Toko' : 'Toko Anda Sedang Nonaktif' }}</h2>
                        <p class="mt-1 text-[12px] leading-relaxed text-red-700/80">
                            {{ $toko->aktif
                                ? 'Toko Anda akan disembunyikan dari katalog publik. Anda bisa mengaktifkan kembali kapan saja dengan login.'
                                : 'Toko Anda saat ini tidak tampil di katalog publik. Aktifkan kembali agar pendaki dapat menyewa alat Anda.' }}
                        </p>

                        <form method="POST" action="{{ route('rental.settings.aktif') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl border px-4 py-2.5 text-[12px] font-semibold transition
                                    {{ $toko->aktif ? 'border-red-300 bg-panel text-red-600 hover:bg-red-100' : 'border-emerald-300 bg-panel text-emerald-700 hover:bg-emerald-50' }}">
                                <i class="fa-solid fa-{{ $toko->aktif ? 'power-off' : 'circle-check' }} text-[11px]"></i>
                                {{ $toko->aktif ? 'Nonaktifkan Toko Saya' : 'Aktifkan Toko Saya' }}
                            </button>
                        </form>
                        <p class="mt-2 text-[10px] text-red-700/60"><i class="fa-solid fa-circle-info mr-1"></i> Data inventaris dan riwayat transaksi tidak dihapus.</p>
                    </div>
                </div>
            </section>
        </div>
    @endif

    @if ($tab === 'preferensi')
        <div class="space-y-6">
            <section class="reveal card overflow-hidden">
                <div class="border-b border-line/10 px-5 py-4">
                    <h2 class="font-serif text-lg text-ink">Preferensi Notifikasi</h2>
                    <p class="mt-0.5 text-[12px] text-ink/45">Pilih jenis pemberitahuan yang ingin Anda terima untuk operasional toko.</p>
                </div>

                <form method="POST" action="{{ route('rental.settings.notifikasi') }}">
                    @csrf
                    <div class="divide-y divide-line/12">
                        @foreach ($daftarNotifikasi as $kunci => $label)
                            <label class="flex cursor-pointer items-center gap-4 px-5 py-4">
                                <div class="min-w-0 flex-1">
                                    <p class="text-[13px] font-semibold text-ink">{{ $label }}</p>
                                    <p class="text-[11px] text-ink/45">
                                        {{ match ($kunci) {
                                            'pesanan_baru' => 'Terima notifikasi saat ada pesanan baru masuk.',
                                            'pengembalian_terlambat' => 'Terima peringatan saat alat belum dikembalikan.',
                                            'stok_rendah' => 'Terima notifikasi saat stok alat tinggal sedikit.',
                                            default => 'Terima info promo dan tips dari RinjaniGuide.',
                                        } }}
                                    </p>
                                </div>
                                <span class="relative inline-flex h-6 w-11 shrink-0 items-center">
                                    <input type="checkbox" name="{{ $kunci }}" value="1" class="peer sr-only"
                                        @checked(old($kunci, $notifikasi[$kunci] ?? true))>
                                    <span class="h-6 w-11 rounded-full bg-line/20 transition peer-checked:bg-emerald-500"></span>
                                    <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-panel shadow transition peer-checked:translate-x-5"></span>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end border-t border-line/10 px-5 py-4">
                        <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                            <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Preferensi
                        </button>
                    </div>
                </form>
            </section>

            <section class="reveal card overflow-hidden">
                <div class="border-b border-line/10 px-5 py-4">
                    <h2 class="font-serif text-lg text-ink">Pengaturan Stok &amp; Jam Operasional</h2>
                    <p class="mt-0.5 text-[12px] text-ink/45">Atur ambang batas peringatan stok dan jam layanan toko.</p>
                </div>

                <form method="POST" action="{{ route('rental.settings.operasional') }}" class="space-y-5 p-5">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="field-label" for="batas_stok_minimum">Batas minimum stok</label>
                            <div class="flex items-center gap-2">
                                <input id="batas_stok_minimum" name="batas_stok_minimum" type="number" min="1" max="999"
                                    value="{{ old('batas_stok_minimum', $toko->batas_stok_minimum) }}" class="field text-center font-semibold">
                                <span class="text-[11px] text-ink/40">unit</span>
                            </div>
                            <p class="mt-1 text-[11px] text-ink/40">Notifikasi dikirim saat stok di bawah angka ini.</p>
                        </div>

                        <div class="space-y-3 sm:pt-6">
                            <label class="flex cursor-pointer items-center gap-3 text-[12px] text-ink/70">
                                <input type="checkbox" name="auto_tutup_kosong" value="1" class="h-4 w-4 rounded border-line/30 text-brand-orange focus:ring-brand-orange"
                                    @checked(old('auto_tutup_kosong', $toko->auto_tutup_kosong))>
                                Auto-tutup alat kosong
                            </label>
                            <label class="flex cursor-pointer items-center gap-3 text-[12px] text-ink/70">
                                <input type="checkbox" name="tutup_hari_libur" value="1" class="h-4 w-4 rounded border-line/30 text-brand-orange focus:ring-brand-orange"
                                    @checked(old('tutup_hari_libur', $toko->tutup_hari_libur))>
                                Tutup pada hari libur nasional
                            </label>
                        </div>
                    </div>

                    <div class="grid gap-4 border-t border-line/10 pt-5 sm:grid-cols-3">
                        <div>
                            <label class="field-label" for="hari_buka">Hari buka</label>
                            <select id="hari_buka" name="hari_buka" class="field">
                                @foreach (['Senin–Sabtu', 'Setiap hari', 'Senin–Jumat'] as $hari)
                                    <option value="{{ $hari }}" @selected(old('hari_buka', $toko->hari_buka) === $hari)>{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="field-label" for="jam_buka">Jam buka (WITA)</label>
                            <input id="jam_buka" name="jam_buka" type="time" value="{{ old('jam_buka', $toko->jam_buka) }}" class="field">
                        </div>
                        <div>
                            <label class="field-label" for="jam_tutup">Jam tutup (WITA)</label>
                            <input id="jam_tutup" name="jam_tutup" type="time" value="{{ old('jam_tutup', $toko->jam_tutup) }}" class="field">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary sheen inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white">
                            <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Jam Operasional
                        </button>
                    </div>
                </form>
            </section>
        </div>
    @endif
@endsection
