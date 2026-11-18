@extends('layouts.guide')

@section('title', 'Pendapatan')
@section('header', 'Pendapatan')
@section('subheader', 'Pusat Keuangan')

@section('content')
    <!-- 3 Kartu Finansial -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-semibold text-gray-600">Pendapatan Kotor</p>
                <span class="bg-orange-50 text-orange-500 p-2 rounded-lg">💵</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ \Modules\Guide\Support\Formatter::rupiah($ringkasan['kotor']) }}</h3>
            <p class="text-xs text-gray-500 flex items-center gap-1">📅 {{ \Modules\Guide\Support\Formatter::bulan($bulan) }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-semibold text-gray-600">Komisi Platform</p>
                <span class="bg-gray-100 text-gray-600 p-2 rounded-lg">%</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ \Modules\Guide\Support\Formatter::rupiah($ringkasan['komisi']) }}</h3>
            <p class="text-xs text-gray-500 flex items-center gap-1">ℹ️ {{ $ringkasan['jumlah'] }} ekspedisi bulan ini</p>
        </div>

        <div class="bg-orange-50 p-6 rounded-xl border-2 border-orange-500 shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <p class="text-sm font-bold text-orange-600">Pendapatan Bersih</p>
                <span class="bg-orange-500 text-white p-2 rounded-lg">🛍️</span>
            </div>
            <h3 class="text-3xl font-bold text-orange-600 mb-2">{{ \Modules\Guide\Support\Formatter::rupiah($ringkasan['bersih']) }}</h3>
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-gray-600 font-medium">Setelah komisi platform</p>
                <span class="text-[10px] bg-green-200 text-green-800 px-2 py-1 rounded-full font-bold">Terverifikasi</span>
            </div>
        </div>
    </div>

    <!-- Filter & Unduh -->
    <form method="GET" action="{{ route('guide.earnings') }}" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
        <div class="flex items-center gap-3 text-sm">
            <label for="bulan" class="font-bold text-gray-700">Periode:</label>
            <input type="month" id="bulan" name="bulan" value="{{ $bulan->format('Y-m') }}"
                class="border-gray-300 rounded-lg py-1.5 focus:ring-orange-500 focus:border-orange-500">
            <button type="submit" class="ml-2 font-bold text-gray-800 hover:text-orange-500">Terapkan</button>
        </div>
        <a href="{{ route('guide.earnings.export', ['bulan' => $bulan->format('Y-m')]) }}"
            class="bg-orange-500 text-white font-bold px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-orange-600">
            ⬇️ Unduh Laporan
        </a>
    </form>

    <!-- Grafik 6 Bulan Terakhir -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Pendapatan 6 Bulan Terakhir</h3>
                <p class="text-xs text-gray-500">Total pendapatan bersih per bulan.</p>
            </div>
            <div class="flex gap-4 text-xs">
                <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Bulan Ini</div>
                <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#1e4035]"></span> Bulan Sebelumnya</div>
            </div>
        </div>

        <div class="h-64 flex items-end justify-between gap-4 px-4 relative border-b border-gray-200 pb-2">
            @foreach ($bulanan as $baris)
                @php
                    $tinggi = max(4, (int) round(($baris['total'] / $maksimal) * 180));
                    $bulanIni = $baris['bulan']->isSameMonth(now());
                @endphp
                <div class="flex flex-col items-center gap-2 z-10 flex-1 min-w-0">
                    <span class="text-[10px] font-bold {{ $bulanIni ? 'text-orange-600 bg-orange-50 px-1 rounded' : 'text-gray-600' }}">
                        {{ \Modules\Guide\Support\Formatter::rupiah($baris['total']) }}
                    </span>
                    <div class="w-full max-w-16 rounded-t-md {{ $bulanIni ? 'bg-orange-500' : 'bg-[#1e4035]' }}" style="height: {{ $tinggi }}px;"></div>
                    <span class="text-xs {{ $bulanIni ? 'font-bold text-orange-600' : 'font-semibold text-gray-500' }}">{{ $baris['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Pendampingan -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
        <div class="p-6 flex justify-between items-center border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Riwayat Pendampingan</h3>
                <p class="text-xs text-gray-500">Rincian pendapatan bersih dari ekspedisi terverifikasi.</p>
            </div>
            <span class="bg-orange-50 text-orange-600 text-xs font-bold px-3 py-1 rounded-full border border-orange-200">
                • {{ $ringkasan['jumlah'] }} Ekspedisi Bulan Ini
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Kode Pesanan</th>
                        <th class="px-6 py-4">Pemesan</th>
                        <th class="px-6 py-4">Jalur</th>
                        <th class="px-6 py-4">Pendapatan Kotor</th>
                        <th class="px-6 py-4">Komisi</th>
                        <th class="px-6 py-4">Pendapatan Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($riwayat as $baris)
                        @php
                            $pesanan = $baris['pemesanan'];
                            $rincian = $baris['rincian'];
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ \Modules\Guide\Support\Formatter::rentang($pesanan->tanggal_mulai, $pesanan->tanggal_selesai) }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $pesanan->kode_pemesanan }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $pesanan->nama_ketua }}</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">{{ $pesanan->rute ?? '-' }}</span></td>
                            <td class="px-6 py-4 text-gray-600">{{ \Modules\Guide\Support\Formatter::rupiah($rincian['kotor']) }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ \Modules\Guide\Support\Formatter::rupiah($rincian['komisi']) }}</td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ \Modules\Guide\Support\Formatter::rupiah($rincian['bersih']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">Belum ada pendapatan pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($riwayat->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>

    @if ($ringkasan['jumlah'] === 0)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl mb-4">🧾</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pendapatan</h3>
            <p class="text-sm text-gray-500 max-w-sm mb-6">Riwayat pendampingan Anda akan muncul di sini setelah menyelesaikan tugas pertama.</p>
            <a href="{{ route('guide.dashboard') }}" class="bg-orange-500 text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-orange-600 flex items-center gap-2">📅 Atur Ketersediaan</a>
        </div>
    @endif
@endsection
