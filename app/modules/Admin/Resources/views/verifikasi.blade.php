@extends('admin::layouts.admin')

@section('title', 'Verifikasi Mitra')
@section('header_title', 'Verifikasi Mitra')
@section('header_desc', 'Tinjau dan validasi pendaftaran pemandu (guide) serta toko rental.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Header Tabel -->
            <div
                class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Pendaftar</h3>
                    <p class="text-sm text-gray-500">Menampilkan mitra yang menunggu persetujuan.</p>
                </div>
                <div class="flex bg-gray-100 p-1 rounded-lg">
                    <button class="px-4 py-1.5 text-sm font-semibold text-white bg-orange-500 rounded-md shadow-sm">
                        Menunggu ({{ $totalPending }})
                    </button>
                </div>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Mitra</th>
                            <th class="px-6 py-4 font-semibold">Tipe Mitra</th>
                            <th class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                            <th class="px-6 py-4 font-semibold">Dokumen</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        <!-- LOOPING PEMANDU -->
                        @foreach ($pemanduPending as $guide)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                                            {{ substr($guide->user->nama ?? '?', 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $guide->user->nama ?? 'Tidak ada nama' }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $guide->user->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">Pemandu
                                        (Guide)</span>
                                </td>
                                <td class="px-6 py-4">{{ $guide->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($guide->path_berkas_lisensi)
                                        <a href="{{ asset('storage/' . $guide->path_berkas_lisensi) }}" target="_blank"
                                            class="text-orange-500 hover:underline flex items-center gap-1">
                                            📄 Lihat Sertifikat
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.verifikasi.pemandu.update', $guide->id) }}"
                                            method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi.pemandu.update', $guide->id) }}"
                                            method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">Tolak</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- LOOPING RENTAL -->
                        @foreach ($rentalPending as $rental)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-bold">
                                            {{ substr($rental->nama_toko, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $rental->nama_toko }}</p>
                                            <p class="text-xs text-gray-500">{{ $rental->user->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-purple-50 text-purple-700 border border-purple-200 px-2.5 py-1 rounded-full text-xs font-semibold">Toko
                                        Rental</span>
                                </td>
                                <td class="px-6 py-4">{{ $rental->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($rental->path_berkas_legalitas)
                                        <a href="{{ asset('storage/' . $rental->path_berkas_legalitas) }}" target="_blank"
                                            class="text-orange-500 hover:underline flex items-center gap-1">
                                            📄 Lihat Dokumen Usaha
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.verifikasi.rental.update', $rental->id) }}"
                                            method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi.rental.update', $rental->id) }}"
                                            method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">Tolak</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Jika Data Kosong -->
                        @if ($totalPending == 0)
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-4xl mb-3">🎉</div>
                                    <p class="font-bold text-gray-800">Semua Beres!</p>
                                    <p class="text-sm">Tidak ada pendaftar mitra yang menunggu verifikasi saat ini.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
