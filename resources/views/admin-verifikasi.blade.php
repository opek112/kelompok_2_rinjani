<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Mitra - RinjaniGuide Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar yang sudah kita buat sebelumnya -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Verifikasi Mitra</h2>
                    <p class="text-sm text-gray-500">Tinjau dan validasi pendaftaran pemandu (guide) serta toko rental.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Notifikasi -->
                    <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                        <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    </a>
                    <!-- Profile -->
                    <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                        <div class="w-10 h-10 bg-[#143529] rounded-full flex items-center justify-center text-white font-bold">
                            RA
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-tight">Rizki Aditya</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- TABEL VERIFIKASI -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        
                        <!-- Header Tabel & Filter -->
                        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Daftar Pendaftar</h3>
                                <p class="text-sm text-gray-500">Menampilkan mitra yang menunggu persetujuan.</p>
                            </div>
                            
                            <!-- Filter Tabs -->
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button class="px-4 py-1.5 text-sm font-semibold text-white bg-orange-500 rounded-md shadow-sm">Menunggu (2)</button>
                                <button class="px-4 py-1.5 text-sm font-semibold text-gray-600 hover:text-gray-900">Disetujui</button>
                                <button class="px-4 py-1.5 text-sm font-semibold text-gray-600 hover:text-gray-900">Ditolak</button>
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
                                    
                                    <!-- Baris 1: Pemandu -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">JW</div>
                                                <div>
                                                    <p class="font-bold text-gray-900">Joko Wijaya</p>
                                                    <p class="text-xs text-gray-500">joko.wijaya@email.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">Pemandu (Guide)</span>
                                        </td>
                                        <td class="px-6 py-4">26 Mei 2026</td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-orange-500 hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat KTP & Sertifikat
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Setujui</button>
                                                <button class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">Tolak</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Baris 2: Rental -->
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-bold">ST</div>
                                                <div>
                                                    <p class="font-bold text-gray-900">Sembalun Trekker</p>
                                                    <p class="text-xs text-gray-500">admin@sembaluntrekker.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-50 text-purple-700 border border-purple-200 px-2.5 py-1 rounded-full text-xs font-semibold">Toko Rental</span>
                                        </td>
                                        <td class="px-6 py-4">25 Mei 2026</td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-orange-500 hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat Dokumen Usaha
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Setujui</button>
                                                <button class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">Tolak</button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Footer Tabel -->
                        <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center text-sm text-gray-500">
                            <span>Menampilkan 2 pendaftar baru</span>
                            <div class="flex gap-1">
                                <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-400 cursor-not-allowed">Sebelumnya</button>
                                <button class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-50">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>