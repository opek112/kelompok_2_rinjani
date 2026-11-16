<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanPlatform extends Model
{
    protected $table = 'pengaturan_platform';
    protected $primaryKey = 'kunci';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    /**
     * Fungsi untuk membaca nilai komisi saat ini.
     * Jika belum diatur, kembalikan nilai default 10%.
     */
    public static function getKomisi(): float
    {
        // Cari data dengan kunci 'persentase_komisi'
        $pengaturan = self::find('persentase_komisi');

        // Jika datanya ada, kembalikan nilainya (dalam bentuk float/desimal)
        if ($pengaturan) {
            return (float) $pengaturan->nilai;
        }

        // Jika belum ada di database, gunakan default 10%
        return 10.00;
    }
}