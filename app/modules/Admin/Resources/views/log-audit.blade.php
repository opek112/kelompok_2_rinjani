@extends('admin::layouts.admin')

@section('title', 'Log Audit')
@section('header_title', 'Log Audit')
@section('header_desc', 'Catatan aktivitas platform untuk keperluan audit dan investigasi.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- 1. WIDGET RINGKASAN -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center shrink-0 text-xl">
                    📄</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">47</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Total Log Hari Ini</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-green-50 text-green-500 rounded-lg flex items-center justify-center shrink-0 text-xl">
                    ✅</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">38</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Webhook Berhasil</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-lg flex items-center justify-center shrink-0 text-xl">
                    ⚠️</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">3</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Webhook Gagal</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-lg flex items-center justify-center shrink-0 text-xl">
                    👤</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">6</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Aksi Admin</p>
                </div>
            </div>
        </div>

        <!-- 2. TABEL LOG AUDIT -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Aktivitas Platform</h3>
                    <p class="text-sm text-gray-500">Menampilkan 47 log hari ini.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Waktu</th>
                            <th class="px-6 py-4 font-semibold">Pengguna</th>
                            <th class="px-6 py-4 font-semibold w-1/3">Aktivitas</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-xs">26 Mei 2026, 14:32</td>
                            <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">Rizki Aditya</td>
                            <td class="px-6 py-4">Menyetujui pendaftaran pemandu: Joko Wijaya</td>
                            <td class="px-6 py-4"><span
                                    class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Berhasil</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
