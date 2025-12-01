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
        Schema::create('keterangan_enumerator', function (Blueprint $table) {
            $table->id();
            $table->string('nama_enumerator');             // Nama Enumerator
            $table->date('tanggal_wawancara')->nullable(); // Tanggal Wawancara
            $table->date('tanggal_editing')->nullable();   // Tanggal Editing
            $table->string('nama_pemvalidasi')->nullable(); // Nama Pemvalidasi
            $table->timestamps();                          // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangan_enumerator');
    }
};
