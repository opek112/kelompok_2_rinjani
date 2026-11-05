@extends('layouts.partner')

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

    <x-stepper step="1" type="guide" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-[#143529] text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span> Data Akun
        </h2>

        <form action="#" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">👤</span>
                    <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Joko Wijaya">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">✉️</span>
                        <input type="email" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="joko.wijaya@gmail.com">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">No. WhatsApp</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">📞</span>
                        <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="0819-1234-5678">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">🔒</span>
                    <input type="password" class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="RinjaniExpedition2026!">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">👁️</span>
                </div>
                <!-- Password Strength Bar -->
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Kekuatan Kata Sandi:</span>
                    <span class="text-xs font-bold text-green-600 flex items-center gap-1">✅ Kuat</span>
                </div>
                <div class="flex gap-1 mt-1">
                    <div class="h-1.5 w-full bg-green-500 rounded-full"></div>
                    <div class="h-1.5 w-full bg-green-500 rounded-full"></div>
                    <div class="h-1.5 w-full bg-green-500 rounded-full"></div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">🔄</span>
                    <input type="password" class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="RinjaniExpedition2026!">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">👁️</span>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg flex items-start gap-3 mb-8">
                <input type="checkbox" class="mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <label class="text-xs text-gray-600">Saya menyetujui <a href="#" class="text-orange-500 font-semibold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-orange-500 font-semibold hover:underline">Kebijakan Privasi</a> kemitraan resmi RinjaniGuide. Saya menyatakan data sertifikasi dan identitas yang dilampirkan adalah sah dan valid.</label>
            </div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                Lanjut Data Kepemanduan →
            </button>
        </form>
    </div>
    
    <p class="text-center text-sm text-gray-600">Sudah punya akun mitra? <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Masuk</a></p>
@endsection