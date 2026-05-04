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
        Schema::create('time_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp')->cascadeOnDelete();
        $table->date('tanggal');
        $table->decimal('bobot_kumulatif_rencana', 8, 4)->default(0);
        $table->decimal('bobot_kumulatif_realisasi', 8, 4)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_schedule');
    }
};
