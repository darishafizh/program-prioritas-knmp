<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Drop FK knmp_id safely
        try {
            Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
                $table->dropForeign(['knmp_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
            // 2. TAMBAH responden_id jika belum ada
            if (!Schema::hasColumn('tingkat_kebahagiaan_nelayan', 'responden_id')) {
                $table->unsignedBigInteger('responden_id')
                    ->nullable()
                    ->after('knmp_id');
            }
        });

        // 3. FK responden_id safely
        try {
            Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
                $table->foreign('responden_id')
                    ->references('id')
                    ->on('informasi_responden')
                    ->cascadeOnDelete();
            });
        } catch (\Exception $e) {}

        // 4. DROP UNIQUE LAMA safely
        try {
            Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
                $table->dropUnique('tingkat_kebahagiaan_nelayan_knmp_id_nomor_soal_unique');
            });
        } catch (\Exception $e) {}

        // 5. BUAT UNIQUE BARU safely
        try {
            Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
                $table->unique(
                    ['knmp_id', 'responden_id', 'nomor_soal'],
                    'tkb_knmp_responden_soal_unique'
                );
            });
        } catch (\Exception $e) {}

        // 6. PASANG KEMBALI FK knmp_id safely
        try {
            Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {
                $table->foreign('knmp_id')
                    ->references('id')
                    ->on('knmp')
                    ->cascadeOnDelete();
            });
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
        Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {

            /**
             * 1️⃣ DROP FK knmp_id & responden_id
             */
            $table->dropForeign(['knmp_id']);
            $table->dropForeign(['responden_id']);

            /**
             * 2️⃣ DROP UNIQUE BARU
             */
            $table->dropUnique('tkb_knmp_responden_soal_unique');

            /**
             * 3️⃣ KEMBALIKAN UNIQUE LAMA
             */
            $table->unique(
                ['knmp_id', 'nomor_soal'],
                'tingkat_kebahagiaan_nelayan_knmp_id_nomor_soal_unique'
            );

            /**
             * 4️⃣ HAPUS kolom responden_id
             */
            $table->dropColumn('responden_id');

            /**
             * 5️⃣ PASANG LAGI FK knmp_id
             */
            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->cascadeOnDelete();
        });
    }
};
