
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peralatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_rental_id')
                ->constrained('toko_rental')
                ->restrictOnDelete();
            $table->string('nama');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('path_gambar')->nullable();
            $table->decimal('tarif_harian', 12, 2);
            $table->integer('jumlah_stok');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peralatan');
    }
};
