<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RinjaniGuide</title>
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
                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block">PORTAL AUTENTIKASI</span>
                <h1 class="text-5xl font-bold mb-4 leading-tight">Selamat datang kembali, pendaki.</h1>
                <p class="text-gray-300 mb-8 max-w-md">Akses riwayat ekspedisi, status e-voucher pendakian, dan kemudahan booking perlengkapan di lereng Gunung Rinjani dengan standar operasional resmi.</p>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">🛡️</span> Pemandu berlisensi resmi APGI</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">🎒</span> Alat outdoor terstandarisasi & terawat</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm"><span class="text-orange-400">💳</span> Pembayaran aman via QRIS instan</div>
                </div>
            </div>
            <div class="relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-4">
                <div>👨‍💼 Standar Ekpedisi Berkelanjutan<br><span class="text-[10px]">Sembalun • Senaru • Torean</span></div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">R</div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">RinjaniGuide</h2>
                        <p class="text-[10px] text-gray-500 tracking-widest">Guide & Rental Service</p>
                    </div>
                    <span class="ml-auto text-xs font-semibold border border-gray-300 rounded px-2 py-1 text-gray-600">Masuk Akun</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun Anda</h1>
                <p class="text-sm text-gray-500 mb-6">Pendaki juga bisa pesan perlengkapan atau sewa porter sebagai tamu tanpa daftar.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                            placeholder="nama@email.com">
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" required autocomplete="current-password"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm pr-10"
                                placeholder="Masukkan kata sandi">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">👁️</span>
                        </div>
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-orange-500 hover:underline font-semibold" href="{{ route('password.request') }}">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg flex justify-center items-center gap-2 transition text-sm">
                        Masuk ke Akun <span class="text-lg">→</span>
                    </button>
                    
                    <div class="relative flex py-5 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-xs">ATAU</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <a href="#" class="w-full bg-white border border-gray-800 text-gray-800 font-bold py-3 px-4 rounded-lg flex justify-center items-center gap-2 hover:bg-gray-50 transition text-sm">
                        👤 Lanjut sebagai Tamu (Pendaki)
                    </a>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">Daftar</a>
                </div>
                
                <div class="mt-8 border border-gray-200 rounded-xl p-4 text-center bg-gray-50">
                    <p class="text-xs text-gray-600 mb-3 flex items-center justify-center gap-1"><span class="text-orange-500">⬇️</span> Ingin masuk sebagai mitra?</p>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 bg-white border border-gray-300 rounded-lg py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 flex justify-center items-center gap-2">🧗‍♂️ Sebagai Pemandu</a>
                        <a href="#" class="flex-1 bg-white border border-gray-300 rounded-lg py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 flex justify-center items-center gap-2">🏪 Sebagai Toko Rental</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>