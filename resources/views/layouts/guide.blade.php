<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard Pemandu' }} - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.tema-gelap')
</head>

<body class="font-sans antialiased bg-gray-50 flex h-screen overflow-hidden">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-gradient-to-b from-[#1e4035] to-[#15291f] text-white flex flex-col justify-between hidden md:flex flex-shrink-0 shadow-xl">
        <div>
            <!-- Logo -->
            <div class="p-6 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    R</div>
                <div>
                    <h2 class="text-lg font-bold leading-tight">RinjaniGuide</h2>
                    <p class="text-[10px] text-gray-300 tracking-widest">& Rental System</p>
                </div>
            </div>

            <!-- Mode Pemandu -->
            <div class="px-6 mb-6">
                <div
                    class="bg-white/10 text-xs px-3 py-1.5 rounded-full inline-flex items-center gap-2 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span> Mode Pemandu
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-1 px-3">
                <a href="{{ route('guide.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3 {{ request()->routeIs('guide.dashboard') ? 'bg-[#2c5548] border-l-4 border-orange-500 text-white' : 'text-gray-300 hover:bg-white/5' }} rounded-r-lg transition">
                    <span>🏠</span> Dashboard
                </a>
                <a href="{{ route('guide.schedule') }}"
                    class="flex items-center gap-3 px-3 py-3 {{ request()->routeIs('guide.schedule') ? 'bg-[#2c5548] border-l-4 border-orange-500 text-white' : 'text-gray-300 hover:bg-white/5' }} rounded-r-lg transition">
                    <span>📅</span> Jadwal Penugasan
                </a>
                <a href="{{ route('guide.earnings') }}"
                    class="flex items-center gap-3 px-3 py-3 {{ request()->routeIs('guide.earnings') ? 'bg-[#2c5548] border-l-4 border-orange-500 text-white' : 'text-gray-300 hover:bg-white/5' }} rounded-r-lg transition">
                    <span>💰</span> Pendapatan
                </a>
                <a href="{{ route('guide.profile') }}"
                    class="flex items-center gap-3 px-3 py-3 {{ request()->routeIs('guide.profile') ? 'bg-[#2c5548] border-l-4 border-orange-500 text-white' : 'text-gray-300 hover:bg-white/5' }} rounded-r-lg transition">
                    <span>👤</span> Profil
                </a>
                <a href="{{ route('guide.settings') }}"
                    class="flex items-center gap-3 px-3 py-3 {{ request()->routeIs('guide.settings*') ? 'bg-[#2c5548] border-l-4 border-orange-500 text-white' : 'text-gray-300 hover:bg-white/5' }} rounded-r-lg transition">
                    <span>⚙️</span> Pengaturan
                </a>
            </nav>
        </div>

        <!-- Tombol Keluar -->
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 text-gray-300 hover:text-white transition w-full px-3 py-2">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA KANAN -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- NAVBAR ATAS -->
        <header class="bg-white/95 backdrop-blur border-b border-gray-200 h-20 flex items-center justify-between px-8 flex-shrink-0 relative z-30">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                <p class="text-xs text-gray-500 mt-1">{{ $subheader ?? '' }}</p>
            </div>

            <div class="flex items-center gap-4">
                <button type="button" onclick="gantiTema()" title="Mode terang / gelap" aria-label="Ganti tema"
                    class="w-10 h-10 rounded-full border border-gray-200 text-gray-500 hover:text-orange-500 hover:border-orange-300 flex items-center justify-center transition">
                    <i class="fa-solid fa-moon text-sm ikon-terang"></i>
                    <i class="fa-solid fa-sun text-sm ikon-gelap"></i>
                </button>
                <!-- Notifikasi -->
                <a href="{{ route('guide.schedule') }}" class="relative cursor-pointer group">
                    <span class="text-xl group-hover:opacity-80">🔔</span>
                    @if (($navPerluKonfirmasi ?? 0) > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $navPerluKonfirmasi }}</span>
                    @endif
                </a>
                <div class="w-px h-8 bg-gray-300 mx-2"></div>
                <!-- User Profile -->
                <div class="flex items-center gap-3 cursor-pointer">
                    @if ($navUser?->foto)
                        <img src="{{ $navUser->fotoUrl() }}" alt="Foto profil"
                            class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    @else
                        <div
                            class="w-10 h-10 bg-[#1e4035] rounded-full flex items-center justify-center text-white font-bold">
                            {{ $navPemandu?->inisial() ?? mb_strtoupper(mb_substr($navUser->nama ?? 'PM', 0, 2)) }}</div>
                    @endif
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-gray-800">{{ $navUser->nama ?? 'Pemandu' }}</p>
                        <p class="text-xs text-gray-500">
                            @if (($navPemandu?->status ?? null) === 'active')
                                Pemandu Terverifikasi APGI
                            @elseif (($navPemandu?->status ?? null) === 'pending')
                                Menunggu Verifikasi Admin
                            @elseif (($navPemandu?->status ?? null) === 'rejected')
                                Pendaftaran Ditolak
                            @else
                                Mode Pemandu
                            @endif
                        </p>
                    </div>
                    <span class="text-gray-400 text-xs">▼</span>
                </div>
            </div>
        </header>

        <!-- ISI HALAMAN (BERUBAH-UBAH) -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#f8f9fa]">
            @if (session('success'))
                <div class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <p class="font-bold mb-1">Periksa kembali data yang Anda isi:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $pesan)
                            <li>{{ $pesan }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</body>

</html>
