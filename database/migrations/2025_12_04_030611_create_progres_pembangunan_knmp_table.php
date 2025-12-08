<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progres_pembangunan_knmp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id');

            // Profil proyek
            $table->bigInteger('total_anggaran')->nullable();
            $table->bigInteger('anggaran_konstruksi')->nullable();
            $table->bigInteger('anggaran_sarpras')->nullable();

            // Tenaga kerja
            $table->integer('tk_konstruksi_l')->nullable();
            $table->integer('tk_konstruksi_p')->nullable();
            $table->integer('upah_per_hari')->nullable();
            $table->integer('lama_bekerja')->nullable();
            $table->integer('tk_lokal')->nullable();
            $table->integer('tk_luar')->nullable();
            $table->text('tk_non_konstruksi')->nullable();

            // CCTV
            $table->enum('cctv', ['Ya', 'Tidak'])->nullable();

            $table->timestamps();

            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_pembangunan_knmp');
    }
};
