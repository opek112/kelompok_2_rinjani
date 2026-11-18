<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('no_telepon');
        });

        Schema::table('pemandu', function (Blueprint $table) {
            $table->string('path_sertifikat_pendakian')->nullable()->after('path_foto_ktp');
        });
    }

    public function down(): void
    {
        Schema::table('pemandu', function (Blueprint $table) {
            $table->dropColumn('path_sertifikat_pendakian');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
