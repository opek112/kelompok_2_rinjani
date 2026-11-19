@extends('admin::layouts.admin')

@section('title', 'Log Aktivitas Pembayaran')
@section('header_title', 'Log Aktivitas Pembayaran')
@section('header_desc', 'Catatan webhook pembayaran yang tersimpan di database.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center shrink-0 text-xl">📄</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalLogHariIni }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Log Webhook Hari Ini</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-lg flex items-center justify-center shrink-0 text-xl">✅</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $webhookValidHariIni }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Signature Valid Hari Ini</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-lg flex items-center justify-center shrink-0 text-xl">⚠️</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pembayaranGagalHariIni }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Pembayaran Gagal/Kedaluwarsa Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Log Webhook Pembayaran</h3>
                <p class="text-sm text-gray-500">Hanya webhook yang tercatat oleh sistem ditampilkan di sini.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Waktu</th>
                            <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                            <th class="px-6 py-4 font-semibold">Status Pembayaran</th>
                            <th class="px-6 py-4 font-semibold">Validasi Signature</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($logPembayaran as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-gray-900">
                                    {{ $log->pembayaran?->pemesanan?->kode_pemesanan ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ ucfirst($log->pembayaran?->status_pembayaran ?? 'tidak tersedia') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold border
                                        {{ $log->tanda_tangan_valid ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                        {{ $log->tanda_tangan_valid ? 'Valid' : 'Tidak valid' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada log webhook pembayaran di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $logPembayaran->links() }}
            </div>
        </div>
    </div>
@endsection
