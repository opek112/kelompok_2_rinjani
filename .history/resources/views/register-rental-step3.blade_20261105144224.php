@extends('layouts.partner')

@section('title', 'Legalitas & Rekening')
@section('portal-subtitle', 'Portal Kemitraan Toko Rental')
@section('portal-badge', 'Mitra Toko Rental')
@section('hero-title', 'Kembangkan Usaha Rental Anda.')
@section('hero-desc', 'Langkah terakhir sebelum verifikasi toko Anda.')

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Legalitas & Rekening</h1>
    <p class="text-sm text-gray-500 mb-8">Langkah terakhir sebelum verifikasi.</p>

    <!-- STEPPER: Ubah step menjadi 3 -->
    <x-stepper step="3" type="rental" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span> Legalitas Usaha & Bank
        </h2>

        <form action="{{ route('register.rental.step3.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h3 class="text-sm font-bold text-gray-800 mb-4">Legalitas Usaha</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">NIB (Nomor Induk Berusaha)</label>
                    <input type="text" name="nib" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="1234567890123">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">NPWP Usaha / Pribadi</label>
                    <input type="text" name="npwp" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="01.234.567.8-901.000">
                </div>
            </div>

            <!-- Area Upload Dokumen (Hiasan UI) -->
            <div class="mb-8 border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50">
                <div class="text-3xl mb-2">📸</div>
                <h4 class="text-sm font-bold text-gray-800 mb-1">Unggah Dokumen Legalitas</h4>
                <p class="text-xs text-gray-500 mb-4">NIB/NPWP/Akta Pendirian (PDF/JPG/PNG, maks 5 MB).</p>
                <button type="button" class="bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-sm hover:bg-gray-50 transition text-sm">
                    ☁️ Pilih Berkas
                </button>
            </div>

            <h3 class="text-sm font-bold text-gray-800 mb-4">Rekening Pencairan</h3>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Bank</label>
                <input type="text" name="nama_bank" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Contoh: Bank Central Asia (BCA)">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nomor Rekening</label>
                    <input type="text" name="nomor_rekening" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="0561928374">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Pemilik Rekening</label>
                    <input type="text" name="nama_pemilik_rekening" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Bambang Kurniawan">
                </div>
            </div>

            <div class="flex gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('register.rental.step2') }}" class="w-1/3 bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center transition hover:bg-gray-50">
                    ← Kembali
                </a>
                <button type="submit" class="w-2/3 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                    Kirim Pendaftaran ✓
                </button>
            </div>
        </form>
    </div>
@endsection