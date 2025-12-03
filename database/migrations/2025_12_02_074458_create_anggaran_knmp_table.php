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
        Schema::create('anggaran_knmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('profile_knmp')->onDelete('cascade');

            // Kolom Anggaran Proyek
            $table->bigInteger('total_anggaran');         // a. Total Anggaran
            $table->bigInteger('anggaran_konstruksi');    // b. Anggaran Konstruksi
            $table->bigInteger('anggaran_pengadaan_sarpras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_knmp');
    }
};
