
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_pemesanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemesanan_id')
                ->constrained('pemesanan')
                ->cascadeOnDelete();

            $table->foreignId('peralatan_id')
                ->constrained('peralatan')
                ->restrictOnDelete();

            $table->integer('jumlah');
            $table->decimal('tarif_per_hari_snapshot', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_pemesanan');
    }
};
