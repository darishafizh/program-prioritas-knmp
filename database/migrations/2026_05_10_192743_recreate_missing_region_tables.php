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
        if (!Schema::hasTable('provinces')) {
            Schema::create('provinces', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 100);
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('regencies')) {
            Schema::create('regencies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('provinsi_id');
                $table->string('nama', 100);
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('districts')) {
            Schema::create('districts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kabupaten_kota_id');
                $table->string('nama', 100);
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('villages')) {
            Schema::create('villages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kecamatan_id');
                $table->string('nama', 100);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
    }
};
