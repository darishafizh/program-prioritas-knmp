<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilKnmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jml_penduduk_des' => 1500,
                'jml_nelayan' => 350,
                'pendapatan_rata_rata_nelayan' => 2500000,
                'alokasi_anggaran_total' => 5000000000,
                'anggaran_konstruksi' => 3500000000,
                'anggaran_upah_kerja' => 500000000,
                'tenaga_kerja_laki_laki' => 55,
                'tenaga_kerja_perempuan' => 10,
                'tenaga_kerja_lokal' => 45,
                'tenaga_kerja_luar' => 20,
                'volume_produksi_ton' => 850,
                'nilai_produksi' => 18000000000.00,
                'koordinat_lokasi' => '-6.2000, 106.8167',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jml_penduduk_des' => 800,
                'jml_nelayan' => 200,
                'pendapatan_rata_rata_nelayan' => 1800000,
                'alokasi_anggaran_total' => 3000000000,
                'anggaran_konstruksi' => 2200000000,
                'anggaran_upah_kerja' => 300000000,
                'tenaga_kerja_laki_laki' => 40,
                'tenaga_kerja_perempuan' => 5,
                'tenaga_kerja_lokal' => 35,
                'tenaga_kerja_luar' => 10,
                'volume_produksi_ton' => 600,
                'nilai_produksi' => 12500000000.00,
                'koordinat_lokasi' => '-7.2575, 112.7521',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jml_penduduk_des' => 2200,
                'jml_nelayan' => 500,
                'pendapatan_rata_rata_nelayan' => 3200000,
                'alokasi_anggaran_total' => 7500000000,
                'anggaran_konstruksi' => 5000000000,
                'anggaran_upah_kerja' => 1000000000,
                'tenaga_kerja_laki_laki' => 80,
                'tenaga_kerja_perempuan' => 15,
                'tenaga_kerja_lokal' => 70,
                'tenaga_kerja_luar' => 25,
                'volume_produksi_ton' => 1200,
                'nilai_produksi' => 25000000000.00,
                'koordinat_lokasi' => '3.5951, 98.6775',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('profile_knmp')->insert($data);
    }
}
