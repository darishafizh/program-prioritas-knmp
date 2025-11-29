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
        Schema::create('kesejahteraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp')->cascadeOnDelete();
            $table->decimal('produksi_perikanan', 10, 2)->nullable();
            $table->integer('jumlah_armada')->nullable();
            $table->decimal('pendapatan_rumah_tangga', 15, 2)->nullable();
            $table->integer('penyerapan_tenaga_kerja_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesejahteraan');
    }
};
