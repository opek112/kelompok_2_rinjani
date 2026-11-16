@extends('admin::layouts.admin')

@section('title', 'Notifikasi Admin')
@section('header_title', 'Notifikasi')
@section('header_desc', 'Pemantauan metrik transaksi, verifikasi gateway, dan status operasional platform.')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Filter Tabs -->
        <div class="flex items-center gap-6 border-b border-gray-200 mb-6">
            <button class="text-orange-500 font-bold border-b-2 border-orange-500 pb-3 px-1">Semua <span
                    class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full text-xs ml-1">9</span></button>
            <button class="text-gray-500 hover:text-gray-800 font-semibold pb-3 px-1 transition">Belum Dibaca <span
                    class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs ml-1">5</span></button>
            <button class="text-gray-500 hover:text-gray-800 font-semibold pb-3 px-1 transition">Sudah Dibaca</button>
        </div>

        <!-- DAFTAR NOTIFIKASI (STATIS) -->
        <div class="space-y-4">
            <!-- Notif 1 -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-orange-400"></div>
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                        🛡️</div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm">Pendaftaran Mitra Baru</h3>
                            <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Joko Wijaya mendaftar sebagai <span
                                class="font-semibold">Pemandu</span>. Menunggu verifikasi.</p>
                        <p class="text-xs text-gray-400">5 menit lalu • <a href="#"
                                class="text-orange-500 hover:underline">Buka Verifikasi →</a></p>
                    </div>
                </div>
            </div>
            <!-- Notif 2 -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">⚠️
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-red-800 text-sm">Webhook Pembayaran Gagal</h3>
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-red-700 mb-2">Signature tidak valid pada RJN-2026-0003. Periksa integrasi.
                        </p>
                        <p class="text-xs text-red-500">3 menit lalu • <a href="#"
                                class="font-semibold hover:underline">Periksa Log →</a></p>
                    </div>
                </div>
            </div>
            <!-- Notif 3 -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-green-500"></div>
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        💳</div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-green-800 text-sm">Transaksi Baru Berhasil</h3>
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-green-700 mb-2">RJN-2026-0004 sebesar Rp 1.320.000 telah dibayar lunas.</p>
                        <p class="text-xs text-green-600">7 menit lalu • <a href="#"
                                class="font-semibold hover:underline">Lihat Transaksi →</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- State Kosong -->
        <div
            class="mt-8 border-t border-gray-200 border-dashed pt-8 pb-12 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">🔔</div>
            <h3 class="font-bold text-gray-800 mb-1">Tidak Ada Notifikasi Baru</h3>
            <p class="text-sm text-gray-500 mb-4">Semua notifikasi operasional dan sistem sudah Anda baca dan tindak
                lanjuti.</p>
            <button
                class="bg-[#143529] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#1a402f] transition flex items-center gap-2">
                Ekspor Riwayat Notifikasi (PDF)
            </button>
        </div>
    </div>
@endsection
