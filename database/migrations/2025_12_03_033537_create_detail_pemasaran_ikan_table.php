<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemasaran_ikan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pemasaran_id');

            // Kolom Penjualan per Pembeli (Kg/Trip)
            $table->decimal('eceran_kg', 10, 2)->nullable();
            $table->decimal('koperasi_kg', 10, 2)->nullable();
            $table->decimal('tengkulak_kg', 10, 2)->nullable();
            $table->decimal('pengepul_kg', 10, 2)->nullable();
            $table->decimal('pedagang_besar_kg', 10, 2)->nullable();
            $table->decimal('lainnya_kg', 10, 2)->nullable();
            $table->string('lainnya_keterangan')->nullable();

            $table->timestamps();

            // =========================
            // FOREIGN KEY
            // =========================
            $table->foreign('pemasaran_id')
                ->references('id')
                ->on('informasi_pemasaran')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemasaran_ikan');
    }
};
