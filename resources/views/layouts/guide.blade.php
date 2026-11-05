<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard Pemandu' }} - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 flex h-screen overflow-hidden">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#1e4035] text-white flex flex-col justify-between hidden md:flex flex-shrink-0">
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
        <header class="bg-white border-b border-gray-200 h-20 flex items-center justify-between px-8 flex-shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                <p class="text-xs text-gray-500 mt-1">{{ $subheader ?? '' }}</p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Notifikasi -->
                <a href="{{ route('guide.notifications') }}" class="relative cursor-pointer group">
                    <span class="text-xl group-hover:opacity-80">🔔</span>
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
                </a>
                <div class="w-px h-8 bg-gray-300 mx-2"></div>
                <!-- User Profile -->
                <div class="flex items-center gap-3 cursor-pointer">
                    <div
                        class="w-10 h-10 bg-[#1e4035] rounded-full flex items-center justify-center text-white font-bold">
                        AR</div>
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-gray-800">Ahmad Rifai</p>
                        <p class="text-xs text-gray-500">Pemandu Senior APGI</p>
                    </div>
                    <span class="text-gray-400 text-xs">▼</span>
                </div>
            </div>
        </header>

        <!-- ISI HALAMAN (BERUBAH-UBAH) -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#f8f9fa]">
            @yield('content')
        </main>

    </div>
</body>

</html>
