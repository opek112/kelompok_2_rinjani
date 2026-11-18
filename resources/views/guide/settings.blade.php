@extends('layouts.guide')

@section('title', 'Pengaturan')
@section('header', 'Pengaturan')
@section('subheader', 'Kelola keamanan akun, rekening pencairan, dokumen, dan data kepemanduan.')

@section('content')
    @php
        $tabs = [
            'keamanan' => ['label' => 'Keamanan Akun', 'icon' => '🔒'],
            'rekening' => ['label' => 'Rekening Pencairan', 'icon' => '🏦'],
            'dokumen' => ['label' => 'Sertifikat & Dokumen', 'icon' => '📄'],
            'kepemanduan' => ['label' => 'Data Kepemanduan', 'icon' => '🧭'],
        ];
    @endphp

    <div class="max-w-5xl">
        <!-- Tab Navigation -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-x-auto">
            <nav class="flex min-w-max">
                @foreach ($tabs as $key => $item)
                    <a href="{{ route('guide.settings', ['tab' => $key]) }}"
                        class="px-5 py-4 text-sm font-bold border-b-2 flex items-center gap-2 whitespace-nowrap transition
                        {{ $tab === $key ? 'border-orange-500 text-orange-600 bg-orange-50/50' : 'border-transparent text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                        <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- ================= KEAMANAN AKUN ================= --}}
        @if ($tab === 'keamanan')
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Keamanan Akun</h2>
                <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Perbarui email, nomor WhatsApp, dan kata sandi akun Anda.</p>

                <form method="POST" action="{{ route('guide.settings.keamanan') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="no_telepon" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                            @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-1">Ubah Kata Sandi</h3>
                        <p class="text-xs text-gray-500 mb-4">Kosongkan kolom kata sandi jika tidak ingin menggantinya.</p>

                        <div class="space-y-4">
                            <div>
                                <label for="password_lama" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                                <input type="password" id="password_lama" name="password_lama" autocomplete="current-password"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                                @error('password_lama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                                    <input type="password" id="password" name="password" autocomplete="new-password"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
                                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- ================= REKENING PENCAIRAN ================= --}}
        @if ($tab === 'rekening')
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Rekening Pencairan</h2>
                <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Rekening ini dipakai untuk mencairkan pendapatan bersih Anda setelah komisi platform.</p>

                @if ($pemandu->nama_bank && $pemandu->nomor_rekening)
                    <div class="bg-[#1e4035] text-white rounded-xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-300 mb-1">Rekening Terdaftar</p>
                            <p class="text-xl font-bold">{{ $pemandu->nama_bank }}</p>
                            <p class="text-lg tracking-widest mt-1">{{ $pemandu->nomor_rekening }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-300 mb-1">Atas Nama</p>
                            <p class="font-bold">{{ $pemandu->nama_pemilik_rekening }}</p>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm px-4 py-3 rounded-lg mb-8">
                        ⚠️ Rekening pencairan belum diisi. Lengkapi agar pendapatan dapat dicairkan.
                    </div>
                @endif

                <form method="POST" action="{{ route('guide.settings.rekening') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_bank" class="block text-sm font-bold text-gray-700 mb-2">Nama Bank</label>
                        @php
                            $bankUmum = ['BCA', 'BRI', 'BNI', 'Mandiri', 'BSI', 'BTN', 'CIMB Niaga', 'Permata', 'Bank NTB Syariah'];
                            $bankTerpilih = old('nama_bank', $pemandu->nama_bank);
                        @endphp
                        <select id="nama_bank" name="nama_bank" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                            <option value="">-- Pilih Bank --</option>
                            @foreach ($bankUmum as $bank)
                                <option value="{{ $bank }}" {{ $bankTerpilih === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                            @if ($bankTerpilih && ! in_array($bankTerpilih, $bankUmum, true))
                                <option value="{{ $bankTerpilih }}" selected>{{ $bankTerpilih }}</option>
                            @endif
                        </select>
                        @error('nama_bank') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nomor_rekening" class="block text-sm font-bold text-gray-700 mb-2">Nomor Rekening</label>
                            <input type="text" id="nomor_rekening" name="nomor_rekening" inputmode="numeric"
                                value="{{ old('nomor_rekening', $pemandu->nomor_rekening) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                            @error('nomor_rekening') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nama_pemilik_rekening" class="block text-sm font-bold text-gray-700 mb-2">Nama Pemilik Rekening</label>
                            <input type="text" id="nama_pemilik_rekening" name="nama_pemilik_rekening"
                                value="{{ old('nama_pemilik_rekening', $pemandu->nama_pemilik_rekening) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                            @error('nama_pemilik_rekening') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="bg-orange-50 border border-orange-100 p-4 rounded-lg flex gap-3">
                        <span class="text-xl">ℹ️</span>
                        <p class="text-xs text-gray-600">Pastikan nama pemilik rekening sama dengan nama pada KTP agar proses pencairan tidak tertunda.</p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600">💾 Simpan Rekening</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- ================= SERTIFIKAT & DOKUMEN ================= --}}
        @if ($tab === 'dokumen')
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Sertifikat & Dokumen</h2>
                <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Unggah berkas legalitas kepemanduan Anda. Berkas diverifikasi ulang oleh admin bila diubah.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach ($dokumen as $item)
                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-lg">📄</div>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $item['path'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $item['path'] ? 'TERSEDIA' : 'BELUM ADA' }}
                                </span>
                            </div>

                            <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $item['label'] }}</h3>
                            <p class="text-xs text-gray-500 mb-4">Format {{ str_replace(',', ', ', strtoupper($item['mimes'])) }}, maksimal {{ $item['maks'] }} MB.</p>

                            @if ($item['path'])
                                <a href="{{ asset('storage/'.$item['path']) }}" target="_blank" rel="noopener"
                                    class="text-xs font-bold text-[#1e4035] underline mb-3">Lihat berkas saat ini</a>
                            @endif

                            <form method="POST" action="{{ route('guide.settings.dokumen.upload', $item['jenis']) }}" enctype="multipart/form-data" class="mt-auto space-y-3">
                                @csrf
                                <input type="file" name="berkas" required accept=".{{ str_replace(',', ',.', $item['mimes']) }}"
                                    class="block w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#1e4035] file:text-white hover:file:bg-[#2c5548]">
                                <button type="submit" class="w-full bg-orange-500 text-white font-bold px-4 py-2 rounded-lg text-xs hover:bg-orange-600">
                                    {{ $item['path'] ? 'Ganti Berkas' : 'Unggah Berkas' }}
                                </button>
                            </form>

                            @if ($item['path'])
                                <form method="POST" action="{{ route('guide.settings.dokumen.hapus', $item['jenis']) }}" class="mt-2"
                                    onsubmit="return confirm('Hapus {{ $item['label'] }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-red-500 font-bold px-4 py-1.5 rounded-lg text-xs hover:underline">Hapus Berkas</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ================= DATA KEPEMANDUAN ================= --}}
        @if ($tab === 'kepemanduan')
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Data Kepemanduan</h2>
                <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Data ini tampil di katalog publik dan dipakai saat pencocokan penugasan.</p>

                <form method="POST" action="{{ route('guide.settings.kepemanduan') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nomor_lisensi" class="block text-sm font-bold text-gray-700 mb-2">Nomor Lisensi Kepemanduan</label>
                        <input type="text" id="nomor_lisensi" name="nomor_lisensi" value="{{ old('nomor_lisensi', $pemandu->nomor_lisensi) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5" placeholder="Contoh: APGI-2024-0187">
                        @error('nomor_lisensi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jalur Keahlian (bisa lebih dari satu)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($ruteTersedia as $rute)
                                @php $ruteDipilih = in_array($rute, old('rute', $pemandu->ruteList()), true); @endphp
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="rute[]" value="{{ $rute }}" class="peer sr-only" {{ $ruteDipilih ? 'checked' : '' }}>
                                    <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-center text-gray-600 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500 transition">{{ $rute }}</div>
                                </label>
                            @endforeach
                        </div>
                        @error('rute') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Bahasa yang Dikuasai</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($bahasaTersedia as $bahasa)
                                @php $bahasaDipilih = in_array($bahasa, old('bahasa', $pemandu->bahasaList()), true); @endphp
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="bahasa[]" value="{{ $bahasa }}" class="peer sr-only" {{ $bahasaDipilih ? 'checked' : '' }}>
                                    <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500 transition">{{ $bahasa }}</div>
                                </label>
                            @endforeach
                        </div>
                        @error('bahasa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tarif_harian" class="block text-sm font-bold text-gray-700 mb-2">Tarif Harian (Rp)</label>
                        <input type="number" id="tarif_harian" name="tarif_harian" min="0" step="1000" value="{{ old('tarif_harian', (int) $pemandu->tarif_harian) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5">
                        <p class="text-xs text-gray-500 mt-1">Saat ini: {{ \Modules\Guide\Support\Formatter::rupiah($pemandu->tarif_harian) }} per hari.</p>
                        @error('tarif_harian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-bold text-gray-700 mb-2">Bio Singkat</label>
                        <textarea id="bio" name="bio" rows="4" maxlength="300" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm py-2.5"
                            placeholder="Ceritakan pengalaman kepemanduan Anda, spesialisasi jalur, dan keunggulan Anda...">{{ old('bio', $pemandu->bio) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 300 karakter.</p>
                        @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600">💾 Simpan Data Kepemanduan</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
