<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peralatan', function (Blueprint $table) {
            $table->string('pos')->nullable()->after('kategori');
            $table->string('kapasitas')->nullable()->after('path_gambar');
            $table->string('berat')->nullable()->after('kapasitas');
            $table->string('material')->nullable()->after('berat');
            $table->string('dimensi')->nullable()->after('material');
            $table->decimal('rating', 2, 1)->default(4.8)->after('dimensi');
            $table->unsignedInteger('jumlah_ulasan')->default(0)->after('rating');
            $table->json('galeri')->nullable()->after('jumlah_ulasan');
            $table->boolean('sorotan')->default(false)->after('galeri');

            $table->index('pos');
        });
    }

    public function down(): void
    {
        Schema::table('peralatan', function (Blueprint $table) {
            $table->dropIndex(['pos']);
            $table->dropColumn([
                'pos',
                'kapasitas',
                'berat',
                'material',
                'dimensi',
                'rating',
                'jumlah_ulasan',
                'galeri',
                'sorotan',
            ]);
        });
    }
};
