@extends('layouts.guide')

@section('title', 'Status Verifikasi')
@section('header', 'Status Verifikasi Akun')
@section('subheader', 'Area pemandu terbuka setelah admin menyetujui pendaftaran Anda.')

@section('content')
    @php
        $ditolak = $pemandu->status === 'rejected';
    @endphp

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="h-2 {{ $ditolak ? 'bg-red-500' : 'bg-orange-500' }}"></div>

            <div class="p-8 md:p-10 text-center">
                <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl mx-auto mb-5
                    {{ $ditolak ? 'bg-red-50' : 'bg-orange-50' }}">
                    {{ $ditolak ? '⛔' : '⏳' }}
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    {{ $ditolak ? 'Pendaftaran Ditolak' : 'Menunggu Verifikasi Admin' }}
                </h2>

                <p class="text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                    @if ($ditolak)
                        Pendaftaran kepemanduan Anda belum dapat disetujui. Periksa kembali kelengkapan lisensi,
                        sertifikat, dan data rekening Anda, lalu hubungi admin RinjaniGuide untuk peninjauan ulang.
                    @else
                        Terima kasih, {{ $pemandu->user->nama ?? 'Pemandu' }}. Data kepemanduan, sertifikat, dan rekening
                        Anda sedang ditinjau admin. Dashboard, jadwal, dan katalog akan aktif otomatis setelah disetujui.
                    @endif
                </p>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-3 text-left">
                    @foreach ([
                        ['Lisensi Kepemanduan', $pemandu->nomor_lisensi ?: 'Belum diisi'],
                        ['Jalur Dikuasai', count($pemandu->ruteList()).' jalur'],
                        ['Tarif Harian', \Modules\Guide\Support\Formatter::rupiah($pemandu->tarif_harian)],
                    ] as [$label, $nilai])
                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 mb-1">{{ $label }}</p>
                            <p class="text-sm font-bold text-gray-800">{{ $nilai }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($ditolak)
                    <div class="mt-6 bg-red-50 border border-red-200 text-red-700 text-left text-sm rounded-lg p-4">
                        <p class="font-bold mb-1">Langkah berikutnya</p>
                        <p class="text-xs leading-relaxed">
                            Unggah ulang dokumen melalui menu Pengaturan setelah akun disetujui ulang, atau hubungi
                            admin di <span class="font-semibold">admin@rinjaniguide.com</span>.
                        </p>
                    </div>
                @else
                    <div class="mt-6 bg-orange-50 border border-orange-200 text-orange-700 text-left text-sm rounded-lg p-4">
                        <p class="font-bold mb-1">Perkiraan proses</p>
                        <p class="text-xs leading-relaxed">
                            Verifikasi maksimal 1×24 jam kerja. Anda akan diarahkan ke dashboard secara otomatis
                            ketika status akun berubah menjadi aktif.
                        </p>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('home') }}"
                        class="bg-[#1e4035] text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:opacity-90 transition">
                        Kembali ke Beranda
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
