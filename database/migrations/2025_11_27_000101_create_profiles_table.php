<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampung')->nullable();
            $table->text('lingkungan_kawasan')->nullable();
            $table->text('aktivitas_usaha_nelayan')->nullable();
            $table->text('sarana_prasarana')->nullable();
            $table->text('status_kepemilikan_tanah')->nullable();
            $table->string('nama_kopdeskel')->nullable();
            $table->text('dasar_hukum_kopdeskel')->nullable();
            $table->string('ketua_kopdeskel')->nullable();
            $table->string('status_e_kusuka')->nullable();
            $table->text('jenis_usaha_sebelum_knmp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
