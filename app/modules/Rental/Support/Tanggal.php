<?php

namespace Modules\Rental\Support;

use Carbon\CarbonInterface;

class Tanggal
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

    public static function panjang(CarbonInterface $tanggal): string
    {
        return $tanggal->day.' '.self::BULAN[(int) $tanggal->month].' '.$tanggal->year;
    }

    public static function rentang(CarbonInterface $mulai, CarbonInterface $selesai): string
    {
        if ($mulai->month === $selesai->month && $mulai->year === $selesai->year) {
            return $mulai->day.' – '.self::panjang($selesai);
        }

        return self::panjang($mulai).' – '.self::panjang($selesai);
    }
}
