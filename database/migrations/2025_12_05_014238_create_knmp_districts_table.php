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
        Schema::create('knmp_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_regency_id')->constrained('knmp_regencies')->cascadeOnDelete();
            $table->string('name', 100);
            $table->timestamps();

            $table->index('knmp_regency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knmp_districts');
    }
};
