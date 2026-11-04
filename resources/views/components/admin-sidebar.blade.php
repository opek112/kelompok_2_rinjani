<aside class="w-64 bg-[#143529] text-gray-300 flex flex-col justify-between hidden md:flex shrink-0">
            <div>
                <!-- Logo -->
                <div class="h-20 flex items-center px-6 gap-3 border-b border-[#1f4637]">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8l9-7 9 7v8a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg leading-tight">RinjaniGuide</h1>
                        <p class="text-[10px] text-gray-400 tracking-widest uppercase">Admin Platform</p>
                    </div>
                </div>

                <!-- Mode Badge -->
                <div class="px-6 py-4">
                    <div class="bg-[#1f4637] text-[#8bc34a] text-xs font-semibold px-3 py-1.5 rounded-full inline-flex items-center gap-2 border border-[#2a5a46]">
                        <span class="w-2 h-2 rounded-full bg-[#8bc34a]"></span> Mode Administrator
                    </div>
                </div>

                <!-- Menu Navigasi -->
                <nav class="mt-2 space-y-1">
                    <!-- Dashboard (Aktif) -->
                     <a href="/admin/dashboard" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/dashboard') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
 Dashboard
</a>
 <!-- Verifikasi Mitra -->
<a href="/admin/verifikasi" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/verifikasi') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/verifikasi') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Verifikasi Mitra  
                        <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">2</span>
                    </a>
                    <!-- Atur Komisi -->
                    <a href="{{ route('admin.atur-komisi') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/atur-komisi') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/atur-komisi') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    Atur Komisi
</a>
                    <!-- Rekap Transaksi -->
                  <a href="{{ route('admin.rekap-transaksi') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/rekap-transaksi') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/rekap-transaksi') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
    Rekap Transaksi
</a>
                    <!-- Moderasi Katalog -->
                  <a href="{{ route('admin.moderasi-katalog') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/moderasi-katalog') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/moderasi-katalog') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
    Moderasi Katalog
</a>
                    <!-- Log Audit -->
                 <a href="{{ route('admin.log-audit') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/log-audit') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/log-audit') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    Log Audit
</a>
                    <!-- Profil -->
                   <a href="{{ route('admin.profil') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/profil') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/profil') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
    Profil
</a>
                    <!-- Pengaturan -->
                    <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('admin/pengaturan') ? 'bg-[#1a402f] text-white border-l-4 border-orange-500' : 'hover:bg-[#1a402f] hover:text-white' }}">
    <svg class="w-5 h-5 {{ request()->is('admin/pengaturan') ? 'text-orange-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
    Pengaturan
</a>
                </nav>
            </div>

            <!-- Tombol Keluar -->
            <div class="p-6 border-t border-[#1f4637]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-orange-500 hover:text-orange-400 transition font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>