<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toko_rental', function (Blueprint $table) {
            $table->string('lokasi_pos')->nullable()->after('nama_toko');
            $table->text('deskripsi')->nullable()->after('alamat');
            $table->string('nib')->nullable()->after('path_berkas_legalitas');
            $table->string('npwp')->nullable()->after('nib');
            $table->string('nama_bank')->nullable()->after('info_rekening_bank');
            $table->string('nomor_rekening')->nullable()->after('nama_bank');
            $table->string('nama_pemilik_rekening')->nullable()->after('nomor_rekening');
            $table->string('hari_buka')->default('Senin–Sabtu')->after('nama_pemilik_rekening');
            $table->string('jam_buka', 5)->default('08:00')->after('hari_buka');
            $table->string('jam_tutup', 5)->default('20:00')->after('jam_buka');
            $table->json('notifikasi')->nullable()->after('jam_tutup');
            $table->unsignedSmallInteger('batas_stok_minimum')->default(5)->after('notifikasi');
            $table->boolean('auto_tutup_kosong')->default(true)->after('batas_stok_minimum');
            $table->boolean('tutup_hari_libur')->default(true)->after('auto_tutup_kosong');
            $table->boolean('aktif')->default(true)->after('tutup_hari_libur');
        });

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->timestamp('waktu_pengembalian')->nullable()->after('waktu_serah_terima');
            $table->text('catatan_pengembalian')->nullable()->after('waktu_pengembalian');
            $table->json('foto_pengembalian')->nullable()->after('catatan_pengembalian');
            $table->decimal('denda_total', 12, 2)->default(0)->after('foto_pengembalian');
        });

        Schema::table('pengembalian_peralatan', function (Blueprint $table) {
            $table->decimal('denda', 12, 2)->default(0)->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('pengembalian_peralatan', function (Blueprint $table) {
            $table->dropColumn('denda');
        });

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_pengembalian',
                'catatan_pengembalian',
                'foto_pengembalian',
                'denda_total',
            ]);
        });

        Schema::table('toko_rental', function (Blueprint $table) {
            $table->dropColumn([
                'lokasi_pos',
                'deskripsi',
                'nib',
                'npwp',
                'nama_bank',
                'nomor_rekening',
                'nama_pemilik_rekening',
                'hari_buka',
                'jam_buka',
                'jam_tutup',
                'notifikasi',
                'batas_stok_minimum',
                'auto_tutup_kosong',
                'tutup_hari_libur',
                'aktif',
            ]);
        });
    }
};
