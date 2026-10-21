
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('nomor_lisensi')->nullable();
            $table->string('path_berkas_lisensi')->nullable();
            $table->string('bahasa')->nullable();
            $table->decimal('tarif_harian', 12, 2);
            $table->text('info_rekening_bank')->nullable();
            $table->enum('status', [
                'pending', 'active', 'rejected'
            ])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemandu');
    }
};
