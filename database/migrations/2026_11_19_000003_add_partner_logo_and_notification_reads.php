<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toko_rental', function (Blueprint $table) {
            $table->string('path_logo')->nullable()->after('nama_toko');
            $table->json('notifikasi_dibaca')->nullable()->after('notifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('toko_rental', function (Blueprint $table) {
            $table->dropColumn(['path_logo', 'notifikasi_dibaca']);
        });
    }
};
