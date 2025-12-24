<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tingkat_kebahagiaan_nelayan', function (Blueprint $table) {

            /**
             * 1️⃣ DROP FK knmp_id TERLEBIH DAHULU
             * karena unique lama dipakai oleh FK
             */
            $table->dropForeign(['knmp_id']);

            /**
             * 2️⃣ TAMBAH responden_id (nullable untuk data lama)
             */
            if (!Schema::hasColumn('tingkat_kebahagiaan_nelayan', 'responden_id')) {
                $table->unsignedBigInteger('responden_id')
                    ->nullable()
                    ->after('knmp_id');
            }

            /**
             * 3️⃣ FK responden_id
             */
            $table->foreign('responden_id')
                ->references('id')
                ->on('informasi_responden')
                ->cascadeOnDelete();

            /**
             * 4️⃣ DROP UNIQUE LAMA (SEKARANG AMAN)
             */
            $table->dropUnique('tingkat_kebahagiaan_nelayan_knmp_id_nomor_soal_unique');

            /**
             * 5️⃣ BUAT UNIQUE BARU (BENAR)
             */
            $table->unique(
                ['knmp_id', 'responden_id', 'nomor_soal'],
                'tkb_knmp_responden_soal_unique'
            );

            /**
             * 6️⃣ PASANG KEMBALI FK knmp_id
             */
            $table->foreign('knmp_id')
                ->references('id')
                ->on('knmp')
                ->cascadeOnDelete();
        });
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
