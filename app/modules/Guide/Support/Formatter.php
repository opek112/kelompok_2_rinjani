<?php

namespace Modules\Guide\Support;

use Carbon\CarbonInterface;

class Formatter
{
    private const BULAN = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    public static function rupiah(int|float|string|null $nilai): string
    {
        return 'Rp '.number_format((float) $nilai, 0, ',', '.');
    }

    public static function tanggal(CarbonInterface $tanggal): string
    {
        return $tanggal->day.' '.self::BULAN[(int) $tanggal->month].' '.$tanggal->year;
    }

    public static function tanggalPendek(CarbonInterface $tanggal): string
    {
        return $tanggal->day.' '.self::BULAN[(int) $tanggal->month];
    }

    public static function bulan(CarbonInterface $tanggal): string
    {
        return self::BULAN[(int) $tanggal->month].' '.$tanggal->year;
    }

    public static function rentang(CarbonInterface $mulai, CarbonInterface $selesai): string
    {
        if ($mulai->month === $selesai->month && $mulai->year === $selesai->year) {
            return $mulai->day.'–'.$selesai->day.' '.self::BULAN[(int) $selesai->month].' '.$selesai->year;
        }

        return self::tanggalPendek($mulai).' – '.self::tanggal($selesai);
    }

    public static function durasi(int $hari): string
    {
        $malam = max(0, $hari - 1);

        return $hari.' hari'.($malam > 0 ? ' '.$malam.' malam' : '');
    }
}
