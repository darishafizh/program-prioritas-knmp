<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tabel yang tidak digunakan:
     * - kendala: Model Kendala menggunakan tabel 'kendala_knmp', bukan 'kendala'
     * - password_reset_tokens: Fitur forgot password sudah dihapus
     * - progres_tambahan: Orphan, model ProgresTambahan menggunakan 'progress_tambahan'
     */
    public function up(): void
    {
        Schema::dropIfExists('kendala');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('progres_tambahan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate kendala table
        Schema::create('kendala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->nullable();
            $table->string('kendala')->nullable();
            $table->timestamps();
        });

        // Recreate password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Recreate progres_tambahan table
        Schema::create('progres_tambahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->nullable();
            $table->boolean('cctv_terpasang')->default(false);
            $table->timestamps();
        });
    }
};
