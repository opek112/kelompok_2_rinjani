@extends('layouts.partner')

@section('title', 'Data Toko Rental')
@section('portal-subtitle', 'Portal Kemitraan Toko Rental')
@section('portal-badge', 'Mitra Toko Rental')
@section('hero-title', 'Kembangkan Usaha Rental Anda.')
@section('hero-desc', 'Lengkapi informasi toko rental Anda untuk mulai menerima pesanan.')

@section('content')
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Data Toko</h1>
    <p class="text-sm text-gray-500 mb-8">Lengkapi informasi toko rental Anda.</p>

    <!-- STEPPER: Ubah step menjadi 2 -->
    <x-stepper step="2" type="rental" />

    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
            <span class="bg-orange-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span> Informasi Toko Rental
        </h2>

        <form action="{{ route('register.rental.step2.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Toko</label>
                <input type="text" name="nama_toko" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Contoh: Rinjani Outdoor">
                <p class="text-[11px] text-gray-500 mt-1">Nama ini akan tampil di katalog publik.</p>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Lokasi Pos Operasional</label>
                <select name="lokasi_pos" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 text-gray-700">
                    <option value="" disabled selected>Pilih pos...</option>
                    <option value="Sembalun">Pos Sembalun</option>
                    <option value="Senaru">Pos Senaru</option>
                    <option value="Torean">Pos Torean</option>
                </select>
                <p class="text-[11px] text-gray-500 mt-1">Pilih pos terdekat dengan lokasi toko.</p>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Alamat Lengkap</label>
                <textarea name="alamat" required rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Jl. Raya Sembalun No. 12, Lombok Timur, NTB"></textarea>
            </div>

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Deskripsi Toko</label>
                <textarea name="deskripsi" required rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Toko rental alat outdoor terpercaya di pos Sembalun. Menyediakan tenda, sleeping bag, matras..."></textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('register.rental') }}" class="w-1/3 bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center transition hover:bg-gray-50">
                    ← Kembali
                </a>
                <button type="submit" class="w-2/3 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                    Lanjut ke Legalitas →
                </button>
            </div>
        </form>
    </div>
@endsection