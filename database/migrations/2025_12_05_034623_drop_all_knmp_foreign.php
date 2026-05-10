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
        // Drop semua FK jika ada satu per satu agar bisa di-catch
        try {
            Schema::table('knmp', function (Blueprint $table) {
                $table->dropForeign(['province_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('knmp', function (Blueprint $table) {
                $table->dropForeign(['regency_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('knmp', function (Blueprint $table) {
                $table->dropForeign(['district_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('knmp', function (Blueprint $table) {
                $table->dropForeign(['village_id']);
            });
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {

            // Tambahkan kembali FK jika rollback
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
        });
    }
};
