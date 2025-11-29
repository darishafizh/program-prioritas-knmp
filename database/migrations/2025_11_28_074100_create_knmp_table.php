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
        Schema::create('knmp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampung', 255)->nullable();
            $table->string('lingkungan_kawasan', 255)->nullable();
            $table->text('aktivitas_usaha_nelayan')->nullable();
            $table->text('sarana_prasarana_tersedia')->nullable();
            $table->string('status_kepemilikan_tanah', 100)->nullable();
            $table->string('nama_kopdeskel', 100)->nullable();
            $table->string('dasar_hukum_kopdeskel', 255)->nullable();
            $table->string('ketua_kopdeskel', 100)->nullable();
            $table->string('status_e_kusuka', 50)->nullable();
            $table->text('jenis_usaha_sebelum_knmp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knmp');
    }
};
