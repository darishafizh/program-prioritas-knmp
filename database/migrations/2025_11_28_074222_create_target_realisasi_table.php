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
        Schema::create('target_realisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp')->cascadeOnDelete();
            $table->string('nama_knmp_header', 255)->nullable();
            $table->decimal('target_fisik', 5, 2)->nullable();
            $table->decimal('realisasi_fisik', 5, 2)->nullable();
            $table->decimal('deviasi', 5, 2)->nullable();
            $table->decimal('target_keuangan', 18, 2)->nullable();
            $table->decimal('realisasi_keuangan', 18, 2)->nullable();
            $table->text('permasalahan_1')->nullable();
            // ... (Permasalahan 2 & 3, Rekomendasi 1, 2, 3)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_realisasi');
    }
};
