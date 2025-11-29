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
        Schema::create('inf_umum_responden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->unique()->constrained('knmp')->cascadeOnDelete();
            $table->string('nama_responden', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('desa_kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten', 100);
            $table->string('provinsi', 100);
            $table->string('status_responden', 100)->nullable();
            $table->string('jenis_program', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inf_umum_responden');
    }
};
