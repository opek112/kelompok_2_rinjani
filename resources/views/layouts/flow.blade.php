<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RinjaniGuide & Rental')</title>
    @include('partials.tema-gelap')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] },
                    colors: {
                        brand: { dark: '#1A3626', green: '#2F5A40', orange: '#F27A21', light: '#F8F9FA' }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
        }
    </style>
</head>
<body class="font-sans text-gray-800 bg-[#F6F5F1] antialiased">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                @hasSection('back')
                    <a href="@yield('back-url', '#')" class="text-sm font-medium text-gray-600 hover:text-brand-orange flex items-center gap-2 shrink-0">
                        <i class="fa-solid fa-arrow-left"></i> <span class="hidden sm:inline">@yield('back')</span>
                    </a>
                    <span class="hidden md:block w-px h-6 bg-gray-200"></span>
                @endif

                <a href="{{ route('home') }}" class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 bg-brand-dark rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-mountain-sun text-brand-orange text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm text-brand-dark leading-tight truncate">RinjaniGuide & Rental</p>
                        <p class="text-[10px] text-gray-500 leading-tight flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-green-600"></i> Mitra Resmi Bali TNGR
                        </p>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <button type="button" onclick="gantiTema()" title="Mode terang / gelap" aria-label="Ganti tema"
                    class="w-9 h-9 rounded-full border border-gray-200 text-gray-500 hover:text-brand-orange flex items-center justify-center transition no-print">
                    <i class="fa-solid fa-moon text-sm ikon-terang"></i>
                    <i class="fa-solid fa-sun text-sm ikon-gelap"></i>
                </button>
                @yield('header-right')
                <a href="{{ route('home') }}" class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 no-print" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>
