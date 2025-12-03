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
        Schema::create('tenaga_kerja_knmp', function (Blueprint $table) {
            $table->id();
            // Relasi One-to-One ke profile_knmp
            $table->foreignId('knmp_id')->unique()->constrained('profile_knmp')->onDelete('cascade');

            // Data Tenaga Kerja Konstruksi
            $table->integer('tk_total_konstruksi')->nullable();
            $table->integer('tk_laki_laki_konstruksi')->nullable();
            $table->integer('tk_perempuan_konstruksi')->nullable();

            // Upah, Lama Kerja
            $table->bigInteger('upah_tenaga_kerja_per_hari')->nullable();
            $table->integer('lama_kerja_proyek_hari')->nullable();

            // Tenaga Kerja Lokal vs Luar
            $table->integer('tk_jumlah_lokal')->nullable();
            $table->integer('tk_jumlah_luar')->nullable();

            // Tenaga Kerja Non Konstruksi
            $table->integer('tk_non_konstruksi_jumlah')->nullable();
            $table->string('tk_non_konstruksi_jenis', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerja_knmp');
    }
};
