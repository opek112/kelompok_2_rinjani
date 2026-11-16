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
                    <h3 class="text-2xl font-bold text-gray-900">128 <span class="text-sm font-normal text-gray-500">dalam 30
                            hari</span></h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl">📄
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Omzet</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp 156.400.000</h3>
                </div>
                <div class="w-12 h-12 bg-gray-50 text-gray-500 rounded-lg flex items-center justify-center text-xl">📈</div>
            </div>
            <div class="bg-white rounded-xl border border-orange-200 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Komisi Platform</p>
                    <h3 class="text-2xl font-bold text-orange-500">Rp 15.640.000</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl">💰
                </div>
            </div>
        </div>

        <!-- 2. TABEL TRANSAKSI -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Daftar Transaksi</h3>
                <p class="text-sm text-gray-500">Menampilkan 128 transaksi.</p>
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
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900">RJN-2026-0004</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Maya Sari</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.320.000</td>
                            <td class="px-6 py-4"><span
                                    class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">Lunas</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
