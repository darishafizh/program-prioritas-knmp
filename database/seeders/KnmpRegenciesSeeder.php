<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpRegenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['knmp_province_id' => '1', 'name' => 'Aceh Barat Daya', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '1', 'name' => 'Aceh Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '1', 'name' => 'Bireun', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '1', 'name' => 'Langsa', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '2', 'name' => 'Kaur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '2', 'name' => 'Selumu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '3', 'name' => 'Banyuasin', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '4', 'name' => 'Lampung Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '4', 'name' => 'Lampung Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '4', 'name' => 'Lampung Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '4', 'name' => 'Lampung Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '5', 'name' => 'Batam', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '5', 'name' => 'Batam', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '5', 'name' => 'Batam', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '6', 'name' => 'Padang Pariaman', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '6', 'name' => 'Padang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Cianjur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Garut', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Cirebon', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Pangandaran', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Banten', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '7', 'name' => 'Sukabumi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '8', 'name' => 'Bantul', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Pati', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Purworejo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Purworejo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Jepara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Kebumen', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '9', 'name' => 'Tuban', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '10', 'name' => 'Malang ', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '10', 'name' => 'Sumenep', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '10', 'name' => 'Banyuwangi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '11', 'name' => 'Lombok Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '11', 'name' => 'Lombok Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '11', 'name' => 'Sumbawa', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '12', 'name' => 'Karangasem', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '13', 'name' => 'Manggarai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '13', 'name' => 'Flores Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '13', 'name' => 'Alor', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '13', 'name' => 'Kupang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '14', 'name' => 'Kotawaringin', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '15', 'name' => 'Sambas', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '15', 'name' => 'Kapuas Hulu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '16', 'name' => 'Mamuju Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '16', 'name' => 'Mamuju Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Bone', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Sinjai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Bulukumba', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Makassar', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Jeneponto', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Takalar', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '17', 'name' => 'Toli-Toli', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '18', 'name' => 'Gorontalo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '19', 'name' => 'Bombana', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '19', 'name' => 'Buton Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '19', 'name' => 'Kolaka', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '19', 'name' => 'Konawe', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '19', 'name' => 'Buton Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '20', 'name' => 'Halmahera Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '20', 'name' => 'Pulau Morotai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '20', 'name' => 'Halmahera Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '21', 'name' => 'Kota Tual', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '21', 'name' => 'Buru', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '22', 'name' => 'Raja Ampat', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_province_id' => '23', 'name' => 'Merauke', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('knmp_regencies')->insert($data);
    }
}
