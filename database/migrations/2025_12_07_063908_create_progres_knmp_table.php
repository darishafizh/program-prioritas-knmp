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
        if (!Schema::hasTable('progres_knmp')) {
            Schema::create('progres_knmp', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('knmp_id')->nullable();

                $table->bigInteger('anggaran_total')->nullable();
                $table->bigInteger('anggaran_konstruksi')->nullable();
                $table->bigInteger('anggaran_sarpras')->nullable();

                $table->integer('tk_total')->nullable();
                $table->integer('tk_laki')->nullable();
                $table->integer('tk_perempuan')->nullable();
                $table->integer('tk_upah')->nullable();
                $table->integer('tk_durasi')->nullable();
                $table->integer('tk_lokal')->nullable();
                $table->integer('tk_luar')->nullable();
                $table->integer('tk_non_konstruksi_jumlah')->nullable();
                $table->string('tk_non_konstruksi_ket')->nullable();

                $table->json('kendala')->nullable();

                $table->enum('cctv', ['Ya', 'Tidak'])->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_knmp');
    }
};
