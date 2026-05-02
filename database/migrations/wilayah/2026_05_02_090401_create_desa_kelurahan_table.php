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
        Schema::create('desa_kelurahan', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('kecamatan_id', 15);
            $table->string('nama', 150);
            $table->timestamps();
 
            $table->foreign('kecamatan_id')
                  ->references('id')
                  ->on('kecamatan')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa_kelurahan');
    }
};
