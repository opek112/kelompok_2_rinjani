<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemandu', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('bahasa');
            $table->string('path_foto_ktp')->nullable()->after('path_berkas_lisensi');
            $table->string('nama_bank')->nullable()->after('info_rekening_bank');
            $table->string('nomor_rekening')->nullable()->after('nama_bank');
            $table->string('nama_pemilik_rekening')->nullable()->after('nomor_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('pemandu', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'path_foto_ktp',
                'nama_bank',
                'nomor_rekening',
                'nama_pemilik_rekening',
            ]);
        });
    }
};
