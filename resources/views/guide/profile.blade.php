@extends('layouts.guide')

@section('title', 'Profil')
@section('header', 'Profil Pemandu')
@section('subheader', 'Kelola informasi data diri akun pemandu Anda.')

@section('content')
    <div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-sm p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-1">Data Diri Pemandu</h2>
        <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Perbarui data profil personal Anda agar informasi kontak selalu mutakhir.</p>

        <div class="flex items-center gap-6 mb-8">
            <div class="w-24 h-24 bg-[#1e4035] text-white rounded-xl flex items-center justify-center text-4xl font-bold relative">
                AR
                <div class="absolute -bottom-2 -right-2 bg-green-500 p-1.5 rounded-full border-2 border-white text-[10px] flex items-center justify-center w-6 h-6">✔️</div>
            </div>
            <div>
                <div class="flex gap-3 mb-2">
                    <button class="border border-gray-300 text-gray-700 font-bold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 flex items-center gap-2">📷 Ganti Foto</button>
                    <button class="text-red-500 font-bold px-2 py-2 text-sm hover:underline flex items-center gap-1">🗑️ Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500">Format JPG, PNG atau WebP. Maksimal 2 MB.</p>
            </div>
        </div>

        <form class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" value="Ahmad Rifai" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" value="ahmad.rifai@email.com" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                <input type="text" value="0819-3456-7890" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
            </div>

            <!-- Info Box -->
            <div class="bg-orange-50 border border-orange-100 p-4 rounded-lg flex gap-3">
                <span class="text-xl">ℹ️</span>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">Pemberitahuan Kelola Berkas & Rekening</h4>
                    <p class="text-xs text-gray-600 mt-1">Pengaturan lisensi resmi kepemanduan APGI/TNGR, sertifikat pendakian, serta rekening bank pencairan kini dikelola tersendiri melalui menu <strong class="text-gray-800">Pengaturan</strong>.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="button" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600 flex items-center gap-2">💾 Simpan Perubahan</button>
                <button type="button" class="text-gray-500 font-bold px-4 py-2.5 text-sm hover:text-gray-800">Batal</button>
            </div>
        </form>
    </div>
@endsection