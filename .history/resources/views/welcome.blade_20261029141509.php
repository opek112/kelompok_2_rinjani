<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RinjaniGuide & Rental - Platform Pendakian Terpercaya</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#1A3626', // Hijau Gelap
                            green: '#2F5A40', // Hijau Tombol
                            orange: '#F27A21', // Oranye Tombol/Highlight
                            light: '#F8F9FA', // Background Abu-abu terang
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-800 bg-brand-light antialiased">

    <!-- NAVBAR -->
    <nav class="bg-brand-dark text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-orange rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-white"></i>
                    </div>
                    <span class="font-bold text-xl tracking-wide">RinjaniGuide & Rental</span>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 font-medium text-sm">
                    <a href="#" class="hover:text-brand-orange transition">Home</a>
                    <a href="#" class="hover:text-brand-orange transition">Guide</a>
                    <a href="#" class="hover:text-brand-orange transition">Sewa</a>
                    <a href="#" class="hover:text-brand-orange transition">Info <i class="fa-solid fa-chevron-down text-xs ml-1"></i></a>
                </div>
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#" class="text-sm font-medium hover:text-brand-orange transition"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Masuk</a>
                    <a href="#" class="bg-brand-orange text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-orange-600 transition">Daftar</a>
                </div>
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-white focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative h-[600px] flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=2071&auto=format&fit=crop'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div> <!-- Overlay Gelap -->
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-10">
            <span class="inline-block bg-white/20 text-white px-4 py-1.5 rounded-full text-sm font-medium mb-6 backdrop-blur-sm">
                <i class="fa-solid fa-mountain mr-2"></i>Taman Nasional Gunung Rinjani
            </span>
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6 leading-tight">
                Jelajahi Puncak Rinjani dengan <br> Aman & Nyaman
            </h1>
            <p class="text-lg text-gray-200 mb-8 max-w-2xl mx-auto">
                Pesan pemandu lokal & sewa alat outdoor di pos Sembalun, Senaru, dan Torean.
            </p>
            <div class="flex flex-wrap justify-center gap-4 text-sm text-white font-medium">
                <span class="flex items-center gap-2"><i class="fa-solid fa-check-circle text-brand-orange"></i> Jalur Sewa</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-check-circle text-brand-orange"></i> Jalur Sewa</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-check-circle text-brand-orange"></i> Jalur Torean</span>
            </div>
        </div>

        <!-- Floating Booking Form -->
        <div class="absolute -bottom-24 left-1/2 transform -translate-x-1/2 w-[90%] max-w-5xl bg-white rounded-2xl shadow-xl p-6 z-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Lokasi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Pos Keberangkatan</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3 top-3 text-gray-400"></i>
                        <select class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none appearance-none bg-white">
                            <option>Sembalun (Padang Savana & Puncak)</option>
                            <option>Senaru (Hutan Tropis & Danau)</option>
                            <option>Torean (Danau & Savana)</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
                <!-- Tgl Mulai -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                    <div class="relative">
                        <i class="fa-regular fa-calendar absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" value="14 Mei 2026" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                    </div>
                </div>
                <!-- Tgl Selesai -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Selesai</label>
                    <div class="relative">
                        <i class="fa-regular fa-calendar absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" value="16 Mei 2026" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-brand-orange focus:border-brand-orange outline-none">
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6">
                <!-- Checkbox Filters -->
                <div class="flex items-center gap-6 text-sm text-gray-700">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 text-brand-green rounded focus:ring-brand-green">
                        Cari Pemandu
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 text-brand-green rounded focus:ring-brand-green">
                        Sewa Alat
                    </label>
                </div>
                <!-- Search Button -->
                <button class="bg-brand-orange text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition w-full md:w-auto flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Sekarang
                </button>
            </div>
        </div>
    </section>

    <!-- JALUR PENDAKIAN -->
    <section class="pt-40 pb-20 px-4 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-brand-dark mb-4">Pilih Jalur Pendakianmu</h2>
            <p class="text-gray-500">Rinjani punya 6 jalur resmi. Temukan yang cocok dengan pengalaman dan waktumu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1629235882317-91247d0d085e?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Sembalun">
                    <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Pemula</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-brand-dark mb-2">Sembalun</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2">Savana luas yang paling populer, dengan medan mendaki bertahap dan padang savana.</p>
                    <div class="flex justify-between items-center text-sm text-gray-600 border-t pt-4">
                        <span><i class="fa-regular fa-clock mr-1"></i> 2-3 hari</span>
                        <span><i class="fa-solid fa-mountain mr-1"></i> Elevasi: 1.724 mdpl</span>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1542314570-58e3918e44ba?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Senaru">
                    <span class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">Menengah</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-brand-dark mb-2">Senaru</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2">Rute monoton lewat hutan tropis yang rindang. Cocok untuk menikmati keindahan Danau Segara Anak.</p>
                    <div class="flex justify-between items-center text-sm text-gray-600 border-t pt-4">
                        <span><i class="fa-regular fa-clock mr-1"></i> 3 hari</span>
                        <span><i class="fa-solid fa-mountain mr-1"></i> Akses: Segara Anak</span>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Torean">
                    <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Mahir</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-brand-dark mb-2">Torean</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2">Lebih dramatis namun menantang, jalur terjal dengan pemandangan lembah yang memukau.</p>
                    <div class="flex justify-between items-center text-sm text-gray-600 border-t pt-4">
                        <span><i class="fa-regular fa-clock mr-1"></i> 3-4 hari</span>
                        <span><i class="fa-solid fa-mountain mr-1"></i> Pemandangan Air Terjun</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <button class="border border-gray-300 text-brand-dark px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                Lihat Semua Jalur <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </div>
    </section>

    <!-- PEMANDU TERVERIFIKASI -->
    <section class="bg-white py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-brand-dark mb-2">Pemandu Terverifikasi</h2>
                    <p class="text-gray-500">Pemandu berlisensi resmi APGDI Inggris Rinjani.</p>
                </div>
                <a href="#" class="text-brand-orange font-semibold hover:underline hidden md:block">Lihat Semua Pemandu <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Guide 1 -->
                <div class="border border-gray-200 rounded-2xl p-6 relative">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Ahmad" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-brand-dark flex items-center gap-1">Ahmad Rifai <i class="fa-solid fa-circle-check text-blue-500 text-sm"></i></h3>
                            <p class="text-xs text-gray-500">Aik Berik</p>
                        </div>
                    </div>
                    <div class="flex items-center text-sm mb-4">
                        <span class="text-yellow-400 mr-2"><i class="fa-solid fa-star"></i> 4.9</span>
                        <span class="text-gray-400">(127 Ulasan)</span>
                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">APGDI Sertifikat</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-6">Tari Rias: Jalur Ekstrim</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <div>
                            <p class="text-xs text-gray-500">Mulai dari</p>
                            <p class="font-bold text-brand-orange">Rp 400.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        </div>
                        <button class="bg-brand-orange text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">Detail & Pesan</button>
                    </div>
                </div>

                <!-- Guide 2 -->
                <div class="border border-gray-200 rounded-2xl p-6 relative">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-brand-dark flex items-center gap-1">Siti Rahayu <i class="fa-solid fa-circle-check text-blue-500 text-sm"></i></h3>
                            <p class="text-xs text-gray-500">Sembalun</p>
                        </div>
                    </div>
                    <div class="flex items-center text-sm mb-4">
                        <span class="text-yellow-400 mr-2"><i class="fa-solid fa-star"></i> 4.8</span>
                        <span class="text-gray-400">(200 Ulasan)</span>
                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">APGDI Sertifikat</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-6">Tari Rias: Jalur Ekstrim</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <div>
                            <p class="text-xs text-gray-500">Mulai dari</p>
                            <p class="font-bold text-brand-orange">Rp 375.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        </div>
                        <button class="bg-brand-orange text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">Detail & Pesan</button>
                    </div>
                </div>

                <!-- Guide 3 -->
                <div class="border border-gray-200 rounded-2xl p-6 relative">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Budi" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-brand-dark flex items-center gap-1">Budi Santoso <i class="fa-solid fa-circle-check text-blue-500 text-sm"></i></h3>
                            <p class="text-xs text-gray-500">Aik Berik</p>
                        </div>
                    </div>
                    <div class="flex items-center text-sm mb-4">
                        <span class="text-yellow-400 mr-2"><i class="fa-solid fa-star"></i> 4.7</span>
                        <span class="text-gray-400">(89 Ulasan)</span>
                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">APGDI Sertifikat</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-6">Tari Rias: Jalur Ekstrim</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <div>
                            <p class="text-xs text-gray-500">Mulai dari</p>
                            <p class="font-bold text-brand-orange">Rp 425.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        </div>
                        <button class="bg-brand-orange text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-600 transition">Detail & Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ALAT OUTDOOR POPULER -->
    <section class="py-20 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-serif font-bold text-brand-dark mb-2">Alat Outdoor Populer</h2>
                <p class="text-gray-500">Alat berkualitas dari toko rental terpercaya.</p>
            </div>
            <a href="#" class="text-brand-orange font-semibold hover:underline hidden md:block">Lihat Semua Alat <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Alat 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col">
                <div class="relative h-56">
                    <img src="https://images.unsplash.com/photo-1504280387966-2b87855d93af?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Tenda">
                    <span class="absolute top-4 left-4 bg-white/90 text-brand-dark text-xs font-bold px-3 py-1 rounded-full">Pak Sembalun</span>
                    <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Stok: 10</span>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-brand-dark mb-1">Tenda Dome 4P</h3>
                        <p class="text-sm text-gray-500 mb-4">Toko Rinjani Outdoor</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto">
                        <p class="font-bold text-brand-orange">Rp 45.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        <button class="border border-brand-dark text-brand-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-dark hover:text-white transition">Sewa Alat</button>
                    </div>
                </div>
            </div>
            <!-- Alat 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col">
                <div class="relative h-56">
                    <img src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Sleeping Bag">
                    <span class="absolute top-4 left-4 bg-white/90 text-brand-dark text-xs font-bold px-3 py-1 rounded-full">Pak Senaru</span>
                    <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Stok: 10</span>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-brand-dark mb-1">Sleeping Bag</h3>
                        <p class="text-sm text-gray-500 mb-4">Toko Rinjani Camp</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto">
                        <p class="font-bold text-brand-orange">Rp 25.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        <button class="border border-brand-dark text-brand-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-dark hover:text-white transition">Sewa Alat</button>
                    </div>
                </div>
            </div>
            <!-- Alat 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col">
                <div class="relative h-56">
                    <img src="https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover" alt="Carrier">
                    <span class="absolute top-4 left-4 bg-white/90 text-brand-dark text-xs font-bold px-3 py-1 rounded-full">Pak Sembalun</span>
                    <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Stok: 10</span>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-brand-dark mb-1">Carrier 60L</h3>
                        <p class="text-sm text-gray-500 mb-4">Toko Sembalun Gear</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto">
                        <p class="font-bold text-brand-orange">Rp 50.000 <span class="text-sm text-gray-500 font-normal">/hari</span></p>
                        <button class="border border-brand-dark text-brand-dark px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-dark hover:text-white transition">Sewa Alat</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section class="bg-white py-20 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <!-- Gambar Kiri -->
            <div class="w-full md:w-1/2 relative">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=1000&auto=format&fit=crop" alt="Tim Rinjani" class="rounded-2xl shadow-lg w-full h-[400px] object-cover">
                <div class="absolute -bottom-6 -right-6 bg-brand-dark text-white p-4 rounded-xl shadow-xl flex items-center gap-3">
                    <i class="fa-solid fa-leaf text-2xl text-brand-orange"></i>
                    <div>
                        <p class="font-bold">Pemberdayaan Warga Lokal</p>
                        <p class="text-xs text-gray-300">Bersama Taman Nasional Rinjani</p>
                    </div>
                </div>
            </div>
            <!-- Teks Kanan -->
            <div class="w-full md:w-1/2">
                <span class="text-brand-orange font-semibold text-sm tracking-wider uppercase mb-2 block">Profil Komunitas</span>
                <h2 class="text-4xl font-serif font-bold text-brand-dark mb-6">Tentang Kami</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    RinjaniGuide & Rental adalah platform yang menghubungkan pendaki dengan pemandu lokal dan toko rental alat outdoor di lingkar Gunung Rinjani. Kami berkomitmen memberdayakan pelaku usaha lokal dan mempermudah perjalanan pendaki.
                </p>
                
                <!-- Statistik -->
                <div class="grid grid-cols-3 gap-6 mb-8 border-y py-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-brand-dark mb-1">36</p>
                        <p class="text-sm text-gray-500">Mitra Aktif</p>
                    </div>
                    <div class="text-center border-x">
                        <p class="text-3xl font-bold text-brand-dark mb-1">128</p>
                        <p class="text-sm text-gray-500">Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-brand-dark mb-1">4.8 <i class="fa-solid fa-star text-yellow-400 text-xl"></i></p>
                        <p class="text-sm text-gray-500">Rating Rata-rata</p>
                    </div>
                </div>
                
                <button class="border border-gray-300 text-brand-dark px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Selengkapnya
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 px-4 max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-brand-dark mb-4">Pertanyaan Umum</h2>
            <p class="text-gray-500">Jawaban cepat untuk pertanyaan yang sering diajukan seputar pemesanan & layanan.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <details class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 group cursor-pointer">
                <summary class="font-semibold text-brand-dark flex justify-between items-center outline-none list-none">
                    Berapa komisi platform?
                    <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-gray-600 text-sm mt-4 pt-4 border-t">Komisi 10% per transaksi berhasil. Tidak ada biaya pendaftaran.</p>
            </details>
            <!-- FAQ 2 -->
            <details class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 group cursor-pointer">
                <summary class="font-semibold text-brand-dark flex justify-between items-center outline-none list-none">
                    Bagaimana cara membayar?
                    <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-gray-600 text-sm mt-4 pt-4 border-t">Pembayaran melalui transfer bank, e-wallet, atau QRIS.</p>
            </details>
            <!-- FAQ 3 -->
            <details class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 group cursor-pointer">
                <summary class="font-semibold text-brand-dark flex justify-between items-center outline-none list-none">
                    Apakah pemandu berlisensi?
                    <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-gray-600 text-sm mt-4 pt-4 border-t">Ya, semua pemandu yang terdaftar telah memiliki sertifikasi resmi dari APGDI.</p>
            </details>
            <!-- FAQ 4 -->
            <details class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 group cursor-pointer">
                <summary class="font-semibold text-brand-dark flex justify-between items-center outline-none list-none">
                    Apakah data KTP saya aman?
                    <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-gray-600 text-sm mt-4 pt-4 border-t">Data Anda dienkripsi dan hanya digunakan untuk keperluan verifikasi identitas.</p>
            </details>
        </div>
        
        <div class="mt-8 text-center">
            <button class="border border-gray-300 text-brand-dark px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition">
                Lihat Semua FAQ
            </button>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="px-4 pb-20">
        <div class="max-w-5xl mx-auto bg-brand-dark rounded-3xl p-12 text-center relative overflow-hidden">
            <!-- Ornamen -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green rounded-full mix-blend-multiply filter blur-3xl opacity-50 translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-green rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-x-1/2 translate-y-1/2"></div>
            
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-white mb-4 relative z-10">Siap Mendaki Rinjani?</h2>
            <p class="text-gray-300 mb-8 relative z-10 max-w-xl mx-auto">
                Pesan pemandu lokal bersertifikat dan sewa alat selengkapnya untuk memastikan kelancaran dan keselamatan ekspedisimu.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                <button class="bg-brand-orange text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">Cari Pemandu</button>
                <button class="bg-white text-brand-dark px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Sewa Alat</button>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#162A1F] text-gray-300 py-16 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-brand-orange rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-white"></i>
                    </div>
                    <span class="font-bold text-lg text-white">RinjaniGuide & Rental</span>
                </div>
                <p class="text-sm leading-relaxed mb-6">
                    Platform booking pemandu, paket, dan sewa alat outdoor resmi di Gunung Rinjani.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-orange transition"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </div>
            
            <!-- Menu Pendaki -->
            <div>
                <h4 class="text-white font-semibold mb-6">Menu Pendaki</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-brand-orange transition">Home</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Guide</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Rental</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Info</a></li>
                </ul>
            </div>
            
            <!-- Menu Info -->
            <div>
                <h4 class="text-white font-semibold mb-6">Menu Info</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-brand-orange transition">Cara Pesan</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Jalur Pendakian</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-brand-orange transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            
            <!-- Kontak -->
            <div>
                <h4 class="text-white font-semibold mb-6">Kontak</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-brands fa-whatsapp mt-1 text-brand-orange"></i>
                        <span>WhatsApp: 0812-3456-7890</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-regular fa-envelope mt-1 text-brand-orange"></i>
                        <span>Email: info@rinjaniguide.id</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-brand-orange"></i>
                        <span>Alamat: Jl. Sembalun No. 12, Lombok, NTB</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
            <p>&copy; 2026 RinjaniGuide & Rental. Hak cipta dilindungi undang-undang.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                <span>&bull;</span>
                <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>