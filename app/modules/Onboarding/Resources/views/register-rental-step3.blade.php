@extends('Onboarding::layouts.partner')

@section('title', 'Legalitas & Rekening')
@section('portal-subtitle', 'Portal Kemitraan Toko Rental')
@section('portal-badge', 'Mitra Toko Rental')
@section('hero-title', 'Kembangkan Usaha Rental Anda.')
@section('hero-desc', 'Langkah terakhir sebelum verifikasi toko Anda.')

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Legalitas & Rekening</h1>
    <p class="text-sm text-gray-500 mb-8">Langkah terakhir sebelum verifikasi.</p>

    <x-stepper step="3" type="rental" />

    <div class="sheet reveal bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6" style="--d: 140ms">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span> Legalitas Usaha & Bank
        </h2>

        <!-- WAJIB MENGGUNAKAN ENCTYPE UNTUK FILE UPLOAD -->
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

            <!-- Kotak Upload Legalitas -->
            <div class="mb-6 relative">
                <input type="file" name="file_legalitas" id="file_legalitas" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 hover:border-orange-300 transition">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-gray-200 text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><path d="M7 10l5-5 5 5"></path><path d="M12 5v12"></path></svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-800 mb-1">Unggah Dokumen Legalitas</h4>
                    <p class="text-xs text-gray-500 mb-4">NIB/NPWP/Akta Pendirian (PDF/JPG/PNG, maks 5 MB).</p>
                    <span class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-sm text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 8 5-5 5 5"></path><path d="M5 21h14"></path></svg>
                        Pilih Berkas
                    </span>
                </div>
            </div>
            @error('file_legalitas') <span class="text-red-500 text-xs block mb-4">{{ $message }}</span> @enderror

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
                <a href="{{ route('register.rental.step2') }}" class="w-1/3 bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 12H5"></path><path d="m11 18-6-6 6-6"></path></svg>
                    Kembali
                </a>
                <button type="submit" class="cta w-2/3 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                    Kirim Pendaftaran
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m5 13 4 4L19 7"></path></svg>
                </button>
            </div>
        </form>
    </div>
@endsection