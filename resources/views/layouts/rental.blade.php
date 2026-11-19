<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title', 'Dashboard Rental') — RinjaniGuide Mitra</title>

    <script>
        // Terapkan tema tersimpan sebelum paint agar tidak berkedip.
        (function () {
            try {
                if (localStorage.getItem('rg-tema') === 'gelap') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['"Playfair Display"', 'serif'] },
                    colors: {
                        brand: { dark: '#1A3626', green: '#2F5A40', orange: '#F27A21', light: '#F8F9FA' },
                        ink: 'rgb(var(--ink) / <alpha-value>)',
                        panel: 'rgb(var(--panel) / <alpha-value>)',
                        canvas: 'rgb(var(--canvas) / <alpha-value>)',
                        sand: 'rgb(var(--sand) / <alpha-value>)',
                        line: 'rgb(var(--line) / <alpha-value>)',
                        moss: '#11382A',
                        champagne: '#C8A96B',
                    },
                    boxShadow: {
                        soft: '0 16px 40px -28px rgba(10,35,27,.35)',
                        lift: '0 30px 60px -34px rgba(10,35,27,.35)',
                    },
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
            --nav: 12 42 33;
        }

        html.dark {
            --ink: 233 241 236;
            --panel: 18 40 32;
            --canvas: 8 22 17;
            --sand: 25 50 41;
            --line: 150 180 164;
            --nav: 6 18 14;
            color-scheme: dark;
        }

        [x-cloak] { display: none !important; }

        html { scroll-behavior: smooth; }

        body {
            background-color: rgb(var(--canvas));
            background-image:
                radial-gradient(58rem 30rem at 82% -8%, rgba(200, 169, 107, .14), transparent 60%),
                radial-gradient(46rem 28rem at 6% 4%, rgba(17, 56, 42, .06), transparent 62%);
            background-attachment: fixed;
            transition: background-color .5s var(--ease), color .5s var(--ease);
        }

        html.dark body {
            background-image:
                radial-gradient(58rem 30rem at 82% -8%, rgba(200, 169, 107, .10), transparent 60%),
                radial-gradient(48rem 30rem at 4% 0%, rgba(46, 138, 104, .10), transparent 62%);
        }

        /* ---------- Reveal on scroll ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(26px);
            filter: blur(6px);
            transition: opacity .9s var(--ease), transform .9s var(--ease), filter .9s var(--ease);
            transition-delay: var(--d, 0ms);
        }
        .reveal.is-visible { opacity: 1; transform: none; filter: none; }

        /* ---------- Parallax layers ---------- */
        [data-parallax] { will-change: transform; transition: transform .15s linear; }

        /* ---------- Textures & glow ---------- */
        .mesh::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(24rem 16rem at 12% 10%, rgba(200, 169, 107, .22), transparent 65%),
                radial-gradient(22rem 18rem at 88% 90%, rgba(46, 138, 104, .28), transparent 68%);
            pointer-events: none;
        }
        .hairline { box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .08); }

        .orb { border-radius: 9999px; filter: blur(46px); }
        @keyframes floaty { 0%, 100% { transform: translate3d(0, 0, 0) } 50% { transform: translate3d(0, -16px, 0) } }
        .floaty { animation: floaty 11s ease-in-out infinite; }

        @keyframes pulseDot { 0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(52, 211, 153, .5) } 50% { opacity: .65; box-shadow: 0 0 0 6px rgba(52, 211, 153, 0) } }
        .dot-live { animation: pulseDot 2.4s ease-in-out infinite; }

        /* ---------- Buttons ---------- */
        .sheen { position: relative; overflow: hidden; isolation: isolate; }
        .sheen::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 25%, rgba(255, 255, 255, .38) 45%, transparent 62%);
            transform: translateX(-130%);
            transition: transform 1s var(--ease);
            pointer-events: none;
        }
        .sheen:hover::after { transform: translateX(130%); }

        .btn-primary {
            background-image: linear-gradient(135deg, #F27A21 0%, #E4630B 55%, #C8A96B 160%);
            box-shadow: 0 14px 30px -16px rgba(226, 99, 11, .75);
            transition: transform .35s var(--ease), box-shadow .35s var(--ease), filter .35s var(--ease);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 22px 38px -18px rgba(226, 99, 11, .8); filter: saturate(1.05); }
        .btn-primary:active { transform: translateY(0); }

        /* ---------- Sidebar nav ---------- */
        .sidebar-shell {
            background-image: linear-gradient(180deg, #0C2A21 0%, #0A231B 55%, #071B14 100%);
        }
        html.dark .sidebar-shell {
            background-image: linear-gradient(180deg, #08201A 0%, #061812 55%, #04120E 100%);
        }

        .nav-link {
            position: relative;
            transition: background .4s var(--ease), color .4s var(--ease), padding-left .4s var(--ease);
        }
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            height: 0; width: 3px;
            border-radius: 999px;
            background: linear-gradient(180deg, #F2B675, #F27A21);
            transform: translateY(-50%);
            opacity: 0;
            transition: height .4s var(--ease), opacity .4s var(--ease);
        }
        .nav-link:hover::before { height: 44%; opacity: .6; }
        .nav-link.is-active::before { height: 62%; opacity: 1; }
        .nav-link.is-active {
            background: linear-gradient(90deg, rgba(255, 255, 255, .14), rgba(255, 255, 255, .02));
            color: #fff;
        }
        .nav-link i { transition: transform .4s var(--ease), color .4s var(--ease); }
        .nav-link:hover i { transform: translateY(-1px) scale(1.06); color: #F5D3AC; }

        /* ---------- Cards ---------- */
        .card {
            background: rgb(var(--panel) / .94);
            border: 1px solid rgb(var(--line) / .10);
            border-radius: 1.25rem;
            box-shadow: 0 1px 2px rgba(16, 40, 30, .04);
            transition: transform .5s var(--ease), box-shadow .5s var(--ease), border-color .5s var(--ease), background .5s var(--ease);
        }
        .card:hover { box-shadow: 0 34px 60px -38px rgba(10, 35, 27, .35); border-color: rgb(var(--line) / .18); }
        .card-lift:hover { transform: translateY(-4px); }

        .stat-card { position: relative; overflow: hidden; }
        .stat-card::after {
            content: '';
            position: absolute;
            right: -3rem; bottom: -3.5rem;
            width: 9rem; height: 9rem;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(200, 169, 107, .20), transparent 70%);
            transition: transform .7s var(--ease);
        }
        .stat-card:hover::after { transform: scale(1.35); }

        /* ---------- Table rows ---------- */
        .row-hover { transition: background .35s var(--ease), transform .35s var(--ease); }
        .row-hover:hover { background: rgb(var(--sand) / .75); }

        .chip { display: inline-flex; align-items: center; gap: .35rem; font-size: .7rem; font-weight: 600; padding: .28rem .6rem; border-radius: 999px; line-height: 1; }

        .topbar { background: rgb(var(--canvas) / .82); }
        .field {
            width: 100%;
            border-radius: .85rem;
            border: 1px solid rgb(var(--line) / .14);
            background: rgb(var(--panel) / .82);
            padding: .7rem .9rem;
            font-size: .875rem;
            color: rgb(var(--ink));
            outline: none;
            transition: border-color .3s var(--ease), box-shadow .3s var(--ease), background .3s var(--ease);
        }
        .field::placeholder { color: rgb(var(--ink) / .35); }
        .field:focus {
            border-color: rgba(242, 122, 33, .55);
            background: rgb(var(--panel));
            box-shadow: 0 0 0 3px rgba(242, 122, 33, .14);
        }
        .field-label { display: block; font-size: .75rem; font-weight: 600; letter-spacing: .04em; color: rgb(var(--ink) / .55); margin-bottom: .4rem; }

        /* ---------- Dark mode: chip & alert surfaces ---------- */
        html.dark .bg-emerald-50 { background-color: rgba(16, 185, 129, .14); }
        html.dark .bg-amber-50 { background-color: rgba(245, 158, 11, .14); }
        html.dark .bg-sky-50 { background-color: rgba(14, 165, 233, .14); }
        html.dark .bg-red-50 { background-color: rgba(239, 68, 68, .15); }
        html.dark .bg-slate-100 { background-color: rgba(148, 163, 184, .16); }
        html.dark .bg-emerald-100 { background-color: rgba(16, 185, 129, .22); }
        html.dark .bg-orange-50 { background-color: rgba(242, 122, 33, .14); }
        html.dark .text-emerald-700 { color: #6ee7b7; }
        html.dark .text-amber-700 { color: #fcd34d; }
        html.dark .text-sky-700 { color: #7dd3fc; }
        html.dark .text-red-600 { color: #fca5a5; }
        html.dark .text-red-700 { color: #fca5a5; }
        html.dark .text-slate-600 { color: #cbd5e1; }
        html.dark .ring-emerald-100 { --tw-ring-color: rgba(16, 185, 129, .28); }
        html.dark .ring-amber-100 { --tw-ring-color: rgba(245, 158, 11, .28); }
        html.dark .ring-sky-100 { --tw-ring-color: rgba(14, 165, 233, .28); }
        html.dark .ring-red-100 { --tw-ring-color: rgba(239, 68, 68, .28); }
        html.dark .ring-slate-200 { --tw-ring-color: rgba(148, 163, 184, .24); }
        html.dark .border-emerald-200 { border-color: rgba(16, 185, 129, .35); }
        html.dark .border-red-200 { border-color: rgba(239, 68, 68, .35); }
        html.dark .bg-emerald-50\/90 { background-color: rgba(16, 185, 129, .14); }
        html.dark .bg-red-50\/90 { background-color: rgba(239, 68, 68, .15); }
        html.dark .text-emerald-800 { color: #a7f3d0; }
        html.dark .bg-sand\/60 { background-color: rgb(var(--sand) / .6); }

        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-thumb { background: rgb(var(--line) / .22); border-radius: 999px; }
        ::-webkit-scrollbar-track { background: transparent; }

        @media (prefers-reduced-motion: reduce) {
            .reveal, [data-parallax], .floaty, .dot-live { animation: none !important; transition: none !important; opacity: 1 !important; transform: none !important; filter: none !important; }
            html { scroll-behavior: auto; }
        }
    </style>
</head>

@php
    $navToko = $toko ?? null;
    $navUser = auth()->user();
    $notifBelumDibaca = $navToko ? \Modules\Rental\Support\NotifikasiToko::jumlahBelumDibaca($navToko) : 0;
    $menu = [
        ['route' => 'rental.dashboard', 'label' => 'Dashboard', 'ikon' => 'fa-table-cells-large', 'aktif' => 'rental.dashboard'],
        ['route' => 'rental.orders', 'label' => 'Pesanan', 'ikon' => 'fa-box-open', 'aktif' => 'rental.orders', 'badge' => $sedangDikemas ?? 0],
        ['route' => 'rental.returns', 'label' => 'Pengembalian', 'ikon' => 'fa-rotate-left', 'aktif' => 'rental.returns*'],
        ['route' => 'rental.catalog', 'label' => 'Katalog', 'ikon' => 'fa-tags', 'aktif' => 'rental.catalog'],
        ['route' => 'rental.reports', 'label' => 'Rekap', 'ikon' => 'fa-chart-column', 'aktif' => 'rental.reports*'],
        ['route' => 'rental.profile', 'label' => 'Profil', 'ikon' => 'fa-user', 'aktif' => 'rental.profile*'],
        ['route' => 'rental.settings', 'label' => 'Pengaturan', 'ikon' => 'fa-gear', 'aktif' => 'rental.settings*'],
    ];
@endphp

<body class="font-sans text-ink antialiased" x-data="{ sidebar: false, akun: false }">

    <!-- Overlay mobile -->
    <div x-show="sidebar" x-cloak @click="sidebar = false"
        class="fixed inset-0 z-40 bg-ink/60 backdrop-blur-sm lg:hidden" x-transition.opacity></div>

    <!-- SIDEBAR -->
    <aside
        class="sidebar-shell fixed inset-y-0 left-0 z-50 flex w-[272px] flex-col overflow-hidden text-white transition-transform duration-500 lg:translate-x-0"
        :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
        style="transition-timing-function: cubic-bezier(.22,1,.36,1)">

        <div class="mesh relative">
            <div class="relative z-10 flex items-center gap-3 px-6 pt-7 pb-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-brand-orange to-[#C8A96B] text-white shadow-lg shadow-orange-900/30">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>
                <div>
                    <p class="text-[15px] font-semibold leading-tight tracking-wide">RinjaniGuide</p>
                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/45">&amp; Rental System</p>
                </div>
                <button @click="sidebar = false" class="ml-auto text-white/60 hover:text-white lg:hidden">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="relative z-10 px-6 pb-7">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/[.06] px-3 py-1.5 text-[11px] font-medium text-emerald-100/90 backdrop-blur">
                    <span class="dot-live h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Mode Toko Rental
                </span>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 pb-6">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                    class="nav-link {{ request()->routeIs($item['aktif']) ? 'is-active' : 'text-white/62 hover:text-white/92' }} flex items-center gap-3 rounded-r-xl px-4 py-3 text-sm font-medium">
                    <i class="fa-solid {{ $item['ikon'] }} w-4 text-center text-[13px]"></i>
                    <span>{{ $item['label'] }}</span>
                    @if (! empty($item['badge']))
                        <span class="ml-auto flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-brand-orange px-1.5 text-[10px] font-bold text-white">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="border-t border-white/10 px-4 py-5">
            <div class="mb-4 rounded-xl border border-white/10 bg-white/[.04] p-3">
                <div class="flex items-center gap-2 text-[11px] font-semibold text-emerald-200">
                    <i class="fa-solid fa-shield-halved"></i>
                    {{ ($navToko?->status === 'active') ? 'Mitra Terverifikasi' : 'Menunggu Verifikasi' }}
                </div>
                <p class="mt-1 text-[10px] leading-relaxed text-white/40">
                    {{ $navToko?->lokasi_pos ? 'Pos '.$navToko->lokasi_pos : 'APGI & TNGR Reg. 2024–RO–08' }}
                </p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-white/55 transition hover:bg-white/5 hover:text-white">
                    <i class="fa-solid fa-arrow-right-from-bracket text-[13px]"></i> Keluar Portal
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN -->
    <div class="lg:pl-[272px]">
        <header class="topbar sticky top-0 z-30 border-b border-line/10 backdrop-blur-xl">
            <div class="mx-auto flex max-w-[1400px] items-center gap-4 px-5 py-4 sm:px-8 lg:px-10">
                <button @click="sidebar = true" class="text-ink/70 hover:text-ink lg:hidden">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <div class="min-w-0">
                    <h1 class="font-serif text-xl leading-tight text-ink sm:text-2xl">@yield('title', 'Dashboard')</h1>
                    <p class="mt-0.5 truncate text-[12px] text-ink/50">@yield('subtitle', '')</p>
                </div>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    <button type="button" data-tema-toggle aria-label="Ganti mode terang atau gelap"
                        title="Mode terang / gelap"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-line/12 bg-panel/70 text-ink/60 transition hover:border-brand-orange/40 hover:text-brand-orange">
                        <i class="fa-solid fa-sun text-[13px] dark:hidden"></i>
                        <i class="fa-solid fa-moon hidden text-[13px] dark:inline"></i>
                    </button>

                    <a href="{{ route('rental.notifications') }}" aria-label="Buka pusat notifikasi"
                        class="relative flex h-10 w-10 items-center justify-center rounded-full border border-line/12 bg-panel/70 text-ink/60 transition hover:text-brand-orange">
                        <i class="fa-regular fa-bell"></i>
                        @if ($notifBelumDibaca > 0)
                            <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-brand-orange px-1 text-[9px] font-bold text-white">{{ $notifBelumDibaca }}</span>
                        @endif
                    </a>

                    <span class="hidden h-8 w-px bg-line/12 sm:block"></span>

                    <div class="relative" x-data="{ buka: false }" @click.away="buka = false">
                        <button @click="buka = !buka" class="flex items-center gap-3 rounded-full border border-line/12 bg-panel/70 py-1 pl-1 pr-3 transition hover:shadow-soft">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-moss to-ink text-[11px] font-bold text-champagne">
                                {{ $navToko?->inisial() ?? 'RT' }}
                            </span>
                            <span class="hidden text-left sm:block">
                                <span class="block text-[12px] font-semibold leading-tight text-ink">{{ $navUser?->nama ?? 'Mitra' }}</span>
                                <span class="block text-[10px] leading-tight text-ink/45">{{ $navToko?->nama_toko ?? 'Toko Rental' }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-ink/35"></i>
                        </button>

                        <div x-show="buka" x-cloak x-transition.opacity
                            class="absolute right-0 mt-3 w-56 overflow-hidden rounded-xl border border-line/12 bg-panel py-2 shadow-xl">
                            <div class="border-b border-line/10 px-4 py-3">
                                <p class="text-sm font-semibold text-ink">{{ $navUser?->nama }}</p>
                                <p class="text-[11px] text-ink/45">{{ $navUser?->email }}</p>
                            </div>
                            <a href="{{ route('rental.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-ink/70 hover:bg-sand hover:text-ink"><i class="fa-solid fa-store w-4 text-ink/35"></i> Profil Toko</a>
                            <a href="{{ route('rental.notifications') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-ink/70 hover:bg-sand hover:text-ink"><i class="fa-regular fa-bell w-4 text-ink/35"></i> Notifikasi</a>
                            <a href="{{ route('rental.settings') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-ink/70 hover:bg-sand hover:text-ink"><i class="fa-solid fa-gear w-4 text-ink/35"></i> Pengaturan</a>
                            <a href="{{ route('rental.verification') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-ink/70 hover:bg-sand hover:text-ink"><i class="fa-solid fa-circle-check w-4 text-ink/35"></i> Status Verifikasi</a>
                            <div class="my-1 border-t border-line/10"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50"><i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-[1400px] px-5 py-7 sm:px-8 lg:px-10 lg:py-9">
            @if (session('success'))
                <div class="reveal is-visible mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-sm text-emerald-800">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="reveal is-visible mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50/90 px-4 py-3 text-sm text-red-700">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="reveal is-visible mb-6 rounded-xl border border-red-200 bg-red-50/90 px-4 py-3 text-sm text-red-700">
                    <p class="mb-1 font-semibold">Periksa kembali data berikut:</p>
                    <ul class="list-inside list-disc space-y-0.5">
                        @foreach ($errors->all() as $pesan)
                            <li>{{ $pesan }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <footer class="mt-12 flex flex-col gap-2 border-t border-line/10 pt-6 text-[11px] text-ink/40 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ now()->year }} RinjaniGuide &amp; Rental — Portal Mitra Resmi TNGR.</p>
                <p class="flex items-center gap-2"><span class="dot-live inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Sinkronisasi data real-time</p>
            </footer>
        </main>
    </div>

    <script>
        // Mode terang / gelap
        (function () {
            const root = document.documentElement;
            const tombol = document.querySelectorAll('[data-tema-toggle]');

            tombol.forEach((el) => {
                el.addEventListener('click', () => {
                    const gelap = root.classList.toggle('dark');
                    try { localStorage.setItem('rg-tema', gelap ? 'gelap' : 'terang'); } catch (e) {}
                });
            });
        })();

        // Animasi muncul saat elemen masuk viewport
        (function () {
            const items = document.querySelectorAll('.reveal');
            if (!items.length) return;

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                items.forEach((el) => el.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            items.forEach((el) => observer.observe(el));
        })();

        // Angka statistik berjalan naik
        (function () {
            const numbers = document.querySelectorAll('[data-count]');
            if (!numbers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const jalankan = (el) => {
                const target = Number(el.dataset.count || 0);
                const durasi = 1100;
                const mulai = performance.now();

                const tick = (now) => {
                    const progres = Math.min(1, (now - mulai) / durasi);
                    const eased = 1 - Math.pow(1 - progres, 3);
                    el.textContent = Math.round(target * eased).toLocaleString('id-ID');
                    if (progres < 1) requestAnimationFrame(tick);
                };

                requestAnimationFrame(tick);
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        jalankan(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.6 });

            numbers.forEach((el) => observer.observe(el));
        })();

        // Parallax halus untuk ornamen di section hero
        (function () {
            const layers = document.querySelectorAll('[data-parallax]');
            if (!layers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            let ticking = false;

            const perbarui = () => {
                layers.forEach((layer) => {
                    const speed = parseFloat(layer.dataset.parallax || '0.12');
                    const rect = layer.getBoundingClientRect();
                    const tengah = rect.top + rect.height / 2 - window.innerHeight / 2;
                    layer.style.transform = `translate3d(0, ${(-tengah * speed).toFixed(2)}px, 0)`;
                });
                ticking = false;
            };

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    ticking = true;
                    window.requestAnimationFrame(perbarui);
                }
            }, { passive: true });

            perbarui();
        })();
    </script>
</body>
</html>
