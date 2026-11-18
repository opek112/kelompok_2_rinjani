@extends('layouts.guide')

@section('title', 'Dashboard')
@section('header', 'Dashboard Kalender')
@section('subheader', 'Kelola ketersediaan hari ekspedisi dan konfirmasi pesanan pendaki.')

@section('content')
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-semibold mb-6">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">📅</span>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">{{ \Modules\Guide\Support\Formatter::bulan($bulan) }}</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $penugasanBulanIni }}</h3>
            <p class="text-xs text-gray-500 mt-1">Penugasan Bulan Ini</p>
        </div>
        <div class="bg-white p-5 rounded-xl border-2 border-orange-400 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">⏱️</span>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded">Perlu Tindakan</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $perluKonfirmasi }}</h3>
            <p class="text-xs text-gray-500 mt-1">Menunggu Konfirmasi</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">⛰️</span>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Hari Ini</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $hariTersedia }} <span class="text-sm text-gray-400 font-normal">tersedia</span></h3>
            <p class="text-xs text-gray-500 mt-1">{{ $hariTerisi }} tanggal sudah dipesan</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-2xl">💵</span>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Bersih</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::rupiah($pendapatanBulanIni) }}</h3>
            <p class="text-xs text-gray-500 mt-1">Pendapatan Bulan Ini</p>
        </div>
    </div>

    <!-- Kalender -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Kalender Ketersediaan</h2>
                <p class="text-xs text-gray-500">Klik tanggal untuk mengubah status ketersediaan. Tanggal dipesan hanya dapat dilihat.</p>
            </div>
            <div class="flex items-center gap-4 border border-gray-300 rounded-lg px-4 py-2">
                <a href="{{ route('guide.dashboard', ['bulan' => $bulan->copy()->subMonth()->format('Y-m')]) }}" class="cursor-pointer text-gray-500 hover:text-orange-500">&lt;</a>
                <span class="font-bold text-sm w-28 text-center">{{ \Modules\Guide\Support\Formatter::bulan($bulan) }}</span>
                <a href="{{ route('guide.dashboard', ['bulan' => $bulan->copy()->addMonth()->format('Y-m')]) }}" class="cursor-pointer text-gray-500 hover:text-orange-500">&gt;</a>
            </div>
        </div>

        <!-- Grid Kalender -->
        <div class="grid grid-cols-7 gap-2 mb-2 text-center text-xs font-bold text-gray-500">
            <div>SENIN</div><div>SELASA</div><div>RABU</div><div>KAMIS</div><div>JUMAT</div><div class="text-orange-500">SABTU</div><div class="text-red-500">MINGGU</div>
        </div>
        <div class="grid grid-cols-7 gap-2">
            @foreach ($cells as $cell)
                @if ($cell === null)
                    <div class="h-24 bg-gray-50 rounded-lg border border-gray-100 opacity-50"></div>
                @elseif ($cell['status'] === 'booked')
                    <div class="h-24 border border-red-200 rounded-lg p-2 flex flex-col justify-between bg-red-50">
                        <span class="text-sm font-bold text-gray-700">{{ $cell['tanggal']->day }}</span>
                        <span class="text-[10px] text-center bg-red-200 text-red-800 rounded py-1 font-semibold">Dipesan</span>
                    </div>
                @elseif ($cell['status'] === 'off')
                    <form method="POST" action="{{ route('guide.ketersediaan.toggle', $cell['iso']) }}" class="contents">
                        @csrf
                        <button type="submit" title="Klik untuk menandai tersedia"
                            class="h-24 border border-gray-200 rounded-lg p-2 flex flex-col justify-between bg-gray-50 hover:border-orange-400 transition text-left {{ $cell['tanggal']->isToday() ? 'ring-2 ring-orange-500' : '' }}">
                            <span class="text-sm font-bold text-gray-700">{{ $cell['tanggal']->day }}</span>
                            <span class="text-[10px] text-center bg-gray-200 text-gray-600 rounded py-1">Libur</span>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('guide.ketersediaan.toggle', $cell['iso']) }}" class="contents">
                        @csrf
                        <button type="submit" title="Klik untuk menandai libur"
                            class="h-24 border border-green-200 rounded-lg p-2 flex flex-col justify-between bg-green-50 hover:border-orange-400 transition text-left {{ $cell['tanggal']->isToday() ? 'ring-2 ring-orange-500' : '' }}">
                            <span class="text-sm font-bold text-gray-700">{{ $cell['tanggal']->day }}@if ($cell['tanggal']->isToday()) <span class="text-[10px] font-bold text-orange-600">Hari Ini</span>@endif</span>
                            <span class="text-[10px] text-center bg-green-200 text-green-800 rounded py-1 font-semibold">Tersedia</span>
                        </button>
                    </form>
                @endif
            @endforeach
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center gap-6 mt-6 text-xs text-gray-600">
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Tersedia</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Dipesan</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Libur (Off-Duty)</div>
            <div class="ml-auto flex items-center gap-2"><span class="w-3 h-3 border-2 border-orange-500 rounded bg-orange-50"></span> Kotak oranye: Tanggal hari ini</div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h4 class="text-xs font-bold text-gray-500 mb-4 tracking-widest uppercase">Aksi Cepat {{ \Modules\Guide\Support\Formatter::bulan($bulan) }}</h4>
        <div class="flex flex-wrap gap-4 text-sm font-semibold">
            <form method="POST" action="{{ route('guide.ketersediaan.bulk') }}">
                @csrf
                <input type="hidden" name="status" value="available">
                <input type="hidden" name="bulan" value="{{ $bulan->format('Y-m') }}">
                <button type="submit" class="px-4 py-2 border-2 border-gray-800 rounded-lg text-gray-800 hover:bg-gray-100 flex items-center gap-2">✔️ Tandai Semua Tersedia Bulan Ini</button>
            </form>
            <form method="POST" action="{{ route('guide.ketersediaan.bulk') }}">
                @csrf
                <input type="hidden" name="status" value="off">
                <input type="hidden" name="bulan" value="{{ $bulan->format('Y-m') }}">
                <button type="submit" class="px-4 py-2 text-gray-600 hover:text-gray-900">Tandai Semua Libur</button>
            </form>
        </div>
    </div>
@endsection
