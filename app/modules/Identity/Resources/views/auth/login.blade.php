<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex">
        
        <!-- KIRI: Bagian Gambar & Info -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#143529] text-white flex-col justify-between p-12 bg-cover bg-center" style="background-image: url('https://statik.tempo.co/data/2018/11/26/id_799732/799732_720.jpg');">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative z-10">
                <div class="mb-8 flex gap-4 text-xs font-semibold">
                    <span class="border border-white/30 rounded-full px-3 py-1">MITRA RESMI TNGR</span>
                    <span class="border border-white/30 rounded-full px-3 py-1">⛰️ 3.726 mdpl</span>
                </div>
                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block tracking-wider">PORTAL AUTENTIKASI</span>
                <h1 class="text-5xl font-serif font-bold mb-4 leading-tight">Selamat datang kembali, pendaki.</h1>
                <p class="text-gray-300 mb-8 max-w-md text-sm">Akses riwayat ekspedisi, status e-voucher pendakian, dan kemudahan booking perlengkapan di lereng Gunung Rinjani dengan standar operasional resmi.</p>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm border border-white/5"><span class="text-orange-400">🛡️</span> Pemandu berlisensi resmi APGI</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm border border-white/5"><span class="text-orange-400">🎒</span> Alat outdoor terstandarisasi & terawat</div>
                    <div class="flex items-center gap-3 bg-white/10 p-3 rounded-lg text-sm border border-white/5"><span class="text-orange-400">💳</span> Pembayaran aman via QRIS instan</div>
                </div>
            </div>
            <div class="relative z-10 text-xs text-gray-400 flex justify-between items-center border-t border-white/20 pt-6 mt-12">
                <div>👨‍💼 Standar Ekpedisi Berkelanjutan<br><span class="text-[10px]">Sembalun • Senaru • Torean</span></div>
                <div>© RinjaniGuide TNGR</div>
            </div>
        </div>

        <!-- KANAN: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto h-screen">
            <div class="w-full max-w-md">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">R</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">RinjaniGuide <span class="font-normal text-gray-500">& Rental</span></h2>
                        <p class="text-[10px] text-gray-500 tracking-widest uppercase">Portal Autentikasi</p>
                    </div>
                    <span class="ml-auto text-xs font-semibold border border-gray-200 bg-gray-50 rounded-full px-3 py-1.5 text-gray-600">Masuk Akun</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun Anda</h1>
                <p class="text-sm text-gray-500 mb-6">Pendaki juga bisa pesan perlengkapan atau sewa porter sebagai tamu tanpa daftar.</p>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">✉️</span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                                placeholder="nama@email.com">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">🔒</span>
                            <input type="password" id="password_login" name="password" required autocomplete="current-password"
                                class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                                placeholder="Masukkan kata sandi">
                            
                            <!-- TOMBOL TOGGLE MATA -->
                            <button type="button" onclick="togglePassword('password_login', 'eye_open_login', 'eye_closed_login')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 focus:outline-none">
                                <svg id="eye_open_login" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg id="eye_closed_login" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-orange-500 hover:underline font-semibold" href="{{ route('password.request') }}">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30 text-sm">
                        Masuk ke Akun <span class="text-lg">→</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">Daftar</a>
                </div>
                
                <!-- CTA MITRA -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <p class="text-center text-sm text-gray-500 mb-4">Ingin bergabung sebagai mitra?</p>
                    <div class="flex gap-3">
                        <a href="{{ url('/daftar-guide') }}" class="flex-1 border border-gray-300 rounded-xl py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-orange-500 flex justify-center items-center gap-2 transition">
                            🧗‍♂️ Sebagai Pemandu
                        </a>
                        <a href="{{ url('/daftar-rental') }}" class="flex-1 border border-gray-300 rounded-xl py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-orange-500 flex justify-center items-center gap-2 transition">
                            🏪 Sebagai Toko Rental
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JAVASCRIPT UNTUK TOGGLE PASSWORD -->
    <script>
        function togglePassword(inputId, eyeOpenId, eyeClosedId) {
            const input = document.getElementById(inputId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>