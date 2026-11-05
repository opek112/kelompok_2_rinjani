<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex">
        
        <!-- KIRI: Bagian Gambar & Info -->
        <div class="hidden lg:flex lg:w-[45%] relative bg-[#143529] text-white flex-col justify-between p-12 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1518182170546-076616fdfaaf?q=80&w=1000&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black/60"></div>
            
            <!-- Konten Kiri -->
            <div class="relative z-10">
                <div class="mb-12 flex gap-4 text-xs font-semibold">
                    <span class="border border-white/30 rounded-full px-3 py-1 flex items-center gap-2">🧭 MITRA RESMI TNGR & APGI</span>
                    <span class="border border-white/30 rounded-full px-3 py-1 flex items-center gap-2">⛰️ 3.726 mdpl</span>
                </div>
                
                <div class="mb-4">
                    <span class="bg-orange-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">KARIER & EKSPEDISI RINJANI</span>
                </div>
                <h1 class="text-4xl font-serif font-bold mb-4 leading-tight">@yield('hero-title')</h1>
                <p class="text-gray-300 mb-8 text-sm max-w-md">@yield('hero-desc')</p>
                
                <!-- List Fitur -->
                <div class="space-y-3">
                    @yield('hero-features')
                </div>
            </div>
            
            <!-- Footer Kiri -->
            <div class="relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-6 mt-12">
                <div class="flex items-center gap-2">🛡️ Standar Ekpedisi Berkelanjutan TNGR</div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Area Form -->
        <div class="w-full lg:w-[55%] flex flex-col p-8 md:p-12 bg-white overflow-y-auto h-screen">
            <!-- Header Kanan -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">R</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">RinjaniGuide <span class="font-normal text-gray-500">& Rental</span></h2>
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
</body>
</html>