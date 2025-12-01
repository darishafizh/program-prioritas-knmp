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
        Schema::create('data_produksi_perikanan', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel wawancara
            $table->foreignId('wawancara_id')->constrained('wawancara')->onDelete('cascade');

            // Data Trip dan Melaut
            $table->float('jumlah_hari_per_trip');
            $table->float('lama_waktu_melaut_jam');
            $table->float('jarak_ke_daerah_penangkapan_mil');
            $table->float('waktu_tempuh_ke_penangkapan_jam');
            $table->float('jumlah_trip_per_bulan');
            $table->float('jumlah_bulan_melaut_per_tahun');

            // Data Produksi dan Penjualan
            $table->float('rata_rata_produksi_per_trip_kg');
            $table->bigInteger('rata_rata_penjualan_ikan_per_trip');

            // Biaya dan Volume Solar/Bensin
            $table->bigInteger('biaya_solar_per_trip');
            $table->float('volume_solar_per_trip'); // Dalam Rupiah per Trip
            $table->bigInteger('biaya_bensin_per_trip');
            $table->float('volume_bensin_per_trip_liter');

            // Biaya dan Volume Es
            $table->bigInteger('biaya_es_balok_pabrik_per_trip');
            $table->float('volume_es_balok_pabrik_per_trip_balok');
            $table->bigInteger('biaya_es_kantong_per_trip');
            $table->float('volume_es_kantong_per_trip_kantong');

            // Total
            $table->bigInteger('total_biaya_operasional_melaut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_produksi_perikanan');
    }
};
