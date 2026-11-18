@php
    use Modules\Rental\Support\FakeQr;

    $ukuran = $ukuran ?? 25;
    $warna = $warna ?? 'bg-brand-dark';
    $matriks = FakeQr::matrix($kode, $ukuran);
@endphp

<div class="grid w-full h-full" style="grid-template-columns: repeat({{ $ukuran }}, minmax(0, 1fr)); grid-auto-rows: 1fr; gap: 1px;">
    @foreach ($matriks as $baris)
        @foreach ($baris as $sel)
            <span class="{{ $sel ? $warna : 'bg-white' }}"></span>
        @endforeach
    @endforeach
</div>
