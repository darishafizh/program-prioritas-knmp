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
        if (!Schema::hasTable('informasi_usaha_ikan')) {
            Schema::create('informasi_usaha_ikan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('informasi_usaha_id');
                $table->foreign('informasi_usaha_id')->references('id')->on('informasi_usaha')->onDelete('cascade');

                $table->string('jenis')->nullable();
                $table->float('kg_trip')->nullable();
                $table->float('persen')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_usaha_ikan');
    }
};
