@extends('admin::layouts.admin')

@section('title', 'Atur Komisi Platform')
@section('header_title', 'Atur Komisi Platform')
@section('header_desc', 'Atur persentase komisi yang dikenakan dari setiap transaksi pada platform RinjaniGuide.')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pb-20">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- FORM UBAH PERSENTASE -->
        <form action="{{ route('admin.atur-komisi.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Ubah Persentase Komisi</h3>
                <p class="text-sm text-gray-500 mb-8">Komisi akan otomatis ditagihkan dari setiap transaksi baru.</p>

                <!-- Box Input Persentase -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center mb-8">
                    <label class="block text-sm font-semibold text-gray-600 mb-3">Persentase Komisi (%)</label>
                    <div
                        class="inline-flex items-center justify-center bg-white border @error('persentase_komisi') border-red-500 @else border-gray-300 @enderror rounded-lg px-4 py-2 shadow-sm">
                        <input type="number" name="persentase_komisi" step="0.01"
                            value="{{ old('persentase_komisi', $persentase) }}"
                            class="w-24 text-center text-3xl font-bold text-gray-900 focus:outline-none bg-transparent">
                        <span class="text-2xl font-bold text-gray-400 ml-1">%</span>
                    </div>
                    @error('persentase_komisi')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slider Range -->
                <div class="px-4 mb-4">
                    <input type="range" min="1" max="30" step="0.5"
                        value="{{ old('persentase_komisi', $persentase) }}"
                        oninput="document.querySelector('input[name=persentase_komisi]').value = this.value"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-orange-500">
                    <div class="flex justify-between text-xs font-semibold text-gray-400 mt-2">
                        <span>1%</span>
                        <span>15%</span>
                        <span>30%</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat tidak tersedia karena perubahan komisi belum dicatat terpisah di database. -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mt-6">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Perubahan</h3>
                    <span class="text-xs text-gray-400">Total {{ count($riwayat) }} riwayat tercatat</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Komisi Lama</th>
                                <th class="px-6 py-4 font-semibold">Komisi Baru</th>
                                <th class="px-6 py-4 font-semibold">Diubah Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row['tanggal'] }}</td>
                                    <td class="px-6 py-4">{{ $row['lama'] }}</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full text-xs font-bold">{{ $row['baru'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $row['oleh'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada riwayat perubahan yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FLOATING ACTION BAR (Tombol Simpan) -->
            <div
                class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 px-8 flex justify-end gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20">
                <button type="button" onclick="window.history.back()"
                    class="border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Batalkan</button>
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection
