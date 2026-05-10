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
        if (Schema::hasColumn('informasi_pendapatan_rumah_tangga', 'kontribusi_nelayan_persen') && Schema::getColumnType('informasi_pendapatan_rumah_tangga', 'kontribusi_nelayan_persen') === 'int') {
            return;
        }
        // 1. Convert existing text data to scores using raw SQL
        
        // Q2: Kontribusi Nelayan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_nelayan_persen = '4' WHERE kontribusi_nelayan_persen LIKE '%100%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_nelayan_persen = '3' WHERE kontribusi_nelayan_persen LIKE '%Lebih dari 80%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_nelayan_persen = '2' WHERE kontribusi_nelayan_persen LIKE '%50-80%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_nelayan_persen = '1' WHERE kontribusi_nelayan_persen LIKE '%Kurang dari 50%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_nelayan_persen = NULL WHERE kontribusi_nelayan_persen NOT IN ('1','2','3','4')");

        // Q3: Jumlah Sumber Penghasilan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET jumlah_sumber_penghasilan = '4' WHERE jumlah_sumber_penghasilan LIKE '%Lebih dari 3%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET jumlah_sumber_penghasilan = '3' WHERE jumlah_sumber_penghasilan LIKE '%3 sumber%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET jumlah_sumber_penghasilan = '2' WHERE jumlah_sumber_penghasilan LIKE '%2 sumber%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET jumlah_sumber_penghasilan = '1' WHERE jumlah_sumber_penghasilan LIKE '%1 (hanya satu%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET jumlah_sumber_penghasilan = NULL WHERE jumlah_sumber_penghasilan NOT IN ('1','2','3','4')");

        // Q4: Ketergantungan Perikanan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET ketergantungan_perikanan = '4' WHERE ketergantungan_perikanan = 'Sangat bergantung'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET ketergantungan_perikanan = '3' WHERE ketergantungan_perikanan = 'Cukup bergantung'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET ketergantungan_perikanan = '2' WHERE ketergantungan_perikanan = 'Sedikit bergantung'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET ketergantungan_perikanan = '1' WHERE ketergantungan_perikanan = 'Tidak bergantung'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET ketergantungan_perikanan = NULL WHERE ketergantungan_perikanan NOT IN ('1','2','3','4')");


        // Q5: Stabilitas Pendapatan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET stabilitas_pendapatan = '4' WHERE stabilitas_pendapatan = 'Stabil sepanjang tahun'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET stabilitas_pendapatan = '3' WHERE stabilitas_pendapatan = 'Cenderung stabil'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET stabilitas_pendapatan = '2' WHERE stabilitas_pendapatan = 'Tidak stabil'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET stabilitas_pendapatan = '1' WHERE stabilitas_pendapatan = 'Sangat tidak stabil'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET stabilitas_pendapatan = NULL WHERE stabilitas_pendapatan NOT IN ('1','2','3','4')");

        // Q6: Keterlibatan Perempuan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET keterlibatan_perempuan = '4' WHERE keterlibatan_perempuan = 'Selalu'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET keterlibatan_perempuan = '3' WHERE keterlibatan_perempuan = 'Sering'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET keterlibatan_perempuan = '2' WHERE keterlibatan_perempuan = 'Jarang'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET keterlibatan_perempuan = '1' WHERE keterlibatan_perempuan = 'Tidak pernah'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET keterlibatan_perempuan = NULL WHERE keterlibatan_perempuan NOT IN ('1','2','3','4')");

        // Q7: Kontribusi Perempuan
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '5' WHERE kontribusi_perempuan_persen LIKE '%Lebih dari 75%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '4' WHERE kontribusi_perempuan_persen LIKE '%51%–75%'"); // Note: en-dash vs hyphen might be tricky, checking contains usually safer
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '4' WHERE kontribusi_perempuan_persen LIKE '51%-75%'"); // Safe check for hyphen
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '3' WHERE kontribusi_perempuan_persen LIKE '%25%–50%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '3' WHERE kontribusi_perempuan_persen LIKE '25%-50%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '2' WHERE kontribusi_perempuan_persen LIKE '%Kurang dari 25%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = '1' WHERE kontribusi_perempuan_persen LIKE '%tidak dilibatkan%'");
        DB::statement("UPDATE informasi_pendapatan_rumah_tangga SET kontribusi_perempuan_persen = NULL WHERE kontribusi_perempuan_persen NOT IN ('1','2','3','4','5')");


        // 2. Change column types to integer
        Schema::table('informasi_pendapatan_rumah_tangga', function (Blueprint $table) {
            $table->integer('kontribusi_nelayan_persen')->nullable()->change();
            $table->integer('jumlah_sumber_penghasilan')->nullable()->change();
            $table->integer('ketergantungan_perikanan')->nullable()->change();
            $table->integer('stabilitas_pendapatan')->nullable()->change();
            $table->integer('keterlibatan_perempuan')->nullable()->change();
            $table->integer('kontribusi_perempuan_persen')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pendapatan_rumah_tangga', function (Blueprint $table) {
            $table->string('kontribusi_nelayan_persen')->nullable()->change();
            $table->string('jumlah_sumber_penghasilan')->nullable()->change();
            $table->string('ketergantungan_perikanan')->nullable()->change();
            $table->string('stabilitas_pendapatan')->nullable()->change();
            $table->string('keterlibatan_perempuan')->nullable()->change();
            $table->string('kontribusi_perempuan_persen')->nullable()->change();
        });
    }
};
