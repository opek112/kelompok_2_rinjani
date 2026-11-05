<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - RinjaniGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0 z-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Profil Admin</h2>
                    <p class="text-sm text-gray-500">Kelola informasi profil, keamanan, dan hak akses administrator.</p>
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
            <div class="flex-1 overflow-y-auto p-8 pb-32">
                <div class="max-w-4xl mx-auto space-y-6">

                    <!-- KARTU PROFIL UTAMA -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden relative">
                        <div class="h-32 bg-[#143529] w-full relative">
                            <!-- Pattern Background -->
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                        </div>
                        <div class="px-8 pb-8 flex flex-col items-center relative -mt-16">
                            <div class="w-28 h-28 bg-[#1a402f] rounded-full border-4 border-white shadow-md flex items-center justify-center text-white font-bold text-4xl relative">
                                RA
                                <div class="absolute bottom-1 right-1 w-6 h-6 bg-orange-500 border-2 border-white rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </div>
                            </div>
                            
                            <h3 class="mt-4 text-2xl font-bold text-gray-900">Rizki Aditya</h3>
                            <p class="text-sm text-gray-500">admin@rinjaniguide.id &nbsp;•&nbsp; 0819-1111-2222</p>
                            
                            <span class="mt-3 inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Akun Terverifikasi
                            </span>

                            <div class="mt-6 flex gap-3">
                                <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Ganti Foto</button>
                                <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Hapus Foto</button>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2">JPG, PNG maksimal 2MB</p>
                        </div>
                    </div>

                    <!-- KARTU DATA PRIBADI (FORM) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Data Pribadi</h3>
                        <p class="text-sm text-gray-500 mb-6">Perbarui informasi dasar dan detail akun Anda.</p>

                        <form class="space-y-5">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" value="Rizki Aditya" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed" disabled>
                                <p class="text-[11px] text-gray-500 mt-1">Nama lengkap hanya dapat diubah oleh tim Super Admin.</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" value="admin@rinjaniguide.id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-gray-50 cursor-not-allowed" disabled>
                                <p class="text-[11px] text-gray-500 mt-1">Email digunakan untuk login dan menerima notifikasi sistem.</p>
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                                <input type="text" value="0819-1111-2222" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm bg-white">
                            </div>
                        </form>
                    </div>

                    <!-- KARTU HAK AKSES -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Hak Akses</h3>
                        <p class="text-sm text-gray-500 mb-6">Fitur dan modul yang tersedia untuk peran Anda.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- List Hak Akses -->
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Verifikasi Mitra (Pemandu & Toko Rental)</span>
                            </div>
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Atur Komisi Platform</span>
                            </div>
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Rekap Transaksi Global</span>
                            </div>
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Moderasi Katalog</span>
                            </div>
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Log Audit</span>
                            </div>
                            <div class="flex items-center gap-3 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-semibold">Pengaturan Sistem</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FLOATING ACTION BAR (Muncul saat form diedit) -->
            <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 px-8 flex items-center justify-between shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20">
                <div class="text-sm text-gray-500 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Ada perubahan yang belum disimpan.
                </div>
                <div class="flex gap-3">
                    <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Batalkan</button>
                    <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">Simpan Perubahan</button>
                </div>
            </div>

        </main>
    </div>
</body>
</html>