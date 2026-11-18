@extends('layouts.guide')

@section('title', 'Profil')
@section('header', 'Profil Pemandu')
@section('subheader', 'Kelola informasi data diri akun pemandu Anda.')

@section('content')
    @php
        $statusLabel = match ($pemandu->status) {
            'active' => ['Terverifikasi', 'bg-green-100 text-green-700'],
            'pending' => ['Menunggu Verifikasi', 'bg-yellow-100 text-yellow-700'],
            'rejected' => ['Ditolak', 'bg-red-100 text-red-700'],
            default => ['Belum Diketahui', 'bg-gray-100 text-gray-600'],
        };
    @endphp

    <div class="max-w-4xl bg-white rounded-xl border border-gray-200 shadow-sm p-8">
        <div class="flex flex-wrap items-start justify-between gap-4 mb-1">
            <h2 class="text-xl font-bold text-gray-800">Data Diri Pemandu</h2>
            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $statusLabel[1] }}">{{ $statusLabel[0] }}</span>
        </div>
        <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Perbarui data profil personal Anda agar informasi kontak selalu mutakhir.</p>

        <div class="flex flex-wrap items-center gap-6 mb-8">
            @if ($user->fotoUrl())
                <img src="{{ $user->fotoUrl() }}" alt="Foto {{ $user->nama }}"
                    class="w-24 h-24 rounded-xl object-cover border border-gray-200">
            @else
                <div class="w-24 h-24 bg-[#1e4035] text-white rounded-xl flex items-center justify-center text-4xl font-bold relative">
                    {{ $pemandu->inisial() }}
                </div>
            @endif

            <div>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <form method="POST" action="{{ route('guide.profile.foto') }}" enctype="multipart/form-data" class="flex items-center gap-2">
                        @csrf
                        <label class="border border-gray-300 text-gray-700 font-bold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 flex items-center gap-2 cursor-pointer">
                            📷 {{ $user->foto ? 'Ganti Foto' : 'Unggah Foto' }}
                            <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="sr-only" onchange="this.form.submit()">
                        </label>
                    </form>

                    @if ($user->foto)
                        <form method="POST" action="{{ route('guide.profile.foto.hapus') }}" onsubmit="return confirm('Hapus foto profil?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 font-bold px-2 py-2 text-sm hover:underline flex items-center gap-1">🗑️ Hapus Foto</button>
                        </form>
                    @endif
                </div>
                <p class="text-xs text-gray-500">Format JPG, PNG atau WebP. Maksimal 2 MB.</p>
                <p class="text-xs text-gray-500 mt-1">Bergabung sejak {{ $pemandu->created_at?->translatedFormat('d F Y') ?? '-' }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('guide.profile.update') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="no_telepon" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 081234567890"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                <p class="text-xs text-gray-500 mt-1">Nomor ini dipakai calon pemesan untuk menghubungi Anda lewat WhatsApp.</p>
                @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Nomor Lisensi</p>
                    <p class="font-bold text-gray-800">{{ $pemandu->nomor_lisensi ?: 'Belum diisi' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tarif Harian</p>
                    <p class="font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::rupiah($pemandu->tarif_harian) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Jalur Dikuasai</p>
                    <p class="font-bold text-gray-800">{{ count($pemandu->ruteList()) }} jalur</p>
                </div>
            </div>

            <div class="bg-orange-50 border border-orange-100 p-4 rounded-lg flex gap-3">
                <span class="text-xl">ℹ️</span>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">Pemberitahuan Kelola Berkas & Rekening</h4>
                    <p class="text-xs text-gray-600 mt-1">Pengaturan lisensi resmi kepemanduan APGI/TNGR, sertifikat pendakian, serta rekening bank pencairan kini dikelola tersendiri melalui menu
                        <a href="{{ route('guide.settings') }}" class="font-bold text-gray-800 underline">Pengaturan</a>.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600 flex items-center gap-2">💾 Simpan Perubahan</button>
                <a href="{{ route('guide.dashboard') }}" class="text-gray-500 font-bold px-4 py-2.5 text-sm hover:text-gray-800">Batal</a>
            </div>
        </form>
    </div>
@endsection
