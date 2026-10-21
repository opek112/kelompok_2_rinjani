
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toko_rental', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('nama_toko');
            $table->text('alamat')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('telepon_toko')->nullable();
            $table->string('path_berkas_legalitas')->nullable();
            $table->text('info_rekening_bank')->nullable();
            $table->enum('status', [
                'pending', 'active', 'rejected'
            ])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toko_rental');
    }
};
