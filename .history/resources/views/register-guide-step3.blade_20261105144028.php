@extends('layouts.partner')

@section('title', 'Sertifikat & Bank')
@section('portal-subtitle', 'Portal Kemitraan Pemandu')
@section('portal-badge', 'Mitra Pemandu')
@section('hero-title', 'Jadilah Pemandu Resmi RinjaniGuide.')
@section('hero-desc', 'Langkah terakhir sebelum akun Anda diverifikasi.')

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Sertifikat & Rekening</h1>
    <p class="text-sm text-gray-500 mb-8">Langkah terakhir sebelum verifikasi.</p>

    <!-- STEPPER: Ubah step menjadi 3 -->
    <x-stepper step="3" type="guide" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span> Dokumen & Rekening
        </h2>

        <!-- Wajib pakai enctype jika ada file upload -->
        <form action="{{ route('register.guide.step3.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Rekening Pencairan</label>
                <input type="text" name="nama_bank" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg mb-3" placeholder="Nama Bank (Contoh: BCA)">
                <input type="text" name="nomor_rekening" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg mb-3" placeholder="Nomor Rekening">
                <input type="text" name="nama_pemilik_rekening" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg" placeholder="Nama Pemilik Rekening">
            </div>

            <div class="flex gap-4">
                <a href="{{ route('register.guide.step2') }}" class="w-1/3 bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center transition hover:bg-gray-50">
                    ← Kembali
                </a>
                <button type="submit" class="w-2/3 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                    Kirim Pendaftaran ✓
                </button>
            </div>
        </form>
    </div>
@endsection