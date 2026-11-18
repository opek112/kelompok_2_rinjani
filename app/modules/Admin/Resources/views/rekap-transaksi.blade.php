@extends('admin::layouts.admin')

@section('title', 'Rekap Transaksi Global')
@section('header_title', 'Rekap Transaksi Global')
@section('header_desc', 'Pantau seluruh pendapatan, data demografi, dan strategi bisnis.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- 1. KARTU RINGKASAN -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-orange-200 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalTransaksi }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl">📄
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Omzet</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-gray-50 text-gray-500 rounded-lg flex items-center justify-center text-xl">📈</div>
            </div>
            <div class="bg-white rounded-xl border border-orange-200 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Komisi Platform</p>
                    <h3 class="text-2xl font-bold text-orange-500">Rp {{ number_format($totalKomisi, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl">💰
                </div>
            </div>
        </div>

        <!-- 2. TABEL TRANSAKSI -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-500">Total {{ $totalTransaksi }} transaksi.</p>
                </div>
                <a href="{{ route('admin.rekap-transaksi.export') }}"
                    class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Ekspor CSV
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                            <th class="px-6 py-4 font-semibold">Pemesan</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transaksis as $trx)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">{{ $trx->kode_pemesanan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $trx->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $trx->pelanggan ? $trx->pelanggan->nama : $trx->nama_ketua }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp
                                    {{ number_format($trx->total_tagihan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-semibold text-orange-500">Rp
                                    {{ number_format($trx->nominal_komisi, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold 
                {{ $trx->status === 'paid' ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-700' }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
