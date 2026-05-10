<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- WAJIB

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('kendala_master')) {
            Schema::create('kendala_master', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->timestamps();
            });

            DB::table('kendala_master')->insert([
                ['nama' => 'Faktor cuaca'],
                ['nama' => 'Ketersediaan tenaga kerja'],
                ['nama' => 'Ketersediaan material bahan bangunan'],
                ['nama' => 'Akses ke lokasi (jalan kurang memadai)'],
                ['nama' => 'Ketersediaan listrik'],
                ['nama' => 'Ketersediaan BBM'],
                ['nama' => 'Ketersediaan air bersih'],
                ['nama' => 'Jaringan internet'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kendala_master');
    }
};
