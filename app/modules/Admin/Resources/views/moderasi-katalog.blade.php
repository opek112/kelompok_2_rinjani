@extends('admin::layouts.admin')

@section('title', 'Moderasi Katalog')
@section('header_title', 'Moderasi Katalog')
@section('header_desc', 'Kelola dan moderasi status publikasi mitra pemandu serta inventaris alat sewa.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- TAB MENU -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
                class="bg-white rounded-xl border border-orange-500 shadow-sm p-4 flex items-center justify-between cursor-pointer relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-orange-500"></div>
                <div class="flex items-center gap-3 pl-2"><span class="text-xl">🧗‍♂️</span><span
                        class="font-bold text-gray-900">Pemandu</span></div>
                <span class="bg-orange-100 text-orange-600 font-bold px-2 py-0.5 rounded text-sm">34</span>
            </div>
            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                <div class="flex items-center gap-3 pl-2"><span class="text-xl">🎒</span><span
                        class="font-bold text-gray-500">Alat Sewa</span></div>
                <span class="bg-gray-100 text-gray-600 font-bold px-2 py-0.5 rounded text-sm">48</span>
            </div>
        </div>

        <!-- TABEL DATA -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Pemandu</th>
                            <th class="px-6 py-4 font-semibold">Tarif/Hari</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">Ahmad Rifai</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 400.000</td>
                            <td class="px-6 py-4"><span
                                    class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold">Aktif</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
