<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('progres_kendala')) {
            return;
        }

        Schema::create('progres_kendala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('progres_id');
            $table->unsignedBigInteger('kendala_id');
            $table->timestamps();

            $table->foreign('progres_id')
                ->references('id')
                ->on('progres_pembangunan_knmp')
                ->onDelete('cascade');

            $table->foreign('kendala_id')
                ->references('id')
                ->on('kendala_master')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_kendala');
    }
};
