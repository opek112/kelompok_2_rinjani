<?php

namespace Modules\Rental\Support;

class Rupiah
{
    public static function format(int|float|string|null $nilai): string
    {
        return 'Rp '.number_format((float) $nilai, 0, ',', '.');
    }
}
