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
        Schema::create('rumah_tangga', function (Blueprint $table) {
            $table->id();
            $table->string('nik_responden', 30)->unique();
            $table->foreign('nik_responden')->references('nik')->on('responden')->onDelete('cascade');
            $table->integer('jml_anggota_keluarga_total');
            $table->integer('jml_anggota_keluarga_perempuan');
            $table->integer('jml_anggota_keluarga_bekerja');
            $table->integer('jml_anggota_keluarga_perempuan_bekerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_tangga');
    }
};
