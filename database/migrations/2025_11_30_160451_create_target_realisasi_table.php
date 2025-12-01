<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('target_realisasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_knmp');
            $table->string('ppk');
            $table->string('kontraktor');
            $table->integer('target_fisik');
            $table->integer('realisasi_fisik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_realisasi');
    }
};
