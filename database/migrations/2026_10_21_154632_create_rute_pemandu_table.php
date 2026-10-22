
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rute_pemandu', function (Blueprint $table) {
            $table->foreignId('pemandu_id')
                ->constrained('pemandu')
                ->cascadeOnDelete();
            $table->string('rute');

            $table->primary(['pemandu_id', 'rute']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rute_pemandu');
    }
};
