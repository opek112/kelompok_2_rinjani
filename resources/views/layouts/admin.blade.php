<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - RinjaniGuide')</title>
    
    <!-- Panggil Vite (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar Admin -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT (Bagian Kanan) -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- HEADER ADMIN -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0 z-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">@yield('header_title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500">@yield('header_desc', 'Sistem Informasi RinjaniGuide')</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Notifikasi -->
                    <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                        <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    </a>
                    
                    <!-- Profil Admin -->
                    <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                        <div class="w-10 h-10 bg-[#143529] rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->nama, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-tight">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN YANG BERUBAH-UBAH -->
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content') 
            </div>

        </main>
    </div>
</body>
</html>