<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrasi - RinjaniGuide Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] font-sans text-gray-800 antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Memanggil Sidebar -->
        @include('components.admin-sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- HEADER -->
            <header class="h-20 bg-white border-b border-gray-200 flex flex-col justify-center px-8 shrink-0 z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Pengaturan</h2>
                        <p class="text-sm text-gray-500">Kelola konfigurasi sistem, parameter operasional, dan preferensi platform.</p>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.notifikasi') ?? '#' }}" class="relative block">
                            <svg class="w-6 h-6 text-gray-500 hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                        </a>
                        <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                            <div class="w-10 h-10 bg-[#143529] rounded-full flex items-center justify-center text-white font-bold">RA</div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-tight">Rizki Aditya</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- SUB-NAVIGASI TAB -->
            <div class="bg-white border-b border-gray-200 px-8 flex gap-6 shrink-0 z-10 shadow-sm">
                <a href="{{ route('admin.pengaturan') ?? '#' }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
                    ⚙️ Preferensi Sistem
                </a>
                <a href="{{ route('admin.keamanan') ?? '#' }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
                    🛡️ Keamanan Akun
                </a>
                <!-- Tab Integrasi (Aktif) -->
                <a href="#" class="text-orange-500 font-semibold border-b-2 border-orange-500 py-3 px-1 text-sm flex items-center gap-2">
                    🔗 Integrasi
                </a>
                <a href="{{ route('admin.pengaturan.notifikasi') }}" class="text-gray-500 hover:text-gray-800 font-semibold py-3 px-1 text-sm flex items-center gap-2 transition">
    🔔 Notifikasi
</a>
            </div>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto space-y-6">

                    <!-- 1. PAYMENT GATEWAY (MIDTRANS) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-xl">M</div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Midtrans</h3>
                                    <p class="text-xs text-gray-500">Payment Gateway Indonesia</p>
                                </div>
                            </div>
                            <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Terhubung
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Server Key</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-mono text-gray-800">••••••••••••1234</span>
                                    <button class="text-orange-500 hover:text-orange-600 text-xs font-bold">Edit</button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Client Key</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-mono text-gray-800">••••••••••••abcd</span>
                                    <button class="text-orange-500 hover:text-orange-600 text-xs font-bold">Edit</button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Mode</span>
                                <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-xs font-bold">SANDBOX</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
                                🔄 Uji Koneksi
                            </button>
                            <button class="text-orange-500 text-sm font-bold hover:underline">✏️ Ubah Konfigurasi</button>
                        </div>
                    </div>

                    <!-- 2. WHATSAPP API -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center font-bold text-xl">WA</div>
                                <div>
                                    <h3 class="font-bold text-gray-900">WhatsApp Business API</h3>
                                    <p class="text-xs text-gray-500">Gateway Notifikasi Transaksi & Pengingat</p>
                                </div>
                            </div>
                            <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Terhubung
                            </span>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Nomor Pengirim</span>
                                <span class="text-sm font-bold text-gray-800">0819-8765-4321</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Provider</span>
                                <span class="text-sm font-bold text-gray-800">Twilio</span>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm text-gray-500">Status Kuota</span>
                                    <span class="text-sm font-bold text-gray-800">8.520 / 10.000 pesan</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <p class="text-[10px] text-gray-400 text-right mt-1">Sisa kuota: 1.480 pesan</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
                                🔄 Uji Koneksi
                            </button>
                            <button class="text-orange-500 text-sm font-bold hover:underline">✏️ Ubah Konfigurasi</button>
                        </div>
                    </div>

                    <!-- 3. SMTP SERVER -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center font-bold text-xl">✉️</div>
                                <div>
                                    <h3 class="font-bold text-gray-900">SMTP Server</h3>
                                    <p class="text-xs text-gray-500">Pengirim Email Transaksional & Bukti Booking</p>
                                </div>
                            </div>
                            <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Terhubung
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Alamat Pengirim</span>
                                <span class="text-sm font-bold text-gray-800">no-reply@rinjaniguide.id</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Host</span>
                                <span class="text-sm font-bold text-gray-800">smtp.rinjaniguide.id</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Port</span>
                                <span class="text-sm font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">587</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
                                🔄 Uji Koneksi
                            </button>
                            <button class="text-orange-500 text-sm font-bold hover:underline">✏️ Ubah Konfigurasi</button>
                        </div>
                    </div>

                    <!-- 4. WEBHOOK PEMBAYARAN -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="mb-6 border-b border-gray-100 pb-4">
                            <h3 class="font-bold text-gray-900">Webhook Pembayaran</h3>
                            <p class="text-xs text-gray-500">URL callback untuk menerima notifikasi pembayaran.</p>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                <span class="text-sm text-gray-500">URL Endpoint</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-mono text-gray-800 bg-gray-50 px-3 py-1 rounded border border-gray-200">https://rinjaniguide.id/webhook/payment</span>
                                    <button class="text-orange-500 hover:text-orange-600 text-xs font-bold">Copy</button>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                <span class="text-sm text-gray-500">Secret Key</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-mono text-gray-800">••••••••••••efgh</span>
                                    <button class="text-orange-500 hover:text-orange-600 text-xs font-bold">Edit</button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Status</span>
                                <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-4">
                            <button class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1">
                                🔄 Regenerasi Secret
                            </button>
                        </div>

                        <!-- Peringatan -->
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 flex items-start gap-2">
                            <span class="text-orange-500 mt-0.5">⚠️</span>
                            <p class="text-xs text-orange-700 font-medium">Regenerasi secret akan membuat webhook lama tidak valid. Pastikan sudah diperbarui di dashboard payment gateway.</p>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>