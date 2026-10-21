
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ketersediaan_pemandu', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemandu_id')
                ->constrained('pemandu')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('status', [
                'available', 'booked', 'off'
            ])->default('available');

            $table->foreignId('pemesanan_id')
                ->nullable()
                ->constrained('pemesanan')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['pemandu_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ketersediaan_pemandu');
    }
};
