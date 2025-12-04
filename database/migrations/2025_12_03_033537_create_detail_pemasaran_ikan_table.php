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
        Schema::create('detail_pemasaran_ikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemasaran_id')->constrained('informasi_pemasaran')->onDelete('cascade')->unique();

            // Kolom Penjualan per Pembeli (Kg/Trip)
            $table->decimal('eceran_kg', 8, 2)->nullable();
            $table->decimal('koperasi_kg', 8, 2)->nullable();
            $table->decimal('tengkulak_kg', 8, 2)->nullable();
            $table->decimal('pengepul_kg', 8, 2)->nullable();
            $table->decimal('pedagang_besar_kg', 8, 2)->nullable();
            $table->decimal('lainnya_kg', 8, 2)->nullable();
            $table->string('lainnya_keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemasaran_ikan');
    }
};
