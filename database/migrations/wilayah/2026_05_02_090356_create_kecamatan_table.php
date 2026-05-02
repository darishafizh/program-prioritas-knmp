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
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('kabupaten_kota_id', 10);
            $table->string('nama', 150);
            $table->timestamps();
 
            $table->foreign('kabupaten_kota_id')
                  ->references('id')
                  ->on('kabupaten_kota')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
