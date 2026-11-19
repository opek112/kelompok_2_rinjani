@extends('Onboarding::layouts.partner')

@section('title', 'Daftar Toko Rental')
@section('portal-subtitle', 'Portal Kemitraan Toko Rental')
@section('portal-badge', 'Mitra Toko Rental')
@section('hero-title', 'Kembangkan Usaha Rental Anda.')
@section('hero-desc', 'Dapatkan akses langsung ke ribuan pendaki domestik dan mancanegara setiap musim. Maksimalkan utilisasi tenda, carrier, dan peralatan pendakian Anda dengan sistem reservasi otomatis.')
@section('hero-features')
    <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl border border-white/5">
        <div class="bg-orange-500 rounded p-1 mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg></div>
        <div><h4 class="text-sm font-bold">Tanpa biaya pendaftaran</h4><p class="text-xs text-gray-300">Registrasi gratis 100% tanpa potongan pendaftaran awal.</p></div>
    </div>
    <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl border border-white/5">
        <div class="bg-orange-500 rounded p-1 mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg></div>
        <div><h4 class="text-sm font-bold">Dashboard inventaris lengkap</h4><p class="text-xs text-gray-300">Manajemen stok unit alat, status barang, dan konfirmasi serah terima.</p></div>
    </div>
@endsection

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Daftar Sebagai Toko Rental</h1>
    <p class="text-sm text-gray-500 mb-8">Lengkapi data untuk bergabung sebagai mitra rental resmi Taman Nasional Gunung Rinjani.</p>

    <!-- Komponen Stepper (Garis Petunjuk) -->
    <x-stepper step="1" type="rental" />

    <div class="sheet reveal bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6" style="--d: 140ms">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-[#143529] text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span> Data Akun Pemilik
        </h2>

        <!-- FORM DIMULAI DI SINI -->
        <form action="{{ route('register.rental.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Lengkap Pemilik</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </span>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="name"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                        placeholder="Bambang Kurniawan">
                </div>
                @error('nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Email & WA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                            placeholder="bambang.outdoor@gmail.com">
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="no_telepon" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">No. WhatsApp</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"></path></svg>
                        </span>
                        <input id="no_telepon" type="text" name="no_telepon" value="{{ old('no_telepon') }}" required autocomplete="tel"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                            placeholder="0812-9876-5432">
                    </div>
                    @error('no_telepon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password_rental" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>
                    </span>
                    <input id="password_rental" type="password" name="password" required minlength="8"
                        autocomplete="new-password" passwordrules="minlength: 8; required: lower, upper, digit;"
                        class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                        placeholder="Minimal 8 karakter">

                    <button type="button" data-toggle-sandi="password_rental"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 focus:outline-none"
                        aria-label="Tampilkan kata sandi">
                        <svg data-mata-buka class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg data-mata-tutup class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0 1 12 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 0 1 1.563-3.029m5.858.908a3 3 0 1 1 4.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532 3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0 1 12 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 0 1-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>

                <!-- Indikator kekuatan sandi -->
                <div class="mt-2 flex items-center gap-2">
                    <div class="flex h-1 flex-1 gap-1" aria-hidden="true">
                        <span data-meter="1" class="h-full flex-1 rounded-full bg-gray-200 transition"></span>
                        <span data-meter="2" class="h-full flex-1 rounded-full bg-gray-200 transition"></span>
                        <span data-meter="3" class="h-full flex-1 rounded-full bg-gray-200 transition"></span>
                        <span data-meter="4" class="h-full flex-1 rounded-full bg-gray-200 transition"></span>
                    </div>
                    <span data-meter-label class="text-[11px] text-gray-400">Belum diisi</span>
                </div>
                <p class="text-[11px] text-gray-500 mt-1">Gunakan minimal 8 karakter dengan huruf besar, angka, dan simbol.</p>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_rental_confirm" class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 2v6h-6"></path><path d="M3 12a9 9 0 0 1 15-6.7L21 8"></path><path d="M3 22v-6h6"></path><path d="M21 12a9 9 0 0 1-15 6.7L3 16"></path></svg>
                    </span>
                    <input id="password_rental_confirm" type="password" name="password_confirmation" required minlength="8"
                        autocomplete="new-password"
                        class="w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm transition"
                        placeholder="Ulangi kata sandi">

                    <button type="button" data-toggle-sandi="password_rental_confirm"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 focus:outline-none"
                        aria-label="Tampilkan konfirmasi kata sandi">
                        <svg data-mata-buka class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg data-mata-tutup class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0 1 12 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 0 1 1.563-3.029m5.858.908a3 3 0 1 1 4.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532 3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0 1 12 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 0 1-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Checkbox S&K -->
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg flex items-start gap-3 mb-8">
                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <label class="text-xs text-gray-600">Saya menyetujui <a href="#" class="text-orange-500 font-semibold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-orange-500 font-semibold hover:underline">Kebijakan Privasi</a> kemitraan resmi RinjaniGuide.</label>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="cta w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                Lanjut Data Toko
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m13 6 6 6-6 6"></path></svg>
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
        });
    });

    (function () {
        var input = document.getElementById('password_rental');
        var meter = document.querySelectorAll('[data-meter]');
        var label = document.querySelector('[data-meter-label]');
        if (!input || !meter.length) return;

        var warna = ['bg-red-400', 'bg-amber-400', 'bg-lime-500', 'bg-green-500'];
        var teks = ['Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];

        input.addEventListener('input', function () {
            var nilai = input.value;
            var skor = 0;
            if (nilai.length >= 8) skor++;
            if (/[A-Z]/.test(nilai) && /[a-z]/.test(nilai)) skor++;
            if (/[0-9]/.test(nilai)) skor++;
            if (/[^A-Za-z0-9]/.test(nilai)) skor++;

            meter.forEach(function (batang, i) {
                batang.className = 'h-full flex-1 rounded-full transition ' + (i < skor ? warna[skor - 1] : 'bg-gray-200');
            });

            label.textContent = nilai === '' ? 'Belum diisi' : teks[Math.max(0, skor - 1)];
            label.className = 'text-[11px] ' + (nilai === '' ? 'text-gray-400' : 'text-gray-600');
        });
    })();
</script>
@endpush
