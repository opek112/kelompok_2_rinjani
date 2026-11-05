@extends('layouts.partner') {{-- Sesuaikan jika layout Anda berbeda --}}

@section('title', 'Data Kepemanduan')
@section('portal-subtitle', 'Portal Kemitraan Pemandu')
@section('portal-badge', 'Mitra Pemandu')
@section('hero-title', 'Jadilah Pemandu Resmi RinjaniGuide.')
@section('hero-desc', 'Lengkapi data profesional Anda untuk bergabung dengan ekosistem kami.')

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Data Kepemanduan</h1>
    <p class="text-sm text-gray-500 mb-8">Lengkapi data profesional Anda.</p>

    <!-- STEPPER: Ubah step menjadi 2 -->
    <x-stepper step="2" type="guide" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span> Data Kepemanduan
        </h2>

        <form action="{{ route('register.guide.step2.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nomor Lisensi Kepemanduan</label>
                <input type="text" name="nomor_lisensi" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Contoh: APGI-2024-0187">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Tarif Harian (Rp)</label>
                <input type="number" name="tarif_harian" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Contoh: 400000">
            </div>

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Bio Singkat</label>
                <textarea name="bio" required rows="4" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('register.guide') }}" class="w-1/3 bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center transition hover:bg-gray-50">
                    ← Kembali
                </a>
                <button type="submit" class="w-2/3 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                    Lanjut ke Sertifikat →
                </button>
            </div>
        </form>
    </div>
@endsection