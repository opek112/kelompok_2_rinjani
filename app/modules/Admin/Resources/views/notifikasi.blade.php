@extends('admin::layouts.admin')

@section('title', 'Notifikasi Admin')
@section('header_title', 'Notifikasi')
@section('header_desc', 'Informasi operasional berdasarkan data transaksi dan pendaftaran mitra.')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h3 class="font-bold text-gray-900">Aktivitas Operasional</h3>
                <p class="text-sm text-gray-500">Menampilkan {{ $notifikasi->count() }} aktivitas terbaru yang tersedia.</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($notifikasi as $item)
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                            {{ $item['jenis'] === 'Pembayaran' ? '!' : ($item['jenis'] === 'Transaksi' ? 'Rp' : 'M') }}
                        </div>
                        <div class="flex-1">
                            <div class="mb-1 flex flex-wrap items-center justify-between gap-2">
                                <h3 class="font-bold text-gray-900 text-sm">{{ $item['judul'] }}</h3>
                                <span class="text-xs text-gray-400">{{ $item['jenis'] }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $item['deskripsi'] }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $item['waktu']->diffForHumans() }} ·
                                <a href="{{ $item['tautan'] }}" class="text-orange-500 hover:underline">Buka data →</a>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="border border-dashed border-gray-300 rounded-xl p-10 text-center">
                    <div class="text-3xl mb-3">🔔</div>
                    <h3 class="font-bold text-gray-800 mb-1">Belum ada aktivitas operasional</h3>
                    <p class="text-sm text-gray-500">Aktivitas akan muncul saat ada pendaftaran, transaksi, atau pembayaran baru.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
