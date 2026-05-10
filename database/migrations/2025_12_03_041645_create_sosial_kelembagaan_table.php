<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sosial_kelembagaan')) {
            Schema::create('sosial_kelembagaan', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('knmp_id');
                $table->unsignedBigInteger('responden_id');

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

                // FK boleh, tapi tidak wajib
                $table->foreign('knmp_id')->references('id')->on('knmp')->onDelete('cascade');
                $table->foreign('responden_id')->references('id')->on('informasi_responden')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sosial_kelembagaan');
    }
};
