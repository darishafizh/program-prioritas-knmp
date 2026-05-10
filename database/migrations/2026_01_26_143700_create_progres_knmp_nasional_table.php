<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('progres_knmp_nasional')) {
            Schema::create('progres_knmp_nasional', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('knmp_id')->unique();
                $table->decimal('progres', 5, 2)->default(0);
                $table->timestamps();

                $table->foreign('knmp_id')
                    ->references('id')
                    ->on('knmp')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_knmp_nasional');
    }
};
