<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Akun - RinjaniGuide</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts (Vite & Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex">
        
        <!-- KIRI: Bagian Gambar & Info (Sembunyikan di HP) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 text-white flex-col justify-between p-12 bg-cover bg-center" style="background-image: url('https://statik.tempo.co/data/2018/11/26/id_799732/799732_720.jpg');">
            <!-- Overlay gelap -->
            <div class="absolute inset-0 bg-black/60"></div>
            
            <!-- Konten Kiri -->
            <div class="relative z-10">
                <div class="mb-8 flex gap-4 text-xs font-semibold">
                    <span class="border border-white/30 rounded-full px-3 py-1">MITRA RESMI TNGR</span>
                    <span class="border border-white/30 rounded-full px-3 py-1">⛰️ 3.726 mdpl</span>
                </div>
                <h1 class="text-5xl font-bold mb-4 leading-tight">Mulai perjalananmu ke puncak Rinjani.</h1>
                <p class="text-gray-300 mb-8 max-w-md">Akses mudah menuju keagungan Danau Segara Anak dan Puncak Anjani dengan standar operasional keselamatan tinggi serta perlengkapan gunung teruji cuaca.</p>
                
                <!-- List Fitur -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">🛡️</span> Pemandu berlisensi resmi APGI</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">🎒</span> Alat outdoor terstandarisasi & terawat</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">💳</span> Pembayaran aman via QRIS instan</div>
                </div>
            </div>
            
            <!-- Footer Kiri -->
            <div class="relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-4">
                <div>👨‍💼 Standar Ekpedisi Berkelanjutan</div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Form Register -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">R</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">RinjaniGuide</h2>
                        <p class="text-[10px] text-gray-500 tracking-widest">Guide & Rental Service</p>
                    </div>
                    <span class="ml-auto text-xs font-semibold border border-gray-300 rounded px-2 py-1 text-gray-600">Registrasi Pendaki</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 mb-6">Daftar untuk pengalaman pemesanan yang lebih mudah.</p>

                <!-- Form Start -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama Lengkap (Sesuaikan dengan DB: nama) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="name"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                            placeholder="Contoh: Andi Pratama">
                        @error('nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                            placeholder="nama@email.com">
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- No WhatsApp (Sesuaikan dengan DB: no_telepon) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+62</span>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required
                                class="w-full border-gray-300 rounded-r-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                placeholder="812-3456-7890">
                        </div>
                        @error('no_telepon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <input type="password" name="password" required autocomplete="new-password"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                            placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                            placeholder="Ulangi kata sandi">
                    </div>

                    <!-- Checkbox S&K -->
                    <div class="mb-6 flex items-start">
                        <input type="checkbox" name="terms" required class="mt-1 rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500">
                        <label class="ml-2 block text-xs text-gray-600">
                            Saya menyetujui <a href="#" class="text-orange-500 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-orange-500 hover:underline">Kebijakan Privasi</a>.
                        </label>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg flex justify-center items-center gap-2 transition text-sm">
                        Daftar Akun Sekarang <span class="text-lg">→</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Masuk</a>
                </div>
                
                <div class="mt-8 border-t border-gray-200 pt-6 text-center">
                    <p class="text-xs text-gray-500 mb-3">Ingin bergabung sebagai mitra?</p>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 border border-gray-300 rounded-lg py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 flex justify-center items-center gap-2">🧗‍♂️ Sebagai Pemandu</a>
                        <a href="#" class="flex-1 border border-gray-300 rounded-lg py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 flex justify-center items-center gap-2">🏪 Sebagai Toko Rental</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>