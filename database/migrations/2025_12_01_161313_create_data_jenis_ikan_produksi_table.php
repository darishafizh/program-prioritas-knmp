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
        Schema::create('data_jenis_ikan_produksi', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel data_produksi_perikanan
            $table->foreignId('produksi_id')->constrained('data_produksi_perikanan')->onDelete('cascade');

            $table->string('jenis_ikan', 100);
            $table->string('kondisi_saat_ini', 100)->nullable();
            $table->float('persentase_dari_total_produksi'); // % dari Total Produksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_jenis_ikan_produksi');
    }
};
