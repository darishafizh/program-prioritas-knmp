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
        Schema::create('informasi_kapal_alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wawancara_id')->constrained('wawancara')->onDelete('cascade');

            $table->string('nama_kapal', 100)->nullable();
            $table->integer('tahun_pembuatan_kapal')->nullable();
            $table->float('ukuran_perahu_gt')->nullable();
            $table->string('dimensi_perahu', 100)->nullable(); // Panjang x Lebar x Dalam
            $table->string('jenis_bahan_baku_kapal', 50)->nullable();
            $table->string('jenis_alat_tangkap', 50);
            $table->string('jenis_mesin_motor', 50);
            $table->string('jenis_alat_penyimpanan_ikan', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_kapal_alat');
    }
};
