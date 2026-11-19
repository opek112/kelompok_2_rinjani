@extends('layouts.rental')

@section('title', 'Catat Kondisi Pengembalian')
@section('subtitle', 'Periksa setiap alat, catat kerusakan atau kehilangan, lalu simpan pengembalian.')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $nomorWa = '62'.ltrim(preg_replace('/\D/', '', (string) $pesanan->telepon_ketua), '0');
    @endphp

    <a href="{{ route('rental.returns') }}"
        class="reveal mb-5 inline-flex items-center gap-2 text-[12px] font-medium text-ink/55 transition hover:text-brand-orange">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Daftar Pengembalian
    </a>

    <!-- Identitas pesanan -->
    <section class="reveal card mb-6 overflow-hidden">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-2 border-b border-line/10 px-5 py-3">
            <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink/55">{{ $pesanan->kode_pemesanan }}</span>
            <span class="hidden h-3 w-px bg-line/16 sm:block"></span>
            <span class="text-[11px] text-ink/45"><i class="fa-solid fa-location-dot mr-1"></i>{{ $toko->lokasi_pos ?: $toko->nama_toko }}</span>
            <span class="chip ml-auto ring-1 {{ $terlambat ? 'bg-red-50 text-red-600 ring-red-100' : 'bg-amber-50 text-amber-700 ring-amber-100' }}">
                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                {{ $terlambat ? 'Terlambat '.$pesanan->tanggal_selesai->diffInDays(today()).' hari' : 'Dalam masa sewa' }}
            </span>
        </div>

        <div class="grid gap-5 p-5 sm:grid-cols-3">
            <div>
                <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Pemesan</p>
                <p class="mt-1 text-[13px] font-semibold text-ink">{{ $pesanan->nama_ketua }}</p>
                <p class="text-[11px] text-ink/45">{{ $pesanan->telepon_ketua ?: $pesanan->email_ketua }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Tanggal Sewa</p>
                <p class="mt-1 text-[13px] font-semibold text-ink">{{ Tanggal::rentang($pesanan->tanggal_mulai, $pesanan->tanggal_selesai) }}</p>
                <p class="text-[11px] text-ink/45">Durasi {{ $pesanan->total_hari }} hari</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.14em] text-ink/35">Tanggal Pengembalian</p>
                <p class="mt-1 text-[13px] font-semibold {{ $terlambat ? 'text-red-600' : 'text-ink' }}">{{ Tanggal::panjang($pesanan->tanggal_selesai) }}</p>
                <p class="text-[11px] text-ink/45">Diserahkan {{ $pesanan->waktu_serah_terima?->translatedFormat('d M Y, H:i') }} WIB</p>
            </div>
        </div>
    </section>

    <form id="form-pengembalian" method="POST" action="{{ route('rental.returns.store', $pesanan) }}" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr] lg:items-start">
            <div class="space-y-6">
                <!-- Kondisi alat -->
                <section class="reveal card overflow-hidden">
                    <div class="border-b border-line/10 px-5 py-4">
                        <h2 class="font-serif text-lg text-ink">Kondisi Alat</h2>
                        <p class="mt-0.5 text-[12px] text-ink/45">Periksa setiap alat dan catat kondisinya secara cermat sebelum diverifikasi.</p>

                        <div class="mt-3 flex flex-wrap items-center gap-3 text-[11px] text-ink/50">
                            <span class="font-medium text-ink/40">Legenda:</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Baik</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Perlu Perbaikan</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Rusak</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span> Hilang</span>
                        </div>
                    </div>

                    <div class="divide-y divide-line/12">
                        @foreach ($pesanan->items as $item)
                            @php
                                $catatanLama = $item->pengembalian?->catatan;
                            @endphp
                            <div class="p-5" data-baris-alat>
                                <div class="flex items-start gap-3">
                                    <img src="{{ $item->peralatan?->fotoUtama() }}" alt="{{ $item->peralatan?->nama }}"
                                        class="h-14 w-14 shrink-0 rounded-xl object-cover ring-1 ring-line/12" loading="lazy">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[13px] font-semibold text-ink">{{ $item->peralatan?->nama ?? 'Alat dihapus' }}</p>
                                        <p class="text-[11px] text-ink/45">Jumlah: {{ $item->jumlah }} unit · {{ $item->peralatan?->kategori ?: 'Umum' }}</p>
                                    </div>
                                    <span class="chip bg-sand text-ink/60 ring-1 ring-line/12">{{ $item->jumlah }} unit</span>
                                </div>

                                <div class="mt-4 grid gap-3 sm:grid-cols-4">
                                    <div>
                                        <label class="field-label" for="baik-{{ $item->id }}">Baik</label>
                                        <input id="baik-{{ $item->id }}" type="number" min="0" max="{{ $item->jumlah }}"
                                            name="items[{{ $item->id }}][baik]" value="{{ old('items.'.$item->id.'.baik', $item->pengembalian?->jumlah_baik ?? $item->jumlah) }}"
                                            class="field text-center font-semibold">
                                    </div>
                                    <div>
                                        <label class="field-label" for="rusak-{{ $item->id }}">Rusak</label>
                                        <input id="rusak-{{ $item->id }}" type="number" min="0" max="{{ $item->jumlah }}"
                                            name="items[{{ $item->id }}][rusak]" value="{{ old('items.'.$item->id.'.rusak', $item->pengembalian?->jumlah_rusak ?? 0) }}"
                                            class="field text-center font-semibold">
                                    </div>
                                    <div>
                                        <label class="field-label" for="hilang-{{ $item->id }}">Hilang</label>
                                        <input id="hilang-{{ $item->id }}" type="number" min="0" max="{{ $item->jumlah }}"
                                            name="items[{{ $item->id }}][hilang]" value="{{ old('items.'.$item->id.'.hilang', $item->pengembalian?->jumlah_hilang ?? 0) }}"
                                            class="field text-center font-semibold">
                                    </div>
                                    <div>
                                        <label class="field-label" for="denda-{{ $item->id }}">Denda (Rp)</label>
                                        <input id="denda-{{ $item->id }}" type="number" min="0" step="500"
                                            name="items[{{ $item->id }}][denda]" value="{{ old('items.'.$item->id.'.denda', (int) ($item->pengembalian?->denda ?? 0)) }}"
                                            data-denda class="field text-right font-semibold">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="field-label" for="catatan-{{ $item->id }}">Catatan keterangan</label>
                                    <input id="catatan-{{ $item->id }}" type="text" maxlength="300"
                                        name="items[{{ $item->id }}][catatan]" value="{{ old('items.'.$item->id.'.catatan', $catatanLama) }}"
                                        placeholder="Contoh: robek di bagian resleting, tidak dikembalikan"
                                        class="field">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Ringkasan denda -->
                <section class="reveal card overflow-hidden">
                    <div class="flex items-center justify-between border-b border-line/10 px-5 py-4">
                        <h2 class="font-serif text-lg text-ink">Ringkasan Denda</h2>
                        <span data-jumlah-denda class="chip bg-amber-50 text-amber-700 ring-1 ring-amber-100">0 pelanggaran</span>
                    </div>
                    <div class="space-y-2 px-5 py-4 text-[12px] text-ink/60">
                        @foreach ($pesanan->items as $item)
                            <div class="flex items-center justify-between gap-3" data-ringkas="{{ $item->id }}">
                                <span>{{ $item->peralatan?->nama ?? 'Alat' }} <span class="text-ink/35">· denda</span></span>
                                <span class="font-semibold text-ink" data-ringkas-nilai>{{ Rupiah::format($item->pengembalian?->denda ?? 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between border-t border-line/10 bg-sand/40 px-5 py-4">
                        <span class="text-[12px] font-semibold uppercase tracking-[0.12em] text-ink/45">Total Denda</span>
                        <span class="text-lg font-semibold text-brand-orange" data-total-denda>Rp 0</span>
                    </div>
                    <p class="border-t border-line/10 px-5 py-3 text-[11px] leading-relaxed text-ink/45">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Denda ditagihkan ke pemesan di luar sistem. Pemesan dapat membayar tunai di basecamp atau melalui QRIS toko.
                    </p>
                </section>

                <!-- Catatan & foto -->
                <section class="reveal card overflow-hidden">
                    <div class="border-b border-line/10 px-5 py-4">
                        <h2 class="font-serif text-lg text-ink">Foto Bukti &amp; Catatan</h2>
                        <p class="mt-0.5 text-[12px] text-ink/45">Unggah foto kondisi alat yang rusak atau hilang sebagai bukti.</p>
                    </div>

                    <div class="space-y-4 p-5">
                        <div>
                            <label class="field-label" for="foto">Foto bukti kondisi</label>
                            <label for="foto"
                                class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-line/25 bg-sand/40 px-4 py-8 text-center transition hover:border-brand-orange/50">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-panel text-ink/50"><i class="fa-solid fa-camera"></i></span>
                                <span class="text-[13px] font-semibold text-ink">Klik untuk unggah atau seret file ke sini</span>
                                <span class="text-[11px] text-ink/45">Maksimal 5 foto · JPG/PNG/WEBP · 3 MB per file</span>
                            </label>
                            <input id="foto" type="file" name="foto[]" accept="image/*" multiple class="sr-only" data-foto>
                            <div class="mt-3 grid grid-cols-3 gap-2 sm:grid-cols-5" data-pratinjau></div>
                        </div>

                        <div>
                            <label class="field-label" for="catatan">Catatan pengembalian (opsional)</label>
                            <textarea id="catatan" name="catatan" rows="3" maxlength="1000"
                                placeholder="Ringkasan kondisi alat saat kembali, permintaan pemesan, atau kesepakatan denda."
                                class="field resize-none">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </section>

                <!-- Checklist -->
                <section class="reveal card overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-line/10 px-5 py-4">
                        <div>
                            <h2 class="font-serif text-lg text-ink">Checklist Pengembalian</h2>
                            <p class="mt-0.5 text-[12px] text-ink/45">Centang semua sebelum menyimpan.</p>
                        </div>
                        <span class="text-[11px] font-semibold text-brand-orange" data-progres>0 dari 4 item dicentang (0%)</span>
                    </div>
                    <div class="h-1 w-full bg-sand">
                        <div class="h-1 w-0 rounded-r-full bg-gradient-to-r from-emerald-500 to-emerald-400 transition-all duration-500" data-progres-bar></div>
                    </div>
                    <div class="space-y-2 p-5">
                        @foreach ([
                            'Semua alat telah dihitung jumlahnya',
                            'Semua kondisi sudah dicatat',
                            'Foto bukti sudah diunggah (bila ada kerusakan)',
                            'Denda (jika ada) sudah dikonfirmasi ke pemesan',
                        ] as $i => $teks)
                            <label class="flex items-center gap-3 rounded-xl border border-line/12 bg-panel px-3.5 py-3 text-[12px] text-ink/70 transition hover:border-brand-orange/35">
                                <input type="checkbox" name="checklist[]" value="{{ $i + 1 }}" data-checklist
                                    class="h-4 w-4 rounded border-line/30 text-brand-orange focus:ring-brand-orange">
                                {{ $teks }}
                            </label>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Panel aksi -->
            <aside class="space-y-4 lg:sticky lg:top-24">
                <section class="reveal card overflow-hidden">
                    <div class="h-1 bg-gradient-to-r from-brand-orange via-champagne to-emerald-500"></div>
                    <div class="p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                <i class="fa-solid fa-rotate-left text-sm"></i>
                            </span>
                            <div>
                                <p class="text-[13px] font-semibold text-ink">Simpan pengembalian</p>
                                <p class="text-[11px] text-ink/45">Stok alat kembali tersedia</p>
                            </div>
                        </div>

                        <dl class="mt-4 space-y-2 border-t border-line/10 pt-4 text-[12px]">
                            <div class="flex justify-between gap-3">
                                <dt class="text-ink/45">Kode pesanan</dt>
                                <dd class="font-semibold text-ink">{{ $pesanan->kode_pemesanan }}</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-ink/45">Total unit</dt>
                                <dd class="font-semibold text-ink">{{ $pesanan->items->sum('jumlah') }} unit</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-ink/45">Total denda</dt>
                                <dd class="font-semibold text-brand-orange" data-total-denda>Rp 0</dd>
                            </div>
                        </dl>

                        <button type="submit" data-simpan disabled
                            class="btn-primary sheen mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-45">
                            <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Kondisi Pengembalian
                        </button>
                        <p class="mt-2 text-center text-[10px] text-ink/40" data-pesan-tombol>
                            Tombol aktif setelah seluruh checklist dicentang.
                        </p>
                    </div>
                </section>

                <section class="reveal card p-5">
                    <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-ink/35">Butuh bantuan?</p>
                    <p class="mt-2 text-[12px] leading-relaxed text-ink/50">
                        Konfirmasi denda langsung ke pemesan agar tidak ada keberatan saat pengambilan barang.
                    </p>
                    <a href="https://wa.me/{{ $nomorWa }}?text={{ urlencode('Halo '.$pesanan->nama_ketua.', kami dari '.$toko->nama_toko.' ingin mengonfirmasi kondisi dan denda pengembalian pesanan '.$pesanan->kode_pemesanan.'.') }}"
                        target="_blank" rel="noopener"
                        class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-line/12 px-4 py-2.5 text-[12px] font-medium text-ink/70 transition hover:border-emerald-500/40 hover:text-emerald-700">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Pemesan
                    </a>
                </section>
            </aside>
        </div>
    </form>

    <script>
        (function () {
            const form = document.getElementById('form-pengembalian');
            if (!form) return;

            const rupiah = (nilai) => 'Rp ' + Math.round(nilai).toLocaleString('id-ID');

            // Total denda
            const inputsDenda = form.querySelectorAll('[data-denda]');
            const totalDenda = form.querySelectorAll('[data-total-denda]');

            const hitungDenda = () => {
                let total = 0;
                let pelanggaran = 0;

                inputsDenda.forEach((input) => {
                    const nilai = Number(input.value || 0);
                    total += nilai;
                    if (nilai > 0) pelanggaran += 1;

                    const baris = input.closest('[data-baris-alat]');
                    const id = input.id.replace('denda-', '');
                    const ringkas = document.querySelector('[data-ringkas="' + id + '"] [data-ringkas-nilai]');
                    if (ringkas) ringkas.textContent = rupiah(nilai);

                    if (baris) {
                        const rusak = Number(baris.querySelector('[name$="[rusak]"]')?.value || 0);
                        const hilang = Number(baris.querySelector('[name$="[hilang]"]')?.value || 0);
                        baris.classList.toggle('bg-red-50/40', rusak > 0 || hilang > 0);
                    }
                });

                totalDenda.forEach((el) => (el.textContent = rupiah(total)));

                const label = document.querySelector('[data-jumlah-denda]');
                if (label) label.textContent = pelanggaran + ' pelanggaran';
            };

            inputsDenda.forEach((input) => input.addEventListener('input', hitungDenda));
            hitungDenda();

            // Checklist
            const checklist = form.querySelectorAll('[data-checklist]');
            const tombol = form.querySelector('[data-simpan]');
            const progres = document.querySelector('[data-progres]');
            const bar = document.querySelector('[data-progres-bar]');
            const pesan = document.querySelector('[data-pesan-tombol]');

            const perbaruiChecklist = () => {
                const dicentang = [...checklist].filter((el) => el.checked).length;
                const persen = Math.round((dicentang / checklist.length) * 100);

                if (progres) progres.textContent = dicentang + ' dari ' + checklist.length + ' item dicentang (' + persen + '%)';
                if (bar) bar.style.width = persen + '%';
                if (tombol) tombol.disabled = dicentang < checklist.length;
                if (pesan) {
                    pesan.textContent = dicentang < checklist.length
                        ? 'Tombol aktif setelah seluruh checklist dicentang.'
                        : 'Semua checklist lengkap. Pengembalian siap disimpan.';
                }
            };

            checklist.forEach((el) => el.addEventListener('change', perbaruiChecklist));
            perbaruiChecklist();

            // Pratinjau foto
            const inputFoto = form.querySelector('[data-foto]');
            const pratinjau = form.querySelector('[data-pratinjau]');

            if (inputFoto && pratinjau) {
                inputFoto.addEventListener('change', () => {
                    pratinjau.innerHTML = '';
                    [...inputFoto.files].slice(0, 5).forEach((berkas) => {
                        const bungkus = document.createElement('div');
                        bungkus.className = 'relative aspect-square overflow-hidden rounded-lg border border-line/12';
                        const img = document.createElement('img');
                        img.className = 'h-full w-full object-cover';
                        img.src = URL.createObjectURL(berkas);
                        bungkus.appendChild(img);
                        pratinjau.appendChild(bungkus);
                    });
                });
            }
        })();
    </script>
@endsection
