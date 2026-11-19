@extends('admin::layouts.admin')

@section('title', 'Integrasi')
@section('header_title', 'Pengaturan')
@section('header_desc', 'Kelola konfigurasi sistem, parameter operasional, dan preferensi platform.')

@section('content')
    <!-- SUB-NAVIGASI TAB -->
    <div class="bg-white border-b border-gray-200 -mx-8 -mt-8 px-8 flex gap-6 shrink-0 mb-6 shadow-sm">
        <a href="{{ route('admin.pengaturan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">⚙️
            Preferensi Sistem</a>
        <a href="{{ route('admin.keamanan') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🛡️
            Keamanan Akun</a>
        <a href="#"
            class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">🔗
            Integrasi</a>
        <a href="{{ route('admin.pengaturan.notifikasi') }}"
            class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">🔔
            Notifikasi</a>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- 1. PAYMENT GATEWAY (MIDTRANS) -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xl">
                        M</div>
                    <div>
                        <h3 class="font-bold text-gray-900">Midtrans</h3>
                        <p class="text-xs text-gray-500">Payment Gateway Indonesia</p>
                    </div>
                </div>
                <span
                    class="{{ $midtransConfigured ? 'bg-green-50 text-green-700 border-green-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200' }} px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                    {{ $midtransConfigured ? 'Terkonfigurasi' : 'Belum dikonfigurasi' }}
                </span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Server Key</span><span
                        class="text-sm font-mono text-gray-800">{{ $midtransConfigured ? 'Tersimpan di konfigurasi' : 'Belum dikonfigurasi' }}</span></div>
                <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Client Key</span><span
                        class="text-sm font-mono text-gray-800">{{ $clientKeyConfigured ? 'Tersimpan di konfigurasi' : 'Belum dikonfigurasi' }}</span></div>
                <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Mode</span><span
                        class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-xs font-bold">{{ $modeMidtrans }}</span></div>
            </div>
        </div>

        <!-- 2. NOTIFIKASI EMAIL -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center font-bold text-xl">
                        @</div>
                    <div>
                        <h3 class="font-bold text-gray-900">Pengiriman Email</h3>
                        <p class="text-xs text-gray-500">Mail driver yang digunakan aplikasi</p>
                    </div>
                </div>
                <span
                    class="bg-gray-50 text-gray-700 border border-gray-200 px-2.5 py-1 rounded-full text-xs font-bold">
                    {{ $mailDriver ?: 'Tidak dikonfigurasi' }}
                </span>
            </div>
            <p class="text-sm text-gray-500">Status provider dan nomor pengirim WhatsApp belum tersedia di konfigurasi aplikasi.</p>
        </div>

        <!-- 3. WEBHOOK PEMBAYARAN -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <div class="mb-6 border-b border-gray-100 pb-4">
                <h3 class="font-bold text-gray-900">Webhook Pembayaran</h3>
                <p class="text-xs text-gray-500">URL callback untuk menerima notifikasi pembayaran.</p>
            </div>
            <div class="space-y-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                    <span class="text-sm text-gray-500">URL Endpoint</span>
                    <span
                        class="text-sm font-mono text-gray-800 bg-gray-50 px-3 py-1 rounded border border-gray-200">{{ $webhookUrl }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Status</span>
                    <span
                        class="bg-gray-50 text-gray-700 border border-gray-200 px-2.5 py-1 rounded-full text-xs font-bold">Endpoint terdaftar</span>
                </div>
            </div>
        </div>
    </div>
@endsection
