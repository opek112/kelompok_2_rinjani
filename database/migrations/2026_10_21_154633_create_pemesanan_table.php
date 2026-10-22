
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemesanan')->unique();

            $table->foreignId('pelanggan_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('pemandu_id')
                ->nullable()
                ->constrained('pemandu')
                ->nullOnDelete();

            $table->string('rute')->nullable();

            // Snapshot identitas ketua rombongan
            $table->string('nama_ketua');
            $table->string('email_ketua');
            $table->string('telepon_ketua');
            $table->string('nik_ketua');
            $table->string('path_foto_ktp')->nullable();

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('total_hari');

            $table->decimal('biaya_pemandu_snapshot', 12, 2)->nullable();
            $table->decimal('total_tagihan', 12, 2);
            $table->decimal('persentase_komisi', 5, 2)->nullable();
            $table->decimal('nominal_komisi', 12, 2)->nullable();

            $table->enum('status', [
                'pending', 'paid', 'expired', 'completed', 'cancelled'
            ])->default('pending');

            $table->timestamp('waktu_serah_terima')->nullable();
            $table->boolean('kehadiran_pemandu_dikonfirmasi')->default(false);
            $table->timestamp('waktu_konfirmasi_pemandu')->nullable();
            $table->timestamps();

            $table->index(['tanggal_mulai', 'tanggal_selesai']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
