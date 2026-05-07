<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timeline_pengerjaan', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('knmp_id')
                ->constrained('knmp')
                ->onDelete('cascade');
            $table->integer('periode_mingguan');
            $table->float('bobot_rencana_kumulatif')->nullable();
            $table->float('bobot_realisasi_kumulatif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_pengerjaan');
    }
};
