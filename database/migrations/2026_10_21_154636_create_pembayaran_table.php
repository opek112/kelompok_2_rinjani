
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemesanan_id')
                ->unique()
                ->constrained('pemesanan')
                ->cascadeOnDelete();

            $table->string('referensi_pembayaran')->unique();
            $table->text('payload_qris')->nullable();
            $table->decimal('nominal', 12, 2);

            $table->enum('status_pembayaran', [
                'pending', 'settlement', 'expire', 'failure'
            ])->default('pending');

            $table->timestamp('kedaluwarsa_pada')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
