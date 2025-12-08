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
        Schema::create('progres_knmp_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('progres_id');

            $table->string('kode');
            $table->string('komponen');
            $table->integer('target')->nullable();
            $table->integer('persen')->nullable();
            $table->string('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('progres_id')->references('id')->on('progres_knmp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_knmp_details');
    }
};
