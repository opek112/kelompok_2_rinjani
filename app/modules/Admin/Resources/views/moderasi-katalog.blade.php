@extends('admin::layouts.admin')

@section('title', 'Moderasi Katalog')
@section('header_title', 'Moderasi Katalog')
@section('header_desc', 'Data pemandu dan inventaris alat yang tersimpan di platform.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.moderasi-katalog', ['jenis' => 'pemandu']) }}"
                class="bg-white rounded-xl border {{ $jenis === 'pemandu' ? 'border-orange-500' : 'border-gray-200' }} shadow-sm p-4 flex items-center justify-between relative overflow-hidden">
                @if ($jenis === 'pemandu')
                    <span class="absolute left-0 top-0 bottom-0 w-1.5 bg-orange-500"></span>
                @endif
                <span class="font-bold text-gray-900 pl-2">Pemandu</span>
                <span class="bg-orange-100 text-orange-600 font-bold px-2 py-0.5 rounded text-sm">{{ $totalPemandu }}</span>
            </a>
            <a href="{{ route('admin.moderasi-katalog', ['jenis' => 'alat']) }}"
                class="bg-white rounded-xl border {{ $jenis === 'alat' ? 'border-orange-500' : 'border-gray-200' }} shadow-sm p-4 flex items-center justify-between relative overflow-hidden">
                @if ($jenis === 'alat')
                    <span class="absolute left-0 top-0 bottom-0 w-1.5 bg-orange-500"></span>
                @endif
                <span class="font-bold text-gray-900 pl-2">Alat Sewa</span>
                <span class="bg-gray-100 text-gray-600 font-bold px-2 py-0.5 rounded text-sm">{{ $totalPeralatan }}</span>
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    @if ($jenis === 'pemandu')
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nama Pemandu</th>
                                <th class="px-6 py-4 font-semibold">Tarif/Hari</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pemandu as $guide)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ $guide->user?->nama ?? 'Tidak ada nama' }}</p>
                                        <p class="text-xs text-gray-500">{{ $guide->user?->email ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        Rp {{ number_format($guide->tarif_harian, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">{{ ucfirst($guide->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada data pemandu.</td></tr>
                            @endforelse
                        </tbody>
                    @else
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nama Alat</th>
                                <th class="px-6 py-4 font-semibold">Toko Rental</th>
                                <th class="px-6 py-4 font-semibold">Tarif/Hari</th>
                                <th class="px-6 py-4 font-semibold">Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($peralatan as $alat)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $alat->nama }}</td>
                                    <td class="px-6 py-4">{{ $alat->toko?->nama_toko ?? '-' }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        Rp {{ number_format($alat->tarif_harian, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $alat->jumlah_stok }} unit</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada inventaris alat.</td></tr>
                            @endforelse
                        </tbody>
                    @endif
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                @if ($jenis === 'pemandu')
                    {{ $pemandu->links() }}
                @else
                    {{ $peralatan->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
