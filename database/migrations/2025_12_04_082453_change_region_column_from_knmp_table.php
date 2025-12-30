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
            if (Schema::hasColumn('knmp', 'province')) {
                $table->dropColumn('province');
            }
            if (Schema::hasColumn('knmp', 'kabupaten')) {
                $table->dropColumn('kabupaten');
            }
            if (Schema::hasColumn('knmp', 'kecamatan')) {
                $table->dropColumn('kecamatan');
            }
            if (Schema::hasColumn('knmp', 'desa')) {
                $table->dropColumn('desa');
            }

            // Tambah kolom baru CHAR (sesuai standard kode Kemendagri)
            $table->char('province_id', 2)->nullable()->index();
            $table->char('regency_id', 4)->nullable()->index();
            $table->char('district_id', 7)->nullable()->index();
            $table->char('village_id', 10)->nullable()->index();

            // Tambahkan Foreign Key
            $table->foreign('province_id')
                ->references('id')->on('provinces')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('regency_id')
                ->references('id')->on('regencies')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('district_id')
                ->references('id')->on('districts')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('village_id')
                ->references('id')->on('villages')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knmp', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['regency_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['village_id']);

            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id']);

            // Optional restore kolom lama
            $table->string('province')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
        });
    }
};
