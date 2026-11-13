@extends('Onboarding::layouts.partner')

@section('title', 'Menunggu Verifikasi')
@section('portal-subtitle', 'Pendaftaran Mitra')
@section('portal-badge', 'Menunggu Verifikasi')
@section('hero-title', 'Sabar ya, sebentar lagi.')
@section('hero-desc', 'Proses peninjauan dokumen lisensi dan identitas mitra dijalankan secara teliti demi menjaga standar keselamatan pendakian Taman Nasional Gunung Rinjani.')
@section('hero-features')
    <div class="flex items-center gap-3 bg-white/5 p-4 rounded-xl text-sm border border-white/5"><span class="text-xl">⏱️</span> Verifikasi Akurat 1x24 Jam</div>
    <div class="flex items-center gap-3 bg-white/5 p-4 rounded-xl text-sm border border-white/5"><span class="text-xl">🔔</span> Notifikasi Otomatis via WhatsApp & Email</div>
    <div class="flex items-center gap-3 bg-white/5 p-4 rounded-xl text-sm border border-white/5"><span class="text-xl">🎧</span> Dukungan Helpdesk Kemitraan 24 Jam</div>
@endsection

@section('content')
    <div class="max-w-md mx-auto mt-4 text-center">
        
        <!-- Icon Centang -->
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-sm border border-green-100 relative">
            ⏳
            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1"><span class="text-green-500 text-lg">✔️</span></div>
        </div>
        
        <h1 class="text-2xl font-serif font-bold text-gray-900 mb-2">Pendaftaran Sedang Ditinjau</h1>
        <p class="text-sm text-gray-500 mb-8">Tim admin akan memverifikasi data Anda dalam 1x24 jam. Anda akan menerima notifikasi via email dan WhatsApp setelah akun aktif.</p>

        <!-- Kartu Detail Data -->
        <div class="bg-white border border-gray-200 rounded-xl text-left shadow-sm mb-6">
            <div class="flex justify-between items-center p-4 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Data Pendaftaran</span>
                <span class="text-xs font-bold text-gray-700 bg-gray-200 px-2 py-1 rounded">ID: MITRA-{{ date('Ymd') }}</span>
            </div>
            <div class="p-4 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Nama</span> <span class="font-semibold text-gray-900">{{ Auth::user()->nama ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Email</span> <span class="font-semibold text-gray-900">{{ Auth::user()->email ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">No. WhatsApp</span> <span class="font-semibold text-gray-900">{{ Auth::user()->no_telepon ?? '-' }}</span></div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jenis Mitra</span> 
                    <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-0.5 rounded border border-blue-100">• {{ ucfirst(Auth::user()->peran ?? 'Mitra') }}</span>
                </div>
                <div class="flex justify-between"><span class="text-gray-500">Tanggal Daftar</span> <span class="font-semibold text-gray-900">{{ date('d M Y') }}</span></div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span> 
                    <span class="bg-yellow-50 text-yellow-600 text-xs font-bold px-2 py-0.5 rounded border border-yellow-200">• Menunggu Verifikasi</span>
                </div>
            </div>
        </div>

        <!-- Timeline Vertikal -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 text-left shadow-sm mb-8">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-6">Tahapan Verifikasi</h3>
            
            <div class="relative border-l border-gray-200 ml-3 space-y-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="absolute -left-[17px] bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center border-4 border-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-gray-900">Pendaftaran Dikirim</h4>
                        <p class="text-xs text-gray-500">{{ date('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative">
                    <div class="absolute -left-[17px] bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center border-4 border-white shadow-md shadow-orange-500/40">
                        <span class="w-2.5 h-2.5 bg-white rounded-full"></span>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-orange-500">Sedang Diverifikasi</h4>
                        <p class="text-xs text-gray-500">Pengecekan kelengkapan sertifikat & KTP oleh admin</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="relative opacity-50">
                    <div class="absolute -left-[17px] bg-gray-100 text-gray-400 rounded-full w-8 h-8 flex items-center justify-center border-4 border-white">
                        <span class="w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-gray-500">Akun Aktif</h4>
                        <p class="text-xs text-gray-400">Siap menerima order pendakian di katalog publik</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="space-y-3">
            <a href="#" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 transition shadow-lg shadow-orange-500/30">
                💬 Hubungi Admin via WhatsApp
            </a>
            <button class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 hover:bg-gray-50 transition">
                🔄 Cek Status Verifikasi
            </button>
        </div>
        
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-800">Keluar</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

        <p class="text-xs text-gray-400 mt-12 mb-4 flex items-center justify-center gap-1">🔒 Data Anda terenkripsi aman di sistem pengelola Gunung Rinjani</p>
    </div>
@endsection