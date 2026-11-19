<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --ease: cubic-bezier(.22, 1, .36, 1); }

        /* ---------- Reveal saat halaman dimuat ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            filter: blur(4px);
            transition: opacity .8s var(--ease), transform .8s var(--ease), filter .8s var(--ease);
            transition-delay: var(--d, 0ms);
        }
        .reveal.on { opacity: 1; transform: none; filter: none; }

        /* ---------- Panel kiri: gradasi & tekstur halus ---------- */
        .hero-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(26rem 22rem at 12% 8%, rgba(242, 122, 33, .28), transparent 62%),
                radial-gradient(24rem 20rem at 88% 92%, rgba(46, 138, 104, .30), transparent 66%);
            pointer-events: none;
        }
        .hero-shell::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(180deg, rgba(9, 32, 24, .55) 0%, rgba(9, 32, 24, .78) 60%, rgba(7, 26, 20, .92) 100%);
            pointer-events: none;
        }

        /* ---------- Interaksi halus pada kartu fitur ---------- */
        .feature-card {
            transition: transform .5s var(--ease), border-color .5s var(--ease), background .5s var(--ease);
        }
        .feature-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, .18);
            background: rgba(255, 255, 255, .13);
        }

        /* ---------- Form: fokus & hover yang konsisten ---------- */
        .sheet {
            box-shadow: 0 1px 2px rgba(16, 40, 30, .04);
            transition: box-shadow .6s var(--ease), border-color .6s var(--ease), transform .6s var(--ease);
        }
        .sheet:hover { box-shadow: 0 28px 60px -44px rgba(10, 35, 27, .45); border-color: rgba(203, 213, 225, .9); }

        .field-line {
            transition: background-color .35s var(--ease), border-color .35s var(--ease), box-shadow .35s var(--ease), transform .35s var(--ease);
        }
        .field-line:hover { background-color: #fff; border-color: #d1d5db; }
        .field-line:focus {
            box-shadow: 0 0 0 4px rgba(249, 115, 22, .12);
            transform: translateY(-1px);
        }

        /* ---------- Input: respons halus tanpa mengubah layout ---------- */
        .form-panel form input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .form-panel form select,
        .form-panel form textarea {
            transition: background-color .35s var(--ease), border-color .35s var(--ease), box-shadow .35s var(--ease);
        }
        .form-panel form input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):focus,
        .form-panel form select:focus,
        .form-panel form textarea:focus {
            box-shadow: 0 0 0 4px rgba(249, 115, 22, .12);
        }

        /* ---------- Tombol utama ---------- */
        .cta {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            transition: transform .35s var(--ease), box-shadow .35s var(--ease), filter .35s var(--ease);
        }
        .cta::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 25%, rgba(255, 255, 255, .35) 45%, transparent 62%);
            transform: translateX(-130%);
            transition: transform 1s var(--ease);
            pointer-events: none;
        }
        .cta:hover { transform: translateY(-2px); filter: saturate(1.05); box-shadow: 0 22px 38px -18px rgba(226, 99, 11, .8); }
        .cta:hover::after { transform: translateX(130%); }
        .cta:active { transform: translateY(0); }

        /* ---------- Garis aksen atas panel form ---------- */
        .form-panel { position: relative; }
        .form-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #F27A21, #C8A96B 45%, transparent 85%);
            opacity: .85;
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal, .feature-card, .field-line, .cta, .sheet { transition: none !important; opacity: 1 !important; transform: none !important; filter: none !important; }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex">

        <!-- KIRI: Bagian Gambar & Info -->
        <div class="hero-shell hidden lg:flex lg:w-[45%] relative bg-[#143529] text-white flex-col justify-between p-12 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1518182170546-076616fdfaaf?q=80&w=1000&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black/55"></div>
            <div class="hero-shell absolute inset-0"></div>

            <!-- Konten Kiri -->
            <div class="relative z-10">
                <div class="reveal mb-12 flex gap-4 text-xs font-semibold" style="--d: 0ms">
                    <span class="border border-white/30 rounded-full px-3 py-1 flex items-center gap-2 backdrop-blur-sm bg-white/5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="m15.5 8.5-2 5-5 2 2-5z"></path></svg>
                        MITRA RESMI TNGR &amp; APGI
                    </span>
                    <span class="border border-white/30 rounded-full px-3 py-1 flex items-center gap-2 backdrop-blur-sm bg-white/5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m3 18 6-11 4 6 2-3 6 8z"></path></svg>
                        3.726 mdpl
                    </span>
                </div>

                <div class="reveal mb-4" style="--d: 80ms">
                    <span class="bg-orange-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">KARIER &amp; EKSPEDISI RINJANI</span>
                </div>
                <h1 class="reveal text-4xl font-serif font-bold mb-4 leading-tight" style="--d: 140ms">@yield('hero-title')</h1>
                <p class="reveal text-gray-300 mb-8 text-sm max-w-md leading-relaxed" style="--d: 200ms">@yield('hero-desc')</p>

                <!-- List Fitur -->
                <div class="space-y-3">
                    @yield('hero-features')
                </div>
            </div>

            <!-- Footer Kiri -->
            <div class="reveal relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-6 mt-12" style="--d: 260ms">
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"></path><path d="m9 12 2 2 4-4"></path></svg>
                    Standar Ekpedisi Berkelanjutan TNGR
                </div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Area Form -->
        <div class="form-panel w-full lg:w-[55%] flex flex-col p-8 md:p-12 bg-white overflow-y-auto h-screen">
            <!-- Header Kanan -->
            <div class="reveal flex items-center justify-between mb-8" style="--d: 60ms">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-orange-500/25">R</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">RinjaniGuide <span class="font-normal text-gray-500">&amp; Rental</span></h2>
                        <p class="text-[10px] text-gray-500 tracking-widest uppercase">@yield('portal-subtitle')</p>
                    </div>
                </div>
                <span class="text-xs font-semibold border border-gray-200 bg-gray-50 rounded-full px-3 py-1.5 text-gray-600 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> @yield('portal-badge')
                </span>
            </div>

            <!-- Isi Form -->
            <div class="max-w-2xl w-full mx-auto flex-1">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        requestAnimationFrame(function () {
            document.querySelectorAll('.reveal').forEach(function (el, i) {
                setTimeout(function () { el.classList.add('on'); }, i * 70);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
