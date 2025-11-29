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
        Schema::create('penyerapan_tenaga_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp')->cascadeOnDelete();
            $table->integer('target_total_tk')->nullable();
            $table->integer('realisasi_tk_konstruksi_saat_ini')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyerapan_tenaga_kerja');
    }
};
