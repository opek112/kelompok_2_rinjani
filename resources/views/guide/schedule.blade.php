@extends('layouts.guide')

@section('title', 'Jadwal Penugasan')
@section('header', 'Jadwal Penugasan')
@section('subheader', 'Kelola penugasan ekspedisi aktif dan riwayat pemanduan pendaki')

@section('content')
    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-gray-200 p-2 mb-6 flex gap-4">
        @foreach ([
            'akan_datang' => 'Akan Datang',
            'berjalan' => 'Sedang Berjalan',
            'selesai' => 'Selesai',
        ] as $kunci => $label)
            <a href="{{ route('guide.schedule', ['tab' => $kunci]) }}"
                class="px-6 py-3 flex items-center gap-2 {{ $tab === $kunci ? 'border-b-2 border-orange-500 text-orange-500 font-bold' : 'text-gray-500 font-semibold hover:text-gray-800' }}">
                {{ $label }}
                <span class="text-xs px-2 py-0.5 rounded-full {{ $tab === $kunci ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500' }}">{{ $jumlah[$kunci] }}</span>
            </a>
        @endforeach
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold mb-4">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-semibold mb-4">⚠️ {{ session('error') }}</div>
    @endif

    @forelse ($daftar as $pesanan)
        @php
            $telepon = preg_replace('/[^0-9]/', '', (string) $pesanan->telepon_ketua);
            if (str_starts_with($telepon, '0')) {
                $telepon = '62'.substr($telepon, 1);
            }

            $bisaKonfirmasi = $pesanan->status === 'paid'
                && ! $pesanan->kehadiran_pemandu_dikonfirmasi
                && $pesanan->tanggal_selesai->gte(today());

            $labelStatus = match ($pesanan->status) {
                'pending' => 'Menunggu Pembayaran',
                'paid' => $pesanan->kehadiran_pemandu_dikonfirmasi ? 'Sedang Berjalan' : 'Menunggu Pertemuan',
                'completed' => 'Selesai',
                default => ucfirst($pesanan->status),
            };

            $warnaStatus = match ($pesanan->status) {
                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'paid' => $pesanan->kehadiran_pemandu_dikonfirmasi ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-600 border-orange-200',
                default => 'bg-gray-100 text-gray-600 border-gray-200',
            };
        @endphp

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-4">
            <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
                <div class="flex gap-4 text-xs text-gray-500 font-medium">
                    <span># {{ $pesanan->kode_pemesanan }}</span>
                    <span>•</span>
                    <span>Dipesan: {{ \Modules\Guide\Support\Formatter::tanggal($pesanan->created_at) }}</span>
                </div>
                <span class="border text-xs font-bold px-3 py-1 rounded-full {{ $warnaStatus }}">⏱️ {{ $labelStatus }}</span>
            </div>

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#1e4035] text-white rounded-full flex items-center justify-center font-bold text-lg">
                        {{ mb_strtoupper(mb_substr($pesanan->nama_ketua, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $pesanan->nama_ketua }}</h3>
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded">Ketua Rombongan</span>
                        </div>
                        <p class="text-xs text-gray-500 flex flex-wrap items-center gap-3">
                            <span class="flex items-center gap-1">📞 {{ $pesanan->telepon_ketua }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1">✉️ {{ $pesanan->email_ketua }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full lg:w-64">
                    <a href="https://wa.me/{{ $telepon }}" target="_blank" rel="noopener"
                        class="w-full border border-green-600 text-green-700 bg-white py-2 rounded-lg text-sm font-bold hover:bg-green-50 flex items-center justify-center gap-2">
                        📞 Hubungi via WhatsApp
                    </a>
                    <a href="{{ route('guide.assignment.show', $pesanan) }}"
                        class="w-full {{ $bisaKonfirmasi ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} py-2 rounded-lg text-sm font-bold flex items-center justify-center gap-2">
                        {{ $pesanan->kehadiran_pemandu_dikonfirmasi ? '👁️ Lihat Detail' : ($bisaKonfirmasi ? '✔️ Konfirmasi Serah Terima' : '👁️ Lihat Detail') }}
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-500 mb-1">Tanggal Pendakian:</p>
                    <p class="text-sm font-bold text-gray-800 flex items-center gap-2">📅 {{ \Modules\Guide\Support\Formatter::rentang($pesanan->tanggal_mulai, $pesanan->tanggal_selesai) }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-500 mb-1">Jalur Pendakian:</p>
                    <p class="text-sm font-bold text-gray-800 flex items-center gap-1">⛰️ {{ $pesanan->rute ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <p class="text-[10px] text-gray-500 mb-1">Total Durasi:</p>
                    <p class="text-sm font-bold text-gray-800 flex items-center gap-2">⏱️ {{ \Modules\Guide\Support\Formatter::durasi((int) $pesanan->total_hari) }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
            <div class="text-4xl mb-3">🗓️</div>
            <p class="font-bold text-gray-800">Belum ada penugasan</p>
            <p class="text-sm text-gray-500">Penugasan yang dibayar dan ditugaskan kepada Anda akan tampil di sini.</p>
        </div>
    @endforelse

    <!-- Legend Status -->
    <div class="flex flex-wrap gap-6 text-xs text-gray-600 bg-white p-4 rounded-xl border border-gray-200 shadow-sm mt-6">
        <span class="font-bold text-gray-800">Panduan Status Penugasan:</span>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Kuning = Menunggu Pembayaran</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Oranye = Menunggu Pertemuan</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Hijau = Sedang Berjalan</div>
        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Abu = Selesai</div>
    </div>
@endsection
