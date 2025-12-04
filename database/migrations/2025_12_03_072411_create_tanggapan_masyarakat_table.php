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
        Schema::create('tanggapan_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knmp_id');
            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');

            $table->boolean('kesesuaian_kebutuhan')->nullable();
            $table->text('item_tidak_sesuai')->nullable();
            $table->string('tingkat_kesenangan')->nullable();
            $table->text('alasan_tidak_senang')->nullable();
            $table->text('harapan_masyarakat')->nullable();
            $table->text('masukan_saran_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_masyarakat');
    }
};
