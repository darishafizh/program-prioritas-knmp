<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informasi_pemasaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('profile_knmp')->onDelete('cascade')->unique();

            $table->text('kendala_pemasaran_text')->nullable(); // Jawaban P2
            $table->text('cara_penanganan_ikan')->nullable();    // Jawaban P3
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pemasaran');
    }
};
