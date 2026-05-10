<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('informasi_pemasaran')) {
            Schema::create('informasi_pemasaran', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('knmp_id');
                $table->unsignedBigInteger('responden_id');

                $table->text('kendala_pemasaran_text')->nullable();
                $table->text('cara_penanganan_ikan')->nullable();

                $table->timestamps();

                // =========================
                // FOREIGN KEY
                // =========================
                $table->foreign('knmp_id')
                    ->references('id')
                    ->on('knmp')
                    ->onDelete('cascade');

                $table->foreign('responden_id')
                    ->references('id')
                    ->on('informasi_responden')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_pemasaran');
    }
};
