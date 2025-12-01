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
        Schema::create('profile_knmp', function (Blueprint $table) {
            $table->id();
            $table->integer('jml_penduduk_des')->nullable();
            $table->integer('jml_nelayan')->nullable();
            $table->bigInteger('pendapatan_rata_rata_nelayan')->nullable();
            $table->bigInteger('alokasi_anggaran_total')->nullable();
            $table->bigInteger('anggaran_konstruksi')->nullable();
            $table->bigInteger('anggaran_upah_kerja')->nullable();
            $table->integer('tenaga_kerja_laki_laki')->nullable();
            $table->integer('tenaga_kerja_perempuan')->nullable();
            $table->integer('tenaga_kerja_lokal')->nullable();
            $table->integer('tenaga_kerja_luar')->nullable();
            $table->integer('volume_produksi_ton')->nullable();
            $table->decimal('nilai_produksi', 15, 2)->nullable();
            $table->string('koordinat_lokasi', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_knmp');
    }
};
