@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Admin')
@section('header_desc', 'Pemantauan metrik operasional, transaksi ekosistem, dan aktivitas platform')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- 1. WIDGET CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Card 1: Total Transaksi -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $totalTransaksi }}</h3>
                <p class="text-xs text-gray-500 mt-1">Total Transaksi</p>
            </div>

            <!-- Card 2: Total Omzet -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-500 mt-1">Total Omzet</p>
            </div>

            <!-- Card 3: Komisi Platform -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalKomisi, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-500 mt-1">Komisi Platform</p>
            </div>

            <!-- Card 4: Mitra Pemandu -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $totalPemandu }}</h3>
                <p class="text-xs text-gray-500 mt-1">Mitra Pemandu</p>
            </div>

            <!-- Card 5: Mitra Rental -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="bg-orange-50 text-orange-500 w-10 h-10 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $totalRental }}</h3>
                <p class="text-xs text-gray-500 mt-1">Mitra Rental</p>
            </div>
        </div>

        <!-- 2. ALERT BANNER -->
        <div class="bg-[#fff9e6] border border-[#ffeeba] rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Butuh Perhatian</h4>
                    <p class="text-sm text-gray-600">2 pendaftaran mitra menunggu verifikasi.</p>
                </div>
            </div>
            <button class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition">
                Lihat Sekarang →
            </button>
        </div>

        <!-- 3. CHART SECTION (Masih Statis) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Transaksi 6 Bulan Terakhir</h3>
                    <p class="text-sm text-gray-500">Total omzet per bulan.</p>
                </div>
                <div class="flex bg-gray-100 p-1 rounded-lg">
                    <button class="px-4 py-1.5 text-sm font-semibold text-white bg-orange-500 rounded-md shadow-sm">Omzet</button>
                    <button class="px-4 py-1.5 text-sm font-semibold text-gray-600 hover:text-gray-900">Jumlah Transaksi</button>
                </div>
            </div>

            <!-- Fake Chart -->
            <div class="h-64 flex items-end justify-between px-4 pb-4 border-b border-gray-200 relative">
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                    <div class="border-t border-gray-100 w-full h-0"></div>
                    <div class="border-t border-gray-100 w-full h-0"></div>
                    <div class="border-t border-gray-100 w-full h-0"></div>
                    <div class="border-t border-gray-100 w-full h-0"></div>
                </div>

                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 18jt</span>
                    <div class="w-10 bg-[#143529] rounded-t-md h-32 group-hover:bg-[#1a402f] transition"></div>
                    <span class="text-xs text-gray-500">Des 2025</span>
                </div>
                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 22jt</span>
                    <div class="w-10 bg-[#143529] rounded-t-md h-40 group-hover:bg-[#1a402f] transition"></div>
                    <span class="text-xs text-gray-500">Jan</span>
                </div>
                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 24jt</span>
                    <div class="w-10 bg-[#143529] rounded-t-md h-44 group-hover:bg-[#1a402f] transition"></div>
                    <span class="text-xs text-gray-500">Feb</span>
                </div>
                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 28jt</span>
                    <div class="w-10 bg-[#143529] rounded-t-md h-52 group-hover:bg-[#1a402f] transition"></div>
                    <span class="text-xs text-gray-500">Mar</span>
                </div>
                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition">Rp 31jt</span>
                    <div class="w-10 bg-[#143529] rounded-t-md h-56 group-hover:bg-[#1a402f] transition"></div>
                    <span class="text-xs text-gray-500">Apr</span>
                </div>
                <div class="flex flex-col items-center gap-2 w-16 relative z-10 group">
                    <span class="text-xs font-bold text-orange-500">Rp 33.4jt</span>
                    <div class="w-10 bg-orange-500 rounded-t-md h-60 shadow-lg shadow-orange-500/30"></div>
                    <span class="text-xs font-bold text-orange-500">Mei</span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-3 text-[11px] text-gray-400">
                <p>*Data agregat mencakup transaksi sewa alat dan reservasi pemandu terverifikasi.</p>
                <p>Skala Otomatis (Rp 0 - Rp 40jt)</p>
            </div>
        </div>

        <!-- 4. TABEL TRANSAKSI -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h3>
                    <p class="text-sm text-gray-500">Daftar transaksi pesanan terakhir yang diproses sistem</p>
                </div>
                <a href="#" class="text-sm text-orange-500 font-semibold hover:underline">Lihat Semua Transaksi →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                            <th class="px-6 py-4 font-semibold">Pemesan</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transaksiTerbaru as $trx)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $trx->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-mono text-xs">{{ $trx->kode_pemesanan }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $trx->pelanggan ? $trx->pelanggan->nama : $trx->nama_ketua }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rp {{ number_format($trx->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($trx->status == 'paid')
                                        <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Lunas</span>
                                    @elseif($trx->status == 'pending')
                                        <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Menunggu</span>
                                    @elseif($trx->status == 'completed')
                                        <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Selesai</span>
                                    @else
                                        <span class="bg-gray-50 text-gray-700 border border-gray-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max">{{ $trx->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data transaksi di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. AKTIVITAS TERBARU -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
                <p class="text-sm text-gray-500">Catatan tindakan administratif dan sistem dalam ekosistem</p>
            </div>
            <div class="p-2">
                @forelse($aktivitasTerbaru as $act)
                    <div class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition border-b border-gray-50">
                        <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">Pemesanan baru dibuat: {{ $act->kode_pemesanan }} oleh {{ $act->nama_ketua }}</p>
                            <p class="text-xs text-gray-500">{{ $act->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-sm text-gray-500">Belum ada aktivitas.</div>
                @endforelse
            </div>
            <div class="p-4 border-t border-gray-100 text-right">
                <a href="#" class="text-sm text-orange-500 font-semibold hover:underline">Lihat Semua Log Audit →</a>
            </div>
        </div>

    </div>
@endsection