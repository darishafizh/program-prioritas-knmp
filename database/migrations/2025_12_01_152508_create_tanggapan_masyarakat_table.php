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
            $table->foreignId('knmp_id')->constrained('knmp')->onDelete('cascade');
            $table->boolean('kesesuaian_kebutuhan');
            $table->text('item_tidak_sesuai')->nullable();
            $table->string('tingkat_kesenangan', 50);
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
