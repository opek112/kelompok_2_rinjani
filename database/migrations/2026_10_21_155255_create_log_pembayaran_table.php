
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pembayaran_id')
                ->constrained('pembayaran')
                ->cascadeOnDelete();

            $table->longText('payload_mentah')->nullable();
            $table->boolean('tanda_tangan_valid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_pembayaran');
    }
};
