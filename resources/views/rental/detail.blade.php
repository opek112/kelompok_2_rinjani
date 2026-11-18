@extends('layouts.app')

@section('content')
    @php
        use Modules\Rental\Support\Rupiah;
        use Modules\Rental\Support\Tanggal;

        $mulaiDefault = old('tanggal_mulai', now()->addDay()->toDateString());
        $selesaiDefault = old('tanggal_selesai', now()->addDays(3)->toDateString());
    @endphp

    <section class="py-8" x-data="{ aktif: 0, galeri: @js($galeri) }">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-5">
                <a href="{{ route('home') }}" class="hover:text-brand-orange"><i class="fa-solid fa-house"></i> Home</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('rental') }}" class="hover:text-brand-orange">Rental</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-brand-dark font-semibold">{{ $peralatan->nama }}</span>
            </nav>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Galeri -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-3">
                <div class="lg:col-span-4 relative rounded-2xl overflow-hidden h-[280px] md:h-[420px]">
                    <template x-for="(foto, index) in galeri" :key="index">
                        <img :src="foto" x-show="aktif === index" alt="{{ $peralatan->nama }}" class="w-full h-full object-cover absolute inset-0">
                    </template>
                    <span class="absolute bottom-4 right-4 bg-black/60 text-white text-xs px-3 py-1 rounded-full">
                        <i class="fa-regular fa-images mr-1"></i> <span x-text="aktif + 1"></span> / {{ count($galeri) }}
                    </span>
                </div>
                @foreach ($galeri as $index => $foto)
                    <button type="button" @click="aktif = {{ $index }}"
                        class="relative rounded-xl overflow-hidden h-20 border-2 transition"
                        :class="aktif === {{ $index }} ? 'border-brand-orange' : 'border-transparent opacity-80 hover:opacity-100'">
                        <img src="{{ $foto }}" alt="Foto {{ $index + 1 }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                <!-- Kolom Kiri -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-green-50 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $peralatan->kategori }}</span>
                        <span class="bg-green-50 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fa-solid fa-circle-check mr-1"></i> Terverifikasi Rinjani
                        </span>
                    </div>

                    <div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold text-brand-dark">{{ $peralatan->nama }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mt-3">
                            <span class="text-yellow-500 font-semibold"><i class="fa-solid fa-star"></i> {{ number_format($peralatan->rating, 1, ',', '.') }}</span>
                            <a href="#ulasan" class="text-gray-500 hover:text-brand-orange">({{ $peralatan->jumlah_ulasan }} Ulasan)</a>
                            <span><i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> Pos {{ $peralatan->pos }}</span>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-brand-dark rounded-full flex items-center justify-center text-white">
                                <i class="fa-solid fa-store text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark flex items-center gap-1.5">
                                    {{ $peralatan->toko?->nama_toko }}
                                    <i class="fa-solid fa-circle-check text-green-600 text-xs"></i>
                                </p>
                                <p class="text-xs text-gray-500">Mitra toko rental resmi TNGR</p>
                            </div>
                        </div>
                        <a href="{{ route('rental', ['toko' => $peralatan->toko_rental_id]) }}" class="text-sm font-semibold text-brand-orange hover:underline">
                            Lihat Toko Rental <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-[#FFF8F0] border border-orange-200 rounded-2xl p-5">
                        <p class="font-bold text-brand-dark flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-location-dot text-brand-orange"></i> Lokasi Pengambilan
                        </p>
                        <p class="text-sm text-gray-600">{{ $peralatan->toko?->alamat }}</p>
                        <p class="text-xs text-gray-500 mt-1">Ambil di Basecamp / Homestay pos pendakian.</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ([
                            ['fa-solid fa-users', 'Kapasitas', $peralatan->kapasitas ?? '-'],
                            ['fa-solid fa-weight-hanging', 'Berat', $peralatan->berat ?? '-'],
                            ['fa-solid fa-layer-group', 'Material', $peralatan->material ?? '-'],
                            ['fa-solid fa-ruler-combined', 'Dimensi', $peralatan->dimensi ?? '-'],
                        ] as [$ikon, $label, $nilai])
                            <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
                                <i class="{{ $ikon }} text-brand-dark mb-2 block"></i>
                                <p class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">{{ $label }}</p>
                                <p class="text-sm font-semibold text-brand-dark mt-0.5">{{ $nilai }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-brand-dark mb-3">Deskripsi Produk</h2>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $peralatan->deskripsi }}</p>
                        <p class="text-sm text-gray-600 leading-relaxed mt-3">
                            Semua unit dicuci dan diperiksa sebelum diserahkan. Peralatan dirawat berkala oleh
                            {{ $peralatan->toko?->nama_toko }} dan didistribusikan dari pos {{ $peralatan->pos }} agar
                            logistik pendakian lebih ringkas.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-5">
                            @foreach ([
                                ['Keamanan Maksimal', 'Rangka aluminium ringan dengan sambungan kuat dan tahan angin puncak.'],
                                ['Bersih & Higienis', 'Unit dicuci, dijemur, dan diperiksa kelengkapannya sebelum diserahkan.'],
                                ['Material Fleksibel', 'Bahan tahan air dan mudah dipasang meski di medan terbuka.'],
                                ['Ringan & Kompak', 'Mudah dibawa bersama carrier 60L tanpa menambah beban berlebih.'],
                            ] as [$judul, $isi])
                                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                                    <p class="text-sm font-bold text-brand-dark flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check text-green-600 text-xs"></i> {{ $judul }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $isi }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-brand-dark">Spesifikasi & Ketentuan Sewa</h2>
                        </div>
                        <dl class="divide-y divide-gray-100 text-sm">
                            @foreach ([
                                ['Kategori Produk', $peralatan->kategori.' ('.$peralatan->kapasitas.')'],
                                ['Kondisi Barang', 'Sangat baik (dicuci, kering, & diperiksa sebelum serah terima)'],
                                ['Siap Terpakai', '1 unit di basecamp Pos '.$peralatan->pos],
                                ['Total Retail', 'Rentang harga dinamis per pemesanan'],
                                ['Jam Operasional', 'Pos pendakian buka 06.30 – 20.00 WITA (Senin – Minggu)'],
                                ['Jaminan Sewa', 'KTP / Paspor dan jaminan identitas lainnya (SIM/Kartu Pelajar)'],
                            ] as [$label, $nilai])
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 px-6 py-4">
                                    <dt class="text-gray-500 md:col-span-1">{{ $label }}</dt>
                                    <dd class="text-brand-dark font-medium md:col-span-2">{{ $nilai }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6" id="ulasan">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-brand-dark">Ulasan Penyewa ({{ $peralatan->jumlah_ulasan }})</h2>
                            <span class="text-sm text-brand-orange font-semibold">Lihat Semua Ulasan</span>
                        </div>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-3xl font-bold text-brand-dark">{{ number_format($peralatan->rating, 1, ',', '.') }}</span>
                            <div>
                                <div class="text-yellow-500 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star{{ $i <= round($peralatan->rating) ? '' : ' text-gray-200' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-500">{{ $peralatan->jumlah_ulasan }} ulasan terverifikasi</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($ulasan as $review)
                                <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/60">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-brand-dark text-white text-xs font-bold flex items-center justify-center">{{ $review['inisial'] }}</div>
                                        <div>
                                            <p class="text-sm font-semibold text-brand-dark">{{ $review['nama'] }}</p>
                                            <p class="text-[10px] text-gray-500">{{ $review['tanggal'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-yellow-500 text-[11px] mt-3">
                                        @for ($i = 1; $i <= $review['rating']; $i++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2 leading-relaxed">{{ $review['isi'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kartu Pemesanan -->
                <div class="lg:col-span-1">
                    <form method="POST" action="{{ route('rental.cart.add', $peralatan) }}"
                        class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm lg:sticky lg:top-24"
                        x-data="{
                            jumlah: {{ (int) old('jumlah', 1) }},
                            mulai: '{{ $mulaiDefault }}',
                            selesai: '{{ $selesaiDefault }}',
                            tarif: {{ (int) $peralatan->tarif_harian }},
                            maks: {{ (int) $peralatan->jumlah_stok }},
                            get durasi() {
                                const a = new Date(this.mulai), b = new Date(this.selesai);
                                const d = Math.floor((b - a) / 86400000) + 1;
                                return (isNaN(d) || d < 1) ? 1 : d;
                            },
                            get subtotal() { return this.tarif * this.jumlah * this.durasi; },
                            get subtotalTeks() { return 'Rp ' + this.subtotal.toLocaleString('id-ID'); },
                            tambah() { if (this.jumlah < this.maks) this.jumlah++; },
                            kurang() { if (this.jumlah > 1) this.jumlah--; }
                        }">
                        @csrf

                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-bold text-brand-orange text-2xl">
                                    {{ Rupiah::format($peralatan->tarif_harian) }}
                                    <span class="text-xs text-gray-500 font-normal">/hari</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-circle text-[6px]"></i> Stok: {{ $peralatan->jumlah_stok }} unit tersedia
                            </span>
                        </div>

                        <div class="mt-5 space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai Sewa</label>
                                <input type="date" name="tanggal_mulai" x-model="mulai" min="{{ now()->toDateString() }}" required
                                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Pengembalian</label>
                                <input type="date" name="tanggal_selesai" x-model="selesai" min="{{ now()->toDateString() }}" required
                                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                <div class="text-sm">
                                    <p class="font-semibold text-brand-dark">Durasi Sewa</p>
                                    <p class="text-xs text-gray-500" x-text="durasi + ' Hari / ' + Math.max(1, durasi - 1) + ' Malam'"></p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-brand-dark">Jumlah Unit Sewa</p>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" @click="kurang()" class="w-9 h-9 text-gray-600 hover:bg-gray-50">−</button>
                                    <input type="number" name="jumlah" x-model.number="jumlah" min="1" max="{{ $peralatan->jumlah_stok }}"
                                        class="w-12 h-9 text-center text-sm border-x border-gray-200 outline-none">
                                    <button type="button" @click="tambah()" class="w-9 h-9 text-gray-600 hover:bg-gray-50">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 bg-gray-50 rounded-xl p-4 text-sm space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span x-text="jumlah + ' unit × ' + durasi + ' hari × ' + '{{ Rupiah::format($peralatan->tarif_harian) }}'"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Perlengkapan & asuransi</span>
                                <span>Rp 5.000</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                                <span class="font-bold text-brand-dark">Subtotal</span>
                                <span class="font-bold text-brand-orange text-lg" x-text="subtotalTeks"></span>
                            </div>
                        </div>

                        <button type="submit" name="aksi" value="keranjang"
                            class="w-full bg-brand-orange text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition mt-4 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                        </button>
                        <button type="submit" name="aksi" value="langsung"
                            class="w-full border border-brand-dark text-brand-dark py-3 rounded-xl font-semibold hover:bg-brand-dark hover:text-white transition mt-2">
                            Sewa Langsung
                        </button>

                        <p class="text-[11px] text-gray-500 text-center mt-3">
                            <i class="fa-solid fa-lock"></i> Perlindungan klaim & asuransi alat dijamin oleh TNGR
                        </p>
                    </form>
                </div>
            </div>

            <!-- Toko Ini Juga Menyediakan -->
            @if ($serupa->isNotEmpty())
                <div class="mt-14">
                    <h2 class="text-2xl font-serif font-bold text-brand-dark">Toko Ini Juga Menyediakan</h2>
                    <p class="text-sm text-gray-500 mt-1">Perlengkapan pendakian lainnya dari {{ $peralatan->toko?->nama_toko }}.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        @foreach ($serupa as $lain)
                            <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                                <a href="{{ route('rental.detail', $lain) }}" class="relative h-44 block overflow-hidden">
                                    <img src="{{ $lain->fotoUtama() }}" alt="{{ $lain->nama }}" class="w-full h-full object-cover">
                                    <span class="absolute top-3 left-3 bg-white/95 text-brand-dark text-[11px] font-bold px-2.5 py-1 rounded-full">Pos {{ $lain->pos }}</span>
                                </a>
                                <div class="p-5 flex-grow flex flex-col justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">{{ $lain->toko?->nama_toko }}</p>
                                        <h3 class="font-bold text-brand-dark mt-1">{{ $lain->nama }}</h3>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $lain->deskripsi }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-4">
                                        <p class="font-bold text-brand-orange">{{ Rupiah::format($lain->tarif_harian) }}
                                            <span class="text-xs text-gray-500 font-normal">/hari</span>
                                        </p>
                                        <a href="{{ route('rental.detail', $lain) }}" class="border border-gray-800 text-brand-dark px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-brand-dark hover:text-white transition">Sewa Alat</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
