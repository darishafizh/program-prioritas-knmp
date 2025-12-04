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
        Schema::create('sosial_kelembagaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')
                ->constrained('knmp')
                ->onDelete('cascade');

            $table->string('anggota_kelompok')->nullable();
            $table->string('manfaat_kelompok')->nullable();
            $table->string('anggota_koperasi')->nullable();
            $table->string('tertarik_koperasi')->nullable();
            $table->string('manfaat_koperasi')->nullable();

            $table->string('koperasi_rapat_tahunan')->nullable();
            $table->string('koperasi_partisipasi_aktif')->nullable();
            $table->string('koperasi_pengurus_kompeten')->nullable();
            $table->string('koperasi_transparan')->nullable();
            $table->string('koperasi_keuangan_sehat')->nullable();
            $table->string('koperasi_jaringan_pasar')->nullable();
            $table->string('koperasi_kepercayaan_usaha')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosial_kelembagaan');
    }
};
