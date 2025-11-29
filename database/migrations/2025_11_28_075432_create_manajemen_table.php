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
        Schema::create('manajemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp')->cascadeOnDelete();
            $table->text('mitra_pengelolaan_aset')->nullable();
            $table->decimal('kebutuhan_anggaran', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen');
    }
};
