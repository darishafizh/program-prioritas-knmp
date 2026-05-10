<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if already converted to integer to avoid errors
        if (Schema::hasColumn('sosial_kelembagaan', 'manfaat_kelompok') && Schema::getColumnType('sosial_kelembagaan', 'manfaat_kelompok') === 'int') {
            return;
        }
        // 1. Convert existing text data to scores using raw SQL
        // Q1: Anggota Kelompok
        DB::statement("UPDATE sosial_kelembagaan SET anggota_kelompok = '4' WHERE anggota_kelompok LIKE '%Ya, sangat aktif%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_kelompok = '3' WHERE anggota_kelompok LIKE '%Ya, tidak aktif%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_kelompok = '2' WHERE anggota_kelompok LIKE '%Tidak pernah bergabung%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_kelompok = '1' WHERE anggota_kelompok LIKE '%Tidak ada%'");

        // Q2: Manfaat Kelompok
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = '5' WHERE manfaat_kelompok = 'Sangat Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = '4' WHERE manfaat_kelompok = 'Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = '3' WHERE manfaat_kelompok = 'Cukup Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = '2' WHERE manfaat_kelompok = 'Kurang Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = '1' WHERE manfaat_kelompok = 'Tidak Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_kelompok = NULL WHERE manfaat_kelompok NOT IN ('1','2','3','4','5')");

        // Q3: Anggota Koperasi
        DB::statement("UPDATE sosial_kelembagaan SET anggota_koperasi = '4' WHERE anggota_koperasi LIKE '%Ya, sangat aktif%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_koperasi = '3' WHERE anggota_koperasi LIKE '%Ya, tidak aktif%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_koperasi = '2' WHERE anggota_koperasi LIKE '%Tidak pernah bergabung%'");
        DB::statement("UPDATE sosial_kelembagaan SET anggota_koperasi = '1' WHERE anggota_koperasi LIKE '%Tidak ada%'");

        // Q4: Tertarik Koperasi
        DB::statement("UPDATE sosial_kelembagaan SET tertarik_koperasi = '1' WHERE tertarik_koperasi = 'Sangat tidak tertarik'");
        DB::statement("UPDATE sosial_kelembagaan SET tertarik_koperasi = '2' WHERE tertarik_koperasi = 'Tidak tertarik'");
        DB::statement("UPDATE sosial_kelembagaan SET tertarik_koperasi = '3' WHERE tertarik_koperasi = 'Tertarik'");
        DB::statement("UPDATE sosial_kelembagaan SET tertarik_koperasi = '4' WHERE tertarik_koperasi = 'Sudah menjadi anggota'");
        DB::statement("UPDATE sosial_kelembagaan SET tertarik_koperasi = NULL WHERE tertarik_koperasi NOT IN ('1','2','3','4')");


        // Q5: Manfaat Koperasi
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = '5' WHERE manfaat_koperasi = 'Sangat Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = '4' WHERE manfaat_koperasi = 'Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = '3' WHERE manfaat_koperasi = 'Cukup Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = '2' WHERE manfaat_koperasi = 'Kurang Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = '1' WHERE manfaat_koperasi = 'Tidak Setuju'");
        DB::statement("UPDATE sosial_kelembagaan SET manfaat_koperasi = NULL WHERE manfaat_koperasi NOT IN ('1','2','3','4','5')");

        // Q6: Sub-questions (Ya=1, Tidak=0)
        $subQuestions = [
            'koperasi_rapat_tahunan',
            'koperasi_partisipasi_aktif',
            'koperasi_pengurus_kompeten',
            'koperasi_transparan',
            'koperasi_keuangan_sehat',
            'koperasi_jaringan_pasar',
            'koperasi_kepercayaan_usaha'
        ];

        foreach ($subQuestions as $col) {
            DB::statement("UPDATE sosial_kelembagaan SET {$col} = '1' WHERE {$col} = 'Ya'");
            DB::statement("UPDATE sosial_kelembagaan SET {$col} = '0' WHERE {$col} = 'Tidak'");
            DB::statement("UPDATE sosial_kelembagaan SET {$col} = NULL WHERE {$col} NOT IN ('0','1')");
        }

        // 2. Change column types to integer
        Schema::table('sosial_kelembagaan', function (Blueprint $table) {
            $table->integer('anggota_kelompok')->nullable()->change();
            $table->integer('manfaat_kelompok')->nullable()->change();
            $table->integer('anggota_koperasi')->nullable()->change();
            $table->integer('tertarik_koperasi')->nullable()->change();
            $table->integer('manfaat_koperasi')->nullable()->change();
            
            $table->integer('koperasi_rapat_tahunan')->nullable()->change();
            $table->integer('koperasi_partisipasi_aktif')->nullable()->change();
            $table->integer('koperasi_pengurus_kompeten')->nullable()->change();
            $table->integer('koperasi_transparan')->nullable()->change();
            $table->integer('koperasi_keuangan_sehat')->nullable()->change();
            $table->integer('koperasi_jaringan_pasar')->nullable()->change();
            $table->integer('koperasi_kepercayaan_usaha')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sosial_kelembagaan', function (Blueprint $table) {
            $table->string('anggota_kelompok')->nullable()->change();
            $table->string('manfaat_kelompok')->nullable()->change();
            $table->string('anggota_koperasi')->nullable()->change();
            $table->string('tertarik_koperasi')->nullable()->change();
            $table->string('manfaat_koperasi')->nullable()->change();
            
            $table->string('koperasi_rapat_tahunan')->nullable()->change();
            $table->string('koperasi_partisipasi_aktif')->nullable()->change();
            $table->string('koperasi_pengurus_kompeten')->nullable()->change();
            $table->string('koperasi_transparan')->nullable()->change();
            $table->string('koperasi_keuangan_sehat')->nullable()->change();
            $table->string('koperasi_jaringan_pasar')->nullable()->change();
            $table->string('koperasi_kepercayaan_usaha')->nullable()->change();
        });
    }
};
