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
        if (!Schema::hasTable('informasi_usaha')) {
            Schema::create('informasi_usaha', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('knmp_id');
                $table->foreign('knmp_id')->references('id')->on('knmp')->onDelete('cascade');

                // A. Kapal
                $table->string('nama_kapal')->nullable();
                $table->integer('tahun_pembuatan')->nullable();
                $table->float('ukuran_gt')->nullable();
                $table->string('dimensi_perahu')->nullable();
                $table->string('jenis_bahan_baku')->nullable();
                $table->string('jenis_mesin')->nullable();
                $table->string('alat_penyimpanan')->nullable();
                $table->string('jenis_alat_tangkap')->nullable();

                // B. Produksi
                $table->float('hari_per_trip')->nullable();
                $table->float('waktu_melaut_jam')->nullable();
                $table->float('jarak_penangkapan_mil')->nullable();
                $table->float('waktu_tempuh_jam')->nullable();
                $table->float('jml_trip_per_bulan')->nullable();
                $table->float('jml_bulan_melaut')->nullable();
                $table->float('produksi_kg_per_trip')->nullable();
                $table->float('penjualan_rp_per_trip')->nullable();
                $table->float('biaya_solar_rp')->nullable();
                $table->float('volume_solar_liter')->nullable();
                $table->float('biaya_bensin_rp')->nullable();
                $table->float('volume_bensin_liter')->nullable();
                $table->float('biaya_es_balok_rp')->nullable();
                $table->float('volume_es_balok')->nullable();
                $table->float('biaya_es_kantong_rp')->nullable();
                $table->float('volume_es_kantong')->nullable();
                $table->float('total_biaya_operasional')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_usaha');
    }
};
