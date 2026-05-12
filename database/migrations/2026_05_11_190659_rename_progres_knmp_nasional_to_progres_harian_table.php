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
        Schema::dropIfExists('progres_harian');
        Schema::rename('progres_knmp_nasional', 'progres_harian');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('progres_harian', 'progres_knmp_nasional');
    }
};
