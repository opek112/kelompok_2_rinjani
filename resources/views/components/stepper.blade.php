@props(['step' => 1, 'type' => 'guide'])

@php
    $step2Text = $type === 'guide' ? 'Data Kepemanduan' : 'Data Toko';
    $step3Text = $type === 'guide' ? 'Sertifikat & Bank' : 'Legalitas & Bank';
@endphp

<div class="flex items-center justify-between w-full mb-8 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
    <!-- Step 1 -->
    <div class="flex flex-col items-center relative z-10 w-1/3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step == 1 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : ($step > 1 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400 border border-gray-200') }}">
            @if($step > 1) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @else 1 @endif
        </div>
        <span class="text-sm font-bold mt-2 {{ $step == 1 ? 'text-gray-900' : 'text-gray-500' }}">Data Akun</span>
        <span class="text-[11px] {{ $step == 1 ? 'text-orange-500 font-semibold' : 'text-gray-400' }}">{{ $step == 1 ? '• Aktif' : ($step > 1 ? 'Selesai' : 'Tahap 1') }}</span>
    </div>

    <!-- Garis 1 -->
    <div class="flex-1 h-[2px] -mt-6 {{ $step > 1 ? 'bg-green-500' : 'bg-gray-200' }}"></div>

    <!-- Step 2 -->
    <div class="flex flex-col items-center relative z-10 w-1/3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step == 2 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : ($step > 2 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400 border border-gray-200') }}">
            @if($step > 2) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @else 2 @endif
        </div>
        <span class="text-sm font-bold mt-2 {{ $step == 2 ? 'text-gray-900' : 'text-gray-500' }}">{{ $step2Text }}</span>
        <span class="text-[11px] {{ $step == 2 ? 'text-orange-500 font-semibold' : 'text-gray-400' }}">{{ $step == 2 ? '• Aktif' : ($step > 2 ? 'Selesai' : 'Tahap 2') }}</span>
    </div>

    <!-- Garis 2 -->
    <div class="flex-1 h-[2px] -mt-6 {{ $step > 2 ? 'bg-green-500' : 'bg-gray-200' }}"></div>

    <!-- Step 3 -->
    <div class="flex flex-col items-center relative z-10 w-1/3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step == 3 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
            3
        </div>
        <span class="text-sm font-bold mt-2 {{ $step == 3 ? 'text-gray-900' : 'text-gray-500' }}">{{ $step3Text }}</span>
        <span class="text-[11px] {{ $step == 3 ? 'text-orange-500 font-semibold' : 'text-gray-400' }}">{{ $step == 3 ? '• Aktif' : 'Tahap 3' }}</span>
    </div>
</div>