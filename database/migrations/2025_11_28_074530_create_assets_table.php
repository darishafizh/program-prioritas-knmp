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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp')->cascadeOnDelete();
            $table->string('jenis_aset', 100);
            $table->string('sumber_pengadaan', 50)->nullable();
            $table->string('ukuran_kapasitas', 50)->nullable();
            $table->integer('jumlah')->nullable();
            $table->char('status_aset', 1)->nullable(); // Kode: 1=Mangkrak, 2=Rusak, 3=Baik
            $table->integer('bantuan_knmp')->nullable();
            $table->integer('total_aset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
