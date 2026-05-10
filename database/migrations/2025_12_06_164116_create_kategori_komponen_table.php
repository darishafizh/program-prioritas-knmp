<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- WAJIB

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('kategori_komponen')) {
            Schema::create('kategori_komponen', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('kategori');
                $table->timestamps();
            });

            // Insert default kategori
            DB::table('kategori_komponen')->insert([
                ['nama' => 'Tambatan Perahu / Dermaga', 'kategori' => 'Konstruksi'],
                ['nama' => 'Shelter pendaratan ikan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Bengkel / Docking kapal nelayan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Kantor pengelola', 'kategori' => 'Konstruksi'],
                ['nama' => 'Sentra kuliner produk perikanan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Balai Pertemuan Nelayan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Shelter perbaikan jaring', 'kategori' => 'Konstruksi'],
                ['nama' => 'Shelter Cool Box', 'kategori' => 'Konstruksi'],
                ['nama' => 'Bangunan Tapak Cold Storage', 'kategori' => 'Konstruksi'],
                ['nama' => 'Miniplan pengolahan ikan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Kios perbekalan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Tempat pembuangan sampah dan IPAL', 'kategori' => 'Konstruksi'],
                ['nama' => 'Musholla', 'kategori' => 'Konstruksi'],
                ['nama' => 'Sarana toilet umum', 'kategori' => 'Konstruksi'],
                ['nama' => 'Jalan di kawasan lahan pembangunan', 'kategori' => 'Konstruksi'],
                ['nama' => 'Penerangan umum', 'kategori' => 'Konstruksi'],
                ['nama' => 'Pagar, gapura, dan/atau landmark', 'kategori' => 'Konstruksi'],
                ['nama' => 'Parkir', 'kategori' => 'Konstruksi'],
                ['nama' => 'Talud / Revetment Sungai dan Laut', 'kategori' => 'Konstruksi'],

                ['nama' => 'Kapal penangkap ikan', 'kategori' => 'Bantuan Kapal Mesin API'],
                ['nama' => 'Mesin kapal perikanan', 'kategori' => 'Bantuan Kapal Mesin API'],
                ['nama' => 'Alat Penangkap Ikan', 'kategori' => 'Bantuan Kapal Mesin API'],

                ['nama' => 'Cold Storage', 'kategori' => 'Bantuan Sarana Rantai Dingin'],
                ['nama' => 'Pabrik Es Balok', 'kategori' => 'Bantuan Sarana Rantai Dingin'],
                ['nama' => 'Pabrik Es Slurry', 'kategori' => 'Bantuan Sarana Rantai Dingin'],
                ['nama' => 'Kendaraan Berpendingin', 'kategori' => 'Bantuan Sarana Rantai Dingin'],
                ['nama' => 'Cool Box', 'kategori' => 'Bantuan Sarana Rantai Dingin'],

                ['nama' => 'SPBU Nelayan', 'kategori' => 'SPBU Nelayan'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_komponen');
    }
};
