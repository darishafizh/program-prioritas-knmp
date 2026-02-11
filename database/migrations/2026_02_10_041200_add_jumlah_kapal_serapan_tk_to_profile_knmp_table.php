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
        Schema::table('profile_knmp', function (Blueprint $table) {
            $table->integer('jumlah_kapal')->nullable();
            $table->integer('serapan_tenaga_kerja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_knmp', function (Blueprint $table) {
            $table->dropColumn(['jumlah_kapal', 'serapan_tenaga_kerja']);
        });
    }
};
