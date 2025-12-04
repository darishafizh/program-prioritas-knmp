<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_knmp', function (Blueprint $table) {
            $table->id();

            $table->integer('jumlah_penduduk_desa')->nullable();
            $table->integer('jumlah_nelayan')->nullable();
            $table->integer('pendapatan_rata_rata')->nullable();

            $table->integer('alokasi_konstruksi')->nullable();
            $table->integer('alokasi_upah')->nullable();

            $table->integer('tk_laki_laki')->nullable();
            $table->integer('tk_perempuan')->nullable();

            $table->integer('tk_lokal')->nullable();
            $table->integer('tk_luar')->nullable();

            $table->integer('volume_produksi')->nullable();
            $table->integer('nilai_produksi')->nullable();

            $table->string('calon_kopdesmp')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->string('sk_kopdeskel')->nullable();
            $table->string('nomor_induk_kopdeskel')->nullable();

            $table->integer('jumlah_anggota_laki')->nullable();
            $table->integer('jumlah_anggota_perempuan')->nullable();

            $table->string('koordinat_lokasi')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_knmp');
    }
};
