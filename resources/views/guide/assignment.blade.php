@extends('layouts.guide')

@section('title', 'Detail Penugasan')
@section('header', 'Konfirmasi Serah Terima')
@section('subheader', 'Pastikan seluruh verifikasi fisik dan logistik telah selesai sebelum penugasan dimulai.')

@section('content')
    <a href="{{ route('guide.schedule') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-orange-500 mb-4">
        ← Kembali ke Jadwal
    </a>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold mb-4">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-semibold mb-4">⚠️ {{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
        <!-- Informasi pesanan & checklist -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#1e4035] text-white px-6 py-3 flex justify-between items-center">
                    <span class="text-sm font-bold">Form Konfirmasi (Interaktif)</span>
                    <span class="text-[10px] text-gray-300 uppercase tracking-wider">Mode Pemandu • Basecamp</span>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kode Pesanan</p>
                            <p class="text-xs text-gray-500"># {{ $pemesanan->kode_pemesanan }}</p>
                            <h2 class="text-2xl font-serif font-bold text-gray-900 mt-2">Serah Terima Penugasan</h2>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $pemesanan->kehadiran_pemandu_dikonfirmasi ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-600 border-orange-200' }}">
                            {{ $pemesanan->kehadiran_pemandu_dikonfirmasi ? 'Terkonfirmasi' : ucfirst($pemesanan->status) }}
                        </span>
                    </div>

                    <h3 class="text-sm font-bold text-gray-800 mb-3">👤 Data Pemesanan</h3>
                    <div class="flex flex-wrap items-center justify-between gap-4 bg-gray-50 border border-gray-100 rounded-xl p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-[#1e4035] text-white rounded-full flex items-center justify-center font-bold">
                                {{ mb_strtoupper(mb_substr($pemesanan->nama_ketua, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 flex items-center gap-2">{{ $pemesanan->nama_ketua }}
                                    <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded">Ketua Rombongan</span>
                                </p>
                                <p class="text-xs text-gray-500">{{ $pemesanan->email_ketua }}</p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', (string) $pemesanan->telepon_ketua)) }}"
                            target="_blank" rel="noopener"
                            class="border border-green-600 text-green-700 bg-white py-2 px-4 rounded-lg text-xs font-bold hover:bg-green-50">
                            Chat WhatsApp
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
                            <p class="text-[10px] text-gray-500 mb-1">Nomor WhatsApp</p>
                            <p class="text-sm font-bold text-gray-800">{{ $pemesanan->telepon_ketua }}</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
                            <p class="text-[10px] text-gray-500 mb-1">NIK Ketua</p>
                            <p class="text-sm font-bold text-gray-800">{{ $pemesanan->nik_ketua }}</p>
                        </div>
                    </div>

                    <div class="border border-dashed border-gray-300 rounded-xl p-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-lg">🪪</div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800">KTP_{{ \Illuminate\Support\Str::slug($pemesanan->nama_ketua, '_') }}</p>
                            <p class="text-[11px] text-gray-500">Akses berkas identitas dibatasi untuk pemandu yang ditugaskan.</p>
                        </div>
                        @if ($pemesanan->path_foto_ktp)
                            <a href="{{ route('guide.assignment.ktp', $pemesanan) }}" target="_blank"
                                class="text-xs font-bold text-orange-600 border border-orange-200 bg-orange-50 px-3 py-2 rounded-lg hover:bg-orange-100">Lihat KTP</a>
                        @else
                            <span class="text-xs text-gray-400">Tidak ada berkas</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4">🏔️ Detail Pendakian</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jalur Pendakian</p>
                        <p class="font-bold text-gray-800">{{ $pemesanan->rute ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Total Durasi</p>
                        <p class="font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::durasi((int) $pemesanan->total_hari) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Mulai</p>
                        <p class="font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::tanggal($pemesanan->tanggal_mulai) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Selesai</p>
                        <p class="font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::tanggal($pemesanan->tanggal_selesai) }}</p>
                    </div>
                </div>
            </div>

            @unless ($pemesanan->kehadiran_pemandu_dikonfirmasi)
                <form method="POST" action="{{ route('guide.assignment.konfirmasi', $pemesanan) }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6" id="form-konfirmasi">
                    @csrf

                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-bold text-gray-800">☑️ Checklist Pertemuan</h3>
                        <span class="bg-[#1e4035] text-white text-[10px] font-bold px-3 py-1 rounded">Wajib 5/5</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Centang semua item sebelum konfirmasi penugasan.</p>

                    @foreach ([
                        1 => 'Bertemu dengan ketua rombongan',
                        2 => 'Memverifikasi KTP ketua rombongan',
                        3 => 'Menjelaskan rencana perjalanan singkat',
                        4 => 'Memastikan logistik pemandu siap',
                        5 => 'Menyepakati jam keberangkatan',
                    ] as $nilai => $teks)
                        <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-4 py-3 mb-2 cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="checklist[]" value="{{ $nilai }}" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500 js-checklist">
                            <span class="text-sm text-gray-700">{{ $teks }}</span>
                        </label>
                    @endforeach

                    @error('checklist')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-between items-center text-xs text-gray-500 mt-4 mb-2">
                        <span id="label-progress">0 dari 5 item dicentang</span>
                        <span class="font-bold" id="label-persen">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                        <div class="bg-orange-500 h-2 rounded-full transition-all" id="bar-progress" style="width: 0%"></div>
                    </div>

                    @if ($bolehKonfirmasi)
                        <button type="submit" id="tombol-konfirmasi" disabled
                            class="w-full bg-gray-300 text-white font-bold py-3.5 rounded-lg cursor-not-allowed">
                            ✔️ Konfirmasi Serah Terima
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">Tombol aktif setelah semua item dicentang.</p>
                    @else
                        <button type="button" disabled class="w-full bg-gray-300 text-white font-bold py-3.5 rounded-lg cursor-not-allowed">
                            🔒 Konfirmasi belum tersedia
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">
                            {{ $pemesanan->status !== 'paid' ? 'Pesanan belum dibayar.' : 'Tanggal pendakian sudah berlalu.' }}
                        </p>
                    @endif
                </form>

                <script>
                    (function () {
                        const kotak = Array.from(document.querySelectorAll('.js-checklist'));
                        const tombol = document.getElementById('tombol-konfirmasi');
                        const bar = document.getElementById('bar-progress');
                        const label = document.getElementById('label-progress');
                        const persen = document.getElementById('label-persen');

                        function perbarui() {
                            const jumlah = kotak.filter((item) => item.checked).length;
                            const nilai = Math.round((jumlah / kotak.length) * 100);

                            label.textContent = jumlah + ' dari ' + kotak.length + ' item dicentang';
                            persen.textContent = nilai + '%';
                            bar.style.width = nilai + '%';

                            if (tombol) {
                                const lengkap = jumlah === kotak.length;
                                tombol.disabled = !lengkap;
                                tombol.classList.toggle('bg-orange-500', lengkap);
                                tombol.classList.toggle('hover:bg-orange-600', lengkap);
                                tombol.classList.toggle('cursor-not-allowed', !lengkap);
                                tombol.classList.toggle('bg-gray-300', !lengkap);
                            }
                        }

                        kotak.forEach((item) => item.addEventListener('change', perbarui));
                        perbarui();
                    })();
                </script>
            @endunless
        </div>

        <!-- Ringkasan status -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-[#1e4035] text-white px-6 py-3 flex justify-between items-center">
                <span class="text-sm font-bold">State Sukses (Hasil Konfirmasi)</span>
                <span class="text-[10px] text-gray-300 uppercase tracking-wider">Status: Aktif Mendampingi</span>
            </div>

            <div class="p-8 text-center">
                @if ($pemesanan->kehadiran_pemandu_dikonfirmasi)
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">✅</div>
                    <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Serah Terima Berhasil</h2>
                    <p class="text-sm text-gray-500 mb-8">Anda telah bertemu dengan ketua rombongan. Selamat mendampingi pendakian Gunung Rinjani dan utamakan keselamatan!</p>
                @else
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">🧭</div>
                    <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Menunggu Konfirmasi</h2>
                    <p class="text-sm text-gray-500 mb-8">Lengkapi checklist pertemuan di samping, lalu konfirmasi serah terima di basecamp.</p>
                @endif

                <div class="text-left border border-gray-200 rounded-xl divide-y divide-gray-100 text-sm">
                    <div class="flex justify-between px-4 py-3">
                        <span class="text-gray-500">Kode Reservasi</span>
                        <span class="font-bold text-gray-900">{{ $pemesanan->kode_pemesanan }}</span>
                    </div>
                    <div class="flex justify-between px-4 py-3">
                        <span class="text-gray-500">Waktu Konfirmasi</span>
                        <span class="font-semibold text-gray-900">
                            {{ $pemesanan->waktu_konfirmasi_pemandu ? \Modules\Guide\Support\Formatter::tanggal($pemesanan->waktu_konfirmasi_pemandu).', '.$pemesanan->waktu_konfirmasi_pemandu->format('H:i').' WIB' : '—' }}
                        </span>
                    </div>
                    <div class="flex justify-between px-4 py-3">
                        <span class="text-gray-500">Ketua Rombongan</span>
                        <span class="font-semibold text-gray-900">{{ $pemesanan->nama_ketua }}</span>
                    </div>
                    <div class="flex justify-between px-4 py-3">
                        <span class="text-gray-500">Status</span>
                        <span class="font-bold {{ $pemesanan->kehadiran_pemandu_dikonfirmasi ? 'text-green-600' : 'text-orange-600' }}">
                            {{ $pemesanan->kehadiran_pemandu_dikonfirmasi ? 'Sedang Berjalan' : 'Menunggu Pertemuan' }}
                        </span>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-6 bg-green-50 border border-green-100 rounded-lg p-3 text-left">
                    ℹ️ Pengingat APGI: Laporkan posisi pos istirahat secara berkala melalui radio komunikasi atau koordinasi Basecamp.
                </p>
            </div>
        </div>
    </div>
@endsection
