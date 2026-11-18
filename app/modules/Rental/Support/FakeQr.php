<?php

namespace Modules\Rental\Support;

/**
 * Membuat matriks QR dekoratif yang deterministik dari sebuah kode pesanan.
 * Dipakai untuk mockup pembayaran QRIS dan e-voucher tanpa ketergantungan layanan luar.
 */
class FakeQr
{
    /**
     * @return array<int, array<int, bool>>
     */
    public static function matrix(string $seed, int $size = 25): array
    {
        $hash = hash('sha256', $seed, true);
        $matrix = [];
        $index = 0;

        for ($row = 0; $row < $size; $row++) {
            for ($column = 0; $column < $size; $column++) {
                $byte = ord($hash[$index % strlen($hash)]);
                $matrix[$row][$column] = (($byte >> ($index % 8)) & 1) === 1;
                $index++;
            }
        }

        self::drawFinder($matrix, 0, 0);
        self::drawFinder($matrix, 0, $size - 7);
        self::drawFinder($matrix, $size - 7, 0);

        return $matrix;
    }

    /**
     * @param  array<int, array<int, bool>>  $matrix
     */
    private static function drawFinder(array &$matrix, int $top, int $left): void
    {
        for ($row = 0; $row < 7; $row++) {
            for ($column = 0; $column < 7; $column++) {
                $border = $row === 0 || $row === 6 || $column === 0 || $column === 6;
                $core = $row >= 2 && $row <= 4 && $column >= 2 && $column <= 4;

                $matrix[$top + $row][$left + $column] = $border || $core;
            }
        }
    }
}
