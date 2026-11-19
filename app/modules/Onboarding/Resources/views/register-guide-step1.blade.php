@extends('Onboarding::layouts.partner')

@section('title', 'Daftar Pemandu')
@section('portal-subtitle', 'Portal Kemitraan Pemandu')
@section('portal-badge', 'Mitra Pemandu')
@section('hero-title', 'Jadilah Pemandu Resmi RinjaniGuide.')
@section('hero-desc', 'Dapatkan akses langsung ke ribuan pendaki domestik dan mancanegara yang terverifikasi setiap musim. Terhubung dengan SOP keselamatan TNGR bersertifikasi.')
@section('hero-features')
    <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl border border-white/5">
        <div class="bg-orange-500 rounded p-1 mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
        <div><h4 class="text-sm font-bold">Tanpa biaya pendaftaran</h4><p class="text-xs text-gray-300">Registrasi gratis 100% tanpa pungutan registrasi awal.</p></div>
    </div>
    <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl border border-white/5">
        <div class="bg-orange-500 rounded p-1 mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
        <div><h4 class="text-sm font-bold">Komisi hanya 10%</h4><p class="text-xs text-gray-300">Struktur bagi hasil transparan untuk perlindungan penghasilan.</p></div>
    </div>
@endsection

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Daftar Sebagai Pemandu</h1>
    <p class="text-sm text-gray-500 mb-8">Lengkapi data untuk bergabung sebagai mitra pemandu resmi Taman Nasional Gunung Rinjani.</p>

    <!-- Komponen Stepper (Garis Petunjuk) -->
    <x-stepper step="1" type="guide" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-[#143529] text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span> Data Akun
        </h2>

        <!-- FORM DIMULAI DI SINI -->
        <form action="{{ route('register.guide.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">👤</span>
                    <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Joko Wijaya">
                </div>
                @error('nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Email & WA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">✉️</span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="joko.wijaya@gmail.com">
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">No. WhatsApp</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">📞</span>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="0819-1234-5678">
                    </div>
                    @error('no_telepon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password_guide" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">🔒</span>
                    <input id="password_guide" type="password" name="password" required autocomplete="new-password"
                        class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Minimal 8 karakter">

                    <button type="button" data-toggle-sandi="password_guide"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 focus:outline-none"
                        aria-label="Tampilkan kata sandi">
                        <svg data-mata-buka class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg data-mata-tutup class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0 1 12 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 0 1 1.563-3.029m5.858.908a3 3 0 1 1 4.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532 3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0 1 12 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 0 1-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_guide_confirm" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">🔄</span>
                    <input id="password_guide_confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Ulangi kata sandi">

                    <button type="button" data-toggle-sandi="password_guide_confirm"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 focus:outline-none"
                        aria-label="Tampilkan konfirmasi kata sandi">
                        <svg data-mata-buka class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg data-mata-tutup class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0 1 12 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 0 1 1.563-3.029m5.858.908a3 3 0 1 1 4.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532 3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0 1 12 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 0 1-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Checkbox S&K -->
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg flex items-start gap-3 mb-8">
                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <label class="text-xs text-gray-600">Saya menyetujui <a href="#" class="text-orange-500 font-semibold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-orange-500 font-semibold hover:underline">Kebijakan Privasi</a> kemitraan resmi RinjaniGuide.</label>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                Lanjut Data Kepemanduan →
            </button>
        </form>
        <!-- FORM SELESAI -->
    </div>
    
    <p class="text-center text-sm text-gray-600">Sudah punya akun mitra? <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Masuk</a></p>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-toggle-sandi]').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            var input = document.getElementById(tombol.dataset.toggleSandi);
            if (!input) return;

            var tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            tombol.querySelector('[data-mata-buka]').classList.toggle('hidden', tampil);
            tombol.querySelector('[data-mata-tutup]').classList.toggle('hidden', !tampil);
            tombol.setAttribute('aria-label', tampil ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    });
</script>
@endpush