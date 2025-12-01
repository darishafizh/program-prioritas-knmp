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
        Schema::create('progres_tambahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp')->onDelete('cascade');
            $table->boolean('cctv_terpasang')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_tambahan');
    }
};
