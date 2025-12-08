<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progres_komponen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('progres_id');
            $table->unsignedBigInteger('komponen_id');

            $table->integer('target')->nullable();
            $table->integer('progres')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('progres_id')
                ->references('id')
                ->on('progres_pembangunan_knmp')
                ->onDelete('cascade');

            $table->foreign('komponen_id')
                ->references('id')
                ->on('kategori_komponen')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_komponen');
    }
};
