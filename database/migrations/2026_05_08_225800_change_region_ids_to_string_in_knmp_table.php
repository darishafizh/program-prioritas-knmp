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
        Schema::table('knmp', function (Blueprint $table) {
            $table->string('province_id')->nullable()->change();
            $table->string('regency_id')->nullable()->change();
            $table->string('district_id')->nullable()->change();
            $table->string('village_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable()->change();
            $table->unsignedBigInteger('regency_id')->nullable()->change();
            $table->unsignedBigInteger('district_id')->nullable()->change();
            $table->unsignedBigInteger('village_id')->nullable()->change();
        });
    }
};
