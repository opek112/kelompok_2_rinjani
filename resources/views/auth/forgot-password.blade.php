<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Kata Sandi - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex">
        
        <!-- KIRI: Bagian Gambar & Info -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 text-white flex-col justify-between p-12 bg-cover bg-center" style="background-image: url('https://statik.tempo.co/data/2018/11/26/id_799732/799732_720.jpg');">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10">
                <div class="mb-8 flex gap-4 text-xs font-semibold">
                    <span class="border border-white/30 rounded-full px-3 py-1">MITRA RESMI TNGR</span>
                    <span class="border border-white/30 rounded-full px-3 py-1">⛰️ 3.726 mdpl</span>
                </div>
                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block">PEMULIHAN AKUN</span>
                <h1 class="text-5xl font-bold mb-4 leading-tight">Kami bantu kamu kembali ke jalur.</h1>
                <p class="text-gray-300 mb-8 max-w-md">Akses kembali akun pendakianmu dengan aman untuk melanjutkan persiapan ekspedisi ke puncak Rinjani.</p>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">🛡️</span> <div><strong>Aman</strong><br><span class="text-xs text-gray-300">Enkripsi token reset berstandar keamanan tinggi</span></div></div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">⚡</span> <div><strong>Cepat</strong><br><span class="text-xs text-gray-300">Tautan verifikasi dikirim seketika ke email Anda</span></div></div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">✅</span> <div><strong>Terverifikasi</strong><br><span class="text-xs text-gray-300">Perlindungan data akun dan riwayat pemesanan</span></div></div>
                </div>
            </div>
            <div class="relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-4">
                <div>👨‍💼 Standar Ekpedisi Berkelanjutan<br><span class="text-[10px]">Sembalun • Senaru • Torean</span></div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Form Lupa Sandi -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md mx-auto">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">R</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">RinjaniGuide</h2>
                        <p class="text-[10px] text-gray-500 tracking-widest">Guide & Rental Service/p>
                    </div>
                    <span class="ml-auto text-xs font-semibold border border-gray-300 rounded px-2 py-1 text-gray-600">Lupa Sandi</span>
                </div>

                <!-- Card Form -->
                <div class="border border-gray-200 rounded-2xl p-6 shadow-sm mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xs font-bold text-orange-500 flex items-center gap-1">🔄 RESET SANDI</span>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Langkah 1 dari 2</span>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Lupa Kata Sandi?</h1>
                    <p class="text-sm text-gray-500 mb-6">Masukkan email terdaftar. Kami akan mengirim tautan reset ke email Anda.</p>

                    <!-- Session Status (Pesan Sukses) -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Email Terdaftar</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                placeholder="andi.pratama@email.com">
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">ℹ️ Pastikan email sesuai dengan yang digunakan saat mendaftar akun.</p>
                        </div>

                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg flex justify-center items-center gap-2 transition text-sm mt-6">
                            Kirim Tautan Reset <span class="text-lg">→</span>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-orange-500 hover:underline font-semibold">← Kembali ke Login</a>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4 text-center">
                        <p class="text-xs text-gray-600 flex items-center justify-center gap-1">
                            <span class="text-green-500">💬</span> Butuh bantuan langsung? <a href="#" class="font-bold hover:underline">Hubungi Admin Basecamp via WhatsApp</a>
                        </p>
                    </div>
                </div>

                <!-- Footer Bawah -->
                <div class="text-center text-[10px] text-gray-400 flex justify-between items-center">
                    <div>© 2026 RinjaniGuide & Rental.<br>Hak cipta dilindungi undang-undang.</div>
                    <div class="flex gap-3">
                        <a href="#" class="hover:underline">Privasi</a>
                        <a href="#" class="hover:underline">Ketentuan SOP APGI</a>
                        <a href="#" class="hover:underline">Pusat Evaluasi</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>