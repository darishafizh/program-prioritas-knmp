<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpVillagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['knmp_district_id' => '1', 'name' => 'Lhok Pawoh', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '2', 'name' => 'Lancok', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '3', 'name' => 'Kuala Raja', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '4', 'name' => 'Birem Putong', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '5', 'name' => 'Merpas', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '6', 'name' => 'Penago I', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '7', 'name' => 'Sungsang IV', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '8', 'name' => 'Sukorahayu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '9', 'name' => 'Ketapang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '10', 'name' => 'Bandar Agung', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '11', 'name' => 'Margasari', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '12', 'name' => 'Sembulang (Tanjung Banun)', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '13', 'name' => 'Kelurahan Sekanak Raya', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '14', 'name' => 'Kelurahan Kasu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '15', 'name' => 'Katapiang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '16', 'name' => 'Kelurahan Padang Sarai', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '17', 'name' => 'Wanasari', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '18', 'name' => 'Karangsari', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '19', 'name' => 'Gebang Mekar', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '20', 'name' => 'Karangjaladri', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '21', 'name' => 'Cikeusik', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '22', 'name' => 'Desa Ciwaru', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '23', 'name' => 'Poncosari', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '24', 'name' => 'Banyutowo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '25', 'name' => 'Kertojayan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '26', 'name' => 'Jatimalang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '27', 'name' => 'Bumiharjo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '28', 'name' => 'Karangduwur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '29', 'name' => 'Bulumeduro', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '30', 'name' => 'Pujiharjo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '31', 'name' => 'Dapenda', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '32', 'name' => 'Lateng', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '33', 'name' => 'Bilelando', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '34', 'name' => 'Ekas Buana', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '35', 'name' => 'Pulau Bungin', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '36', 'name' => 'Seraya Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '37', 'name' => 'Warloka Pesisir', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '38', 'name' => 'Mudakeputu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '39', 'name' => 'Adang ', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '40', 'name' => 'Sulamu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '41', 'name' => 'Tanjung Putri', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '42', 'name' => 'Sungai Nyirih', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '43', 'name' => 'Ujung Said', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '44', 'name' => 'Babana', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '45', 'name' => 'Sumare', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '46', 'name' => 'Angkue', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '47', 'name' => 'Tongke - Tongke', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '48', 'name' => 'Bentenge', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '49', 'name' => 'Untia', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '50', 'name' => 'Balangloe Tarowang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '51', 'name' => 'Aeng Batu-Batu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '52', 'name' => 'Banagan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '53', 'name' => 'Letao Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '54', 'name' => 'Terapung', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '55', 'name' => 'Gerak Makmur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '56', 'name' => 'Anaiwoi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '57', 'name' => 'Sorue Jaya', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '58', 'name' => 'Malalanda', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '59', 'name' => 'Supu', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '60', 'name' => 'Sangowo Timur', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '61', 'name' => 'Wasileo', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '62', 'name' => 'Labetawi', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '63', 'name' => 'Waelihang', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '64', 'name' => 'Warmasen', 'created_at' => now(), 'updated_at' => now()],
            ['knmp_district_id' => '65', 'name' => 'Samkai', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('knmp_villages')->insert($data);
    }
}
