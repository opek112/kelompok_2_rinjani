<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RinjaniGuide & Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
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
</head>
<body class="font-sans text-gray-800 bg-brand-light antialiased" x-data="{ mobileMenuOpen: false }">

    <!-- NAVBAR -->
    <nav class="bg-brand-dark text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-orange rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-white"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg tracking-wide block leading-tight">RinjaniGuide & Rental</span>
                        <span class="text-[10px] text-gray-300 block">Taman Nasional Gunung Rinjani</span>
                    </div>
                </a>

                <!-- Desktop Menu (Pill Hover Radius) -->
                <div class="hidden md:flex items-center space-x-1 border border-white/20 rounded-full p-1 bg-white/5 backdrop-blur-sm">
                    <a href="{{ route('home') }}" class="px-5 py-2 rounded-full hover:bg-brand-green transition text-sm font-medium flex items-center gap-2 {{ request()->routeIs('home') ? 'bg-brand-green' : '' }}">
                        <i class="fa-solid fa-house text-xs"></i> Home
                    </a>
                    <a href="{{ route('guide') }}" class="px-5 py-2 rounded-full hover:bg-brand-green transition text-sm font-medium flex items-center gap-2 {{ request()->routeIs('guide') ? 'bg-brand-green' : '' }}">
                        <i class="fa-solid fa-person-hiking text-xs"></i> Guide
                    </a>
                    <a href="{{ route('rental') }}" class="px-5 py-2 rounded-full hover:bg-brand-green transition text-sm font-medium flex items-center gap-2 {{ request()->routeIs('rental') ? 'bg-brand-green' : '' }}">
                        <i class="fa-solid fa-tent text-xs"></i> Rental
                    </a>
                    
                    <!-- Dropdown Info (Alpine.js) -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="px-5 py-2 rounded-full hover:bg-brand-green transition text-sm font-medium flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-xs"></i> Info <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <!-- Isi Dropdown Info -->
                        <div x-show="open" x-transition.opacity class="absolute left-0 mt-3 w-56 bg-white rounded-xl shadow-xl py-2 text-gray-700 z-50 border border-gray-100" style="display: none;">
                            <a href="{{ route('cara-pesan') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-brand-orange transition flex items-center gap-3 text-sm"><i class="fa-solid fa-file-invoice w-4 text-gray-400"></i> Cara Pesan</a>
                            <a href="{{ route('jalur-pendakian') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-brand-orange transition flex items-center gap-3 text-sm"><i class="fa-solid fa-route w-4 text-gray-400"></i> Jalur Pendakian</a>
                            <a href="{{ route('tentang-kami') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-brand-orange transition flex items-center gap-3 text-sm"><i class="fa-solid fa-users w-4 text-gray-400"></i> Tentang Kami</a>
                            <a href="{{ route('faq') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-brand-orange transition flex items-center gap-3 text-sm"><i class="fa-regular fa-circle-question w-4 text-gray-400"></i> FAQ & Bantuan</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('syarat-ketentuan') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-brand-orange transition flex items-center gap-3 text-sm"><i class="fa-solid fa-shield-halved w-4 text-gray-400"></i> Kebijakan</a>
                        </div>
                    </div>
                </div>

                <!-- Bagian Kanan (Auth / Profile) -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- JIKA SUDAH LOGIN (Tampilan Customer) -->
                        <button class="relative text-gray-300 hover:text-white transition">
                            <i class="fa-regular fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-brand-orange text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
                        </button>
                        
                        <!-- Dropdown Profile -->
                        <div class="relative" x-data="{ openProfile: false }">
                            <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 pl-1 pr-3 py-1 rounded-full transition border border-white/10">
                                <div class="w-8 h-8 bg-brand-dark rounded-full flex items-center justify-center border border-brand-orange text-xs font-bold text-brand-orange">AP</div>
                                <div class="text-left">
                                    <p class="text-sm font-semibold leading-tight">Andi Pratama</p>
                                    <p class="text-[10px] text-green-400 leading-tight"><i class="fa-solid fa-circle text-[6px]"></i> Pendaki Terverifikasi</p>
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 ml-1"></i>
                            </button>

                            <!-- Isi Dropdown Profil -->
                            <div x-show="openProfile" x-transition.opacity class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl py-2 text-gray-700 z-50 border border-gray-100" style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100 mb-2 bg-green-50/50">
                                    <p class="font-bold text-brand-dark">Andi Pratama</p>
                                    <p class="text-xs text-gray-500">andi.pratama@email.com</p>
                                </div>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50 transition flex items-center gap-3 text-sm"><i class="fa-regular fa-user w-4 text-gray-400"></i> Profil Saya</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50 transition flex items-center gap-3 text-sm">
                                    <i class="fa-solid fa-receipt w-4 text-gray-400"></i> Riwayat Pesanan
                                    <span class="ml-auto bg-brand-orange text-white text-xs px-2 py-0.5 rounded-full">1</span>
                                </a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50 transition flex items-center gap-3 text-sm">
                                    <i class="fa-solid fa-ticket w-4 text-gray-400"></i> E-Voucher Saya
                                    <span class="ml-auto bg-brand-orange text-white text-xs px-2 py-0.5 rounded-full">1</span>
                                </a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50 transition flex items-center gap-3 text-sm"><i class="fa-solid fa-gear w-4 text-gray-400"></i> Pengaturan Akun</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <!-- Tombol Trigger Modal Logout -->
                                <button @click="openProfile = false; $dispatch('open-logout')" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 transition flex items-center gap-3 text-sm font-medium">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- JIKA BELUM LOGIN -->
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-brand-orange transition">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-brand-orange text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-orange-600 transition">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" style="display: none;"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Content (Bisa disesuaikan) -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-brand-dark border-t border-white/10 px-4 pt-2 pb-4 space-y-2" style="display: none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md hover:bg-brand-green">Home</a>
            <a href="{{ route('guide') }}" class="block px-3 py-2 rounded-md hover:bg-brand-green">Guide</a>
            <a href="{{ route('rental') }}" class="block px-3 py-2 rounded-md hover:bg-brand-green">Rental</a>
            <a href="{{ route('login') }}" class="block px-3 py-2 mt-4 text-center bg-brand-orange rounded-full font-bold">Masuk / Daftar</a>
        </div>
    </nav>

    <!-- KONTEN HALAMAN -->
    @yield('content')

    <!-- MODAL KONFIRMASI LOGOUT (Alpine.js) -->
    <div x-data="{ show: false }" @open-logout.window="show = true" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="show = false" x-transition class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 text-center relative mx-4">
            <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-arrow-right-from-bracket text-2xl text-red-500"></i>
            </div>
            <h3 class="text-2xl font-serif font-bold text-brand-dark mb-2">Keluar dari Akun?</h3>
            <p class="text-gray-500 mb-8 text-sm">Anda akan keluar dari akun ini. Anda tetap bisa memesan sebagai tamu.</p>
            <div class="flex justify-center gap-4">
                <button @click="show = false" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">Batal</button>
                <!-- Form Logout Asli Laravel -->
                <form action="{{ route('logout') ?? '#' }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#162A1F] text-gray-300 py-16 px-4 mt-auto">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Brand & Sosmed -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-brand-orange rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-white"></i>
                    </div>
                    <span class="font-bold text-lg text-white">RinjaniGuide & Rental</span>
                </div>
                <p class="text-sm leading-relaxed mb-6">Platform booking pemandu, paket, dan sewa alat outdoor resmi di Gunung Rinjani.</p>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                </div>
            </div>
            
            <!-- Menu Pendaki -->
            <div>
                <h4 class="text-white font-semibold mb-6">Menu Pendaki</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-orange transition">Home</a></li>
                    <li><a href="{{ route('guide') }}" class="hover:text-brand-orange transition">Guide</a></li>
                    <li><a href="{{ route('rental') }}" class="hover:text-brand-orange transition">Rental</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Info</a></li>
                </ul>
            </div>
            
            <!-- Menu Info -->
            <div>
                <h4 class="text-white font-semibold mb-6">Menu Info</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('cara-pesan') }}" class="hover:text-brand-orange transition">Cara Pesan</a></li>
                    <li><a href="{{ route('jalur-pendakian') }}" class="hover:text-brand-orange transition">Jalur Pendakian</a></li>
                    <li><a href="{{ route('tentang-kami') }}" class="hover:text-brand-orange transition">Tentang Kami</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-brand-orange transition">FAQ</a></li>
                    <li><a href="{{ route('syarat-ketentuan') }}" class="hover:text-brand-orange transition">Kebijakan</a></li>
                </ul>
            </div>
            
            <!-- Kontak -->
            <div>
                <h4 class="text-white font-semibold mb-6">Kontak</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3"><i class="fa-brands fa-whatsapp mt-1 text-brand-orange"></i> <span>WhatsApp: 0812-3456-7890</span></li>
                    <li class="flex items-start gap-3"><i class="fa-regular fa-envelope mt-1 text-brand-orange"></i> <span>Email: info@rinjaniguide.id</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-1 text-brand-orange"></i> <span>Alamat: Basecamp Sembalun & Senaru, Lombok NTB</span></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
            <p>&copy; 2026 RinjaniGuide & Rental. Hak cipta dilindungi undang-undang.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="{{ route('syarat-ketentuan') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                <span>&bull;</span>
                <a href="{{ route('syarat-ketentuan') }}" class="hover:text-white transition">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>
</body>
</html>