<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Cek Status Verifikasi — RinjaniGuide Mitra</title>

    <script>
        (function () {
            try {
                if (localStorage.getItem('rg-tema') === 'gelap') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['"Playfair Display"', 'serif'] },
                    colors: { ink: '#0A231B', moss: '#11382A', champagne: '#C8A96B' },
                },
            },
        };
    </script>

    <style>
        :root {
            --ease: cubic-bezier(.22, 1, .36, 1);
            --ink: 10 35 27;
            --panel: 255 255 255;
            --canvas: 247 245 240;
            --sand: 242 238 229;
            --line: 26 54 38;
            --silhouette: 17 56 42;
            --silhouette-opacity: .10;
        }

        html.dark {
            --ink: 233 241 236;
            --panel: 18 40 32;
            --canvas: 8 22 17;
            --sand: 25 50 41;
            --line: 150 180 164;
            --silhouette: 148 190 168;
            --silhouette-opacity: .14;
            color-scheme: dark;
        }

        body {
            background-color: rgb(var(--canvas));
            color: rgb(var(--ink));
            background-image:
                radial-gradient(48rem 26rem at 84% -10%, rgba(200, 169, 107, .18), transparent 62%),
                radial-gradient(42rem 26rem at 4% 2%, rgba(17, 56, 42, .07), transparent 64%);
            transition: background-color .5s var(--ease), color .5s var(--ease);
        }

        html.dark body {
            background-image:
                radial-gradient(48rem 26rem at 84% -10%, rgba(200, 169, 107, .10), transparent 62%),
                radial-gradient(46rem 28rem at 2% 0%, rgba(46, 138, 104, .12), transparent 64%);
        }

        /* Siluet gunung pudar di belakang konten */
        .gunung {
            position: fixed;
            inset-inline: 0;
            bottom: 0;
            height: min(52vh, 520px);
            pointer-events: none;
            color: rgb(var(--silhouette));
            opacity: var(--silhouette-opacity);
            transition: opacity .6s var(--ease), color .6s var(--ease);
            z-index: 0;
        }

        .panel {
            background: rgb(var(--panel) / .94);
            border: 1px solid rgb(var(--line) / .12);
            box-shadow: 0 30px 80px -60px rgba(10, 35, 27, .55);
            backdrop-filter: blur(10px);
            transition: background .5s var(--ease), border-color .5s var(--ease);
        }

        .hairline { border-color: rgb(var(--line) / .12); }
        .soft { color: rgb(var(--ink) / .52); }
        .softer { color: rgb(var(--ink) / .38); }

        .reveal { opacity: 0; transform: translateY(22px); transition: opacity .9s var(--ease), transform .9s var(--ease); }
        .reveal.on { opacity: 1; transform: none; }

        @keyframes floaty { 0%, 100% { transform: translate3d(0,0,0) } 50% { transform: translate3d(0,-16px,0) } }
        .floaty { animation: floaty 12s ease-in-out infinite; }
        @keyframes pulseDot { 0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(52, 211, 153, .45) } 50% { opacity: .6; box-shadow: 0 0 0 8px rgba(52, 211, 153, 0) } }
        .dot-live { animation: pulseDot 2.6s ease-in-out infinite; }

        /* Chip status per tone */
        .tone-emerald { background: rgba(16, 185, 129, .12); color: #047857; border-color: rgba(16, 185, 129, .28); }
        .tone-amber { background: rgba(245, 158, 11, .14); color: #B45309; border-color: rgba(245, 158, 11, .32); }
        .tone-red { background: rgba(239, 68, 68, .12); color: #B91C1C; border-color: rgba(239, 68, 68, .3); }
        html.dark .tone-emerald { color: #6EE7B7; }
        html.dark .tone-amber { color: #FCD34D; }
        html.dark .tone-red { color: #FCA5A5; }

        .tone-icon-emerald { background: rgba(16, 185, 129, .13); color: #059669; }
        .tone-icon-amber { background: rgba(245, 158, 11, .15); color: #B45309; }
        .tone-icon-red { background: rgba(239, 68, 68, .13); color: #DC2626; }
        html.dark .tone-icon-emerald { color: #6EE7B7; }
        html.dark .tone-icon-amber { color: #FCD34D; }
        html.dark .tone-icon-red { color: #FCA5A5; }

        .btn-utama {
            background-image: linear-gradient(135deg, #F27A21 0%, #E4630B 55%, #C8A96B 160%);
            box-shadow: 0 18px 38px -20px rgba(226, 99, 11, .70);
            transition: transform .35s var(--ease), box-shadow .35s var(--ease);
        }
        .btn-utama:hover { transform: translateY(-2px); box-shadow: 0 24px 44px -20px rgba(226, 99, 11, .78); }

        .btn-garis { border: 1px solid rgb(var(--line) / .22); color: rgb(var(--ink) / .72); transition: border-color .35s var(--ease), color .35s var(--ease), background .35s var(--ease); }
        .btn-garis:hover { border-color: rgb(var(--line) / .38); color: rgb(var(--ink)); background: rgb(var(--sand) / .6); }

        .toggle-tema {
            border: 1px solid rgb(var(--line) / .16);
            background: rgb(var(--panel) / .75);
            color: rgb(var(--ink) / .6);
            transition: color .35s var(--ease), border-color .35s var(--ease), transform .35s var(--ease);
        }
        .toggle-tema:hover { color: #F27A21; border-color: rgba(242, 122, 33, .45); transform: translateY(-1px); }

        @media (prefers-reduced-motion: reduce) {
            .reveal, .floaty, .dot-live { animation: none !important; transition: none !important; opacity: 1 !important; transform: none !important; }
        }
    </style>
</head>

@php
    $status = $toko?->status;
    $tampilan = match ($status) {
        'active' => [
            'teks' => 'emerald',
            'judul' => 'Toko Anda sudah aktif',
            'deskripsi' => 'Selamat! Toko rental Anda sudah terverifikasi dan tampil di katalog publik RinjaniGuide.',
            'ikon' => 'fa-circle-check',
        ],
        'rejected' => [
            'teks' => 'red',
            'judul' => 'Pendaftaran belum disetujui',
            'deskripsi' => 'Dokumen legalitas belum memenuhi standar mitra. Hubungi admin untuk memperbaiki data toko.',
            'ikon' => 'fa-circle-exclamation',
        ],
        'pending' => [
            'teks' => 'amber',
            'judul' => 'Pendaftaran sedang ditinjau',
            'deskripsi' => 'Tim admin sedang memeriksa legalitas dan rekening toko Anda. Estimasi verifikasi 1×24 jam kerja.',
            'ikon' => 'fa-hourglass-half',
        ],
        default => [
            'teks' => 'amber',
            'judul' => 'Data toko belum ditemukan',
            'deskripsi' => 'Akun Anda terdaftar sebagai mitra rental, namun belum memiliki data toko. Silakan hubungi admin.',
            'ikon' => 'fa-circle-info',
        ],
    };
@endphp

<body class="min-h-screen font-sans antialiased">

    {{-- Siluet gunung pudar --}}
    <svg class="gunung" viewBox="0 0 1440 520" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" fill-opacity=".45" d="M0 380 L150 300 L250 340 L380 210 L470 280 L560 240 L700 350 L820 260 L930 320 L1060 230 L1180 310 L1300 250 L1440 330 L1440 520 L0 520 Z"></path>
        <path fill="currentColor" fill-opacity=".75" d="M0 440 L120 390 L230 430 L350 350 L470 420 L600 360 L720 430 L840 380 L960 440 L1080 370 L1200 425 L1320 385 L1440 435 L1440 520 L0 520 Z"></path>
        <path fill="currentColor" d="M0 490 L160 460 L300 486 L450 452 L620 488 L780 460 L940 490 L1100 456 L1260 488 L1440 462 L1440 520 L0 520 Z"></path>
    </svg>

    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="floaty absolute -left-24 top-0 h-72 w-72 rounded-full bg-champagne/20 blur-[90px]"></div>
        <div class="floaty absolute -right-20 bottom-10 h-80 w-80 rounded-full bg-emerald-400/15 blur-[110px]" style="animation-delay: -4s"></div>
    </div>

    <main class="relative z-10 mx-auto flex min-h-screen w-full max-w-3xl flex-col justify-center px-4 py-12">

        <!-- Logo & toggle tema -->
        <div class="reveal mb-8 flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#F27A21] to-champagne shadow-lg shadow-orange-900/25">
                <i class="fa-solid fa-mountain-sun text-white"></i>
            </div>
            <div>
                <p class="text-[15px] font-semibold leading-tight">RinjaniGuide</p>
                <p class="text-[10px] uppercase tracking-[0.18em] softer">&amp; Rental System</p>
            </div>

            <div class="ml-auto flex items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] soft" style="border-color: rgb(var(--line) / .16); background: rgb(var(--panel) / .7);">
                    <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Portal Mitra
                </span>
                <button type="button" data-tema-toggle aria-label="Ganti mode terang atau gelap" title="Mode terang / gelap"
                    class="toggle-tema flex h-9 w-9 items-center justify-center rounded-full">
                    <i class="fa-solid fa-sun text-[12px] dark:hidden"></i>
                    <i class="fa-solid fa-moon hidden text-[12px] dark:inline"></i>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="reveal mb-4 flex items-start gap-3 rounded-xl border tone-emerald px-4 py-3 text-sm">
                <i class="fa-solid fa-circle-check mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Kartu status -->
        <section class="panel reveal overflow-hidden rounded-3xl">
            <div class="relative border-b hairline px-6 py-9 text-center sm:px-10">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl text-2xl tone-icon-{{ $tampilan['teks'] }}">
                    <i class="fa-solid {{ $tampilan['ikon'] }}"></i>
                </div>
                <h1 class="mt-5 font-serif text-3xl leading-tight">{{ $tampilan['judul'] }}</h1>
                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed soft">{{ $tampilan['deskripsi'] }}</p>

                @if ($toko)
                    <span class="tone-{{ $tampilan['teks'] }} mt-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[11px] font-semibold">
                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                        {{ $status === 'active' ? 'Terverifikasi' : ($status === 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi') }}
                    </span>
                @endif
            </div>

            @if ($toko)
                <dl class="grid gap-4 px-6 py-6 sm:grid-cols-2 sm:px-10">
                    <div>
                        <dt class="text-[10px] uppercase tracking-[0.16em] softer">Nama Toko</dt>
                        <dd class="mt-1 text-sm font-semibold">{{ $toko->nama_toko }}</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase tracking-[0.16em] softer">Penanggung Jawab</dt>
                        <dd class="mt-1 text-sm font-semibold">{{ $toko->penanggung_jawab ?: auth()->user()->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase tracking-[0.16em] softer">Alamat Basecamp</dt>
                        <dd class="mt-1 text-sm soft">{{ $toko->alamat ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] uppercase tracking-[0.16em] softer">Kontak Toko</dt>
                        <dd class="mt-1 text-sm soft">{{ $toko->telepon_toko ?: auth()->user()->no_telepon }}</dd>
                    </div>
                </dl>

                <!-- Tahapan -->
                <div class="border-t hairline px-6 py-6 sm:px-10">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] softer">Tahapan Verifikasi</p>
                    <ol class="space-y-4">
                        @php
                            $tahapan = [
                                ['judul' => 'Pendaftaran dikirim', 'catatan' => 'Data akun, legalitas, dan rekening diterima sistem.'],
                                ['judul' => 'Peninjauan admin', 'catatan' => 'Pemeriksaan NIB, NPWP, dan rekening pencairan.'],
                                ['judul' => 'Toko aktif', 'catatan' => 'Alat tampil di katalog dan dashboard dapat digunakan.'],
                            ];
                            $tahapAktif = match ($status) {
                                'active' => 3,
                                'rejected' => 2,
                                default => 2,
                            };
                        @endphp

                        @foreach ($tahapan as $i => $step)
                            @php
                                $nomor = $i + 1;
                                $selesai = $nomor < $tahapAktif || $status === 'active';
                                $aktif = $nomor === $tahapAktif && $status !== 'active';
                                $gagal = $aktif && $status === 'rejected';
                            @endphp
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-bold
                                    {{ $selesai ? 'bg-emerald-500 text-white' : ($gagal ? 'bg-red-500 text-white' : ($aktif ? 'bg-amber-400 text-[#3b2604]' : '') ) }}"
                                    @if (! $selesai && ! $gagal && ! $aktif) style="background: rgb(var(--line) / .10); color: rgb(var(--ink) / .40);" @endif>
                                    @if ($selesai)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        {{ $nomor }}
                                    @endif
                                </span>
                                <div>
                                    <p class="text-[13px] font-semibold {{ $selesai || $aktif ? '' : 'soft' }}">{{ $step['judul'] }}</p>
                                    <p class="text-[11px] {{ $selesai || $aktif ? 'soft' : 'softer' }}">{{ $step['catatan'] }}</p>
                                </div>
                                @if ($aktif)
                                    <span class="ml-auto rounded-full px-2 py-0.5 text-[10px] soft" style="background: rgb(var(--sand));">
                                        {{ $status === 'rejected' ? 'Perlu perbaikan' : 'Proses' }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif

            <!-- Aksi -->
            <div class="border-t hairline px-6 py-6 sm:px-10">
                <div class="flex flex-col gap-3 sm:flex-row">
                    @if ($status === 'active')
                        <a href="{{ route('rental.dashboard') }}"
                            class="btn-utama flex flex-1 items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white">
                            <i class="fa-solid fa-table-cells-large text-xs"></i> Buka Dashboard Rental
                        </a>
                    @else
                        <a href="{{ route('rental.verification', ['cek' => now()->timestamp]) }}"
                            class="btn-utama flex flex-1 items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white">
                            <i class="fa-solid fa-rotate text-xs"></i> Cek Status Verifikasi
                        </a>
                    @endif

                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo admin, saya mitra rental ' . ($toko->nama_toko ?? auth()->user()->nama) . ' ingin menanyakan status verifikasi toko.') }}"
                        target="_blank" rel="noopener"
                        class="btn-garis flex flex-1 items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-medium">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Admin
                    </a>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-2 text-[11px] softer">
                    <span><i class="fa-regular fa-clock mr-1"></i> Pemeriksaan terakhir: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}" class="transition hover:opacity-80">Beranda</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="transition hover:opacity-80">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <p class="reveal mt-6 text-center text-[11px] softer">
            <i class="fa-solid fa-lock mr-1"></i> Dokumen legalitas Anda tersimpan terenkripsi dan hanya diakses tim verifikasi TNGR.
        </p>
    </main>

    <script>
        (function () {
            var root = document.documentElement;

            document.querySelectorAll('[data-tema-toggle]').forEach(function (el) {
                el.addEventListener('click', function () {
                    var gelap = root.classList.toggle('dark');
                    try { localStorage.setItem('rg-tema', gelap ? 'gelap' : 'terang'); } catch (e) {}
                });
            });

            requestAnimationFrame(function () {
                document.querySelectorAll('.reveal').forEach(function (el, i) {
                    setTimeout(function () { el.classList.add('on'); }, i * 90);
                });
            });
        })();
    </script>
</body>
</html>
