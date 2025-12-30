<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['knmp_regency_id' => '1', 'name' => 'Manggeng', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '2', 'name' => 'Syamtalira Bayu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '3', 'name' => 'Kuala', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '4', 'name' => 'Langsa Baro', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '5', 'name' => 'Nasal', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '6', 'name' => 'Ilir Talo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '7', 'name' => 'Banyuasin II', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '8', 'name' => 'Labuhan Maringgai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '9', 'name' => 'Ketapang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '10', 'name' => 'Sragi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '11', 'name' => 'Labuhan Maringgai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '12', 'name' => 'Galang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '13', 'name' => 'Belakang Padang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '14', 'name' => 'Belakang Padang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '15', 'name' => 'Batang Anai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '16', 'name' => 'Koto Tangah', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '17', 'name' => 'Agrabinta', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '18', 'name' => 'Pakenjeng', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '19', 'name' => 'Gebang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '20', 'name' => 'Parigi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '21', 'name' => 'Pandeglang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '22', 'name' => 'Ciemas', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '23', 'name' => 'Srandakan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '24', 'name' => 'Dukuh Seti', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '25', 'name' => 'Grabag', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '26', 'name' => 'Purworejo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '27', 'name' => 'Keling', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '28', 'name' => 'Ayah', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '29', 'name' => 'Bancar', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '30', 'name' => 'Tirtoyudo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '31', 'name' => 'Batang-Batang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '32', 'name' => 'Banyuwangi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '33', 'name' => 'Praya Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '34', 'name' => 'Jerowaru', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '35', 'name' => 'Alas', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '36', 'name' => 'Karangasem', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '37', 'name' => 'Komodo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '38', 'name' => 'Ile Mandiri', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '39', 'name' => 'Alor Barat ', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '40', 'name' => 'Sulamu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '41', 'name' => 'Arut Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '42', 'name' => 'Selakau', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '43', 'name' => 'Jongkong', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '44', 'name' => 'Budong-Budong', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '45', 'name' => 'Mamuju', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '46', 'name' => 'Kajuara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '47', 'name' => 'Sinjai Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '48', 'name' => 'Ujung Bulu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '49', 'name' => 'Biringkanaya', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '50', 'name' => 'Jeneponto', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '51', 'name' => 'Galesong Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '52', 'name' => 'Dampal Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '53', 'name' => 'Dumbo Raya', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '54', 'name' => 'Poleang Tenggara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '55', 'name' => 'Sampolawa', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '56', 'name' => 'Tanggetada', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '57', 'name' => 'Soropia', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '58', 'name' => 'Kulisusu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '59', 'name' => 'Loloda Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '60', 'name' => 'Morotai Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '61', 'name' => 'Maba Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '62', 'name' => 'Pulau Dullah Utara', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '63', 'name' => 'Waplau', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '64', 'name' => 'Kota Waisai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_regency_id' => '65', 'name' => 'Merauke', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('knmp_districts')->insert($data);
    }
}
