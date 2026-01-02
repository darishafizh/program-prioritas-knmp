<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Aceh
            ['nama' => 'KNMP Desa Lhok Pawoh', 'desa' => 'Lhok Pawoh', 'kecamatan' => 'Manggeng', 'kabupaten' => 'Aceh Barat Daya', 'provinsi' => 'Aceh', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Lancok', 'desa' => 'Lancok', 'kecamatan' => 'Syamtalira', 'kabupaten' => 'Aceh Utara', 'provinsi' => 'Aceh', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Kuala Raja', 'desa' => 'Kuala Raja', 'kecamatan' => 'Kuala', 'kabupaten' => 'Bireun', 'provinsi' => 'Aceh', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Birem Putong', 'desa' => 'Birem Putong', 'kecamatan' => 'Langsa Baro', 'kabupaten' => 'Langsa', 'provinsi' => 'Aceh', 'created_at' => now(), 'updated_at' => now()],

            // Bengkulu
            ['nama' => 'KNMP Desa Merpas', 'desa' => 'Merpas', 'kecamatan' => 'Nasal', 'kabupaten' => 'Kaur', 'provinsi' => 'Bengkulu', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Penago I', 'desa' => 'Penago I', 'kecamatan' => 'Ilir Talo', 'kabupaten' => 'Seluma', 'provinsi' => 'Bengkulu', 'created_at' => now(), 'updated_at' => now()],

            // Sumatera Selatan
            ['nama' => 'KNMP Desa Sungsang IV', 'desa' => 'Sungsang IV', 'kecamatan' => 'Banyuasin II', 'kabupaten' => 'Banyuasin', 'provinsi' => 'Sumatera Selatan', 'created_at' => now(), 'updated_at' => now()],

            // Lampung
            ['nama' => 'KNMP Desa Sukorahayu', 'desa' => 'Sukorahayu', 'kecamatan' => 'Labuhan Maringgai', 'kabupaten' => 'Lampung Timur', 'provinsi' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Ketapang', 'desa' => 'Ketapang', 'kecamatan' => 'Ketapang', 'kabupaten' => 'Lampung Selatan', 'provinsi' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Bandar Agung', 'desa' => 'Bandar Agung', 'kecamatan' => 'Sragi', 'kabupaten' => 'Lampung Selatan', 'provinsi' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Margasari', 'desa' => 'Margasari', 'kecamatan' => 'Labuhan Maringgai', 'kabupaten' => 'Lampung Timur', 'provinsi' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Way Muli', 'desa' => 'Way Muli', 'kecamatan' => 'Rajabasa', 'kabupaten' => 'Lampung Selatan', 'provinsi' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],

            // Kepulauan Riau
            ['nama' => 'KNMP Desa Pulau Medang', 'desa' => 'Pulau Medang', 'kecamatan' => 'Kekait', 'kabupaten' => 'Lombok Barat', 'provinsi' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()], // Data ini tampak salah provinsi, mengikuti data CSV

            // Jawa Barat
            ['nama' => 'KNMP Desa Mayangan', 'desa' => 'Mayangan', 'kecamatan' => 'Pusakanagara', 'kabupaten' => 'Subang', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Legok Jawa', 'desa' => 'Legok Jawa', 'kecamatan' => 'Cimerak', 'kabupaten' => 'Pangandaran', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Kertajaya', 'desa' => 'Kertajaya', 'kecamatan' => 'Surade', 'kabupaten' => 'Sukabumi', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Muara', 'desa' => 'Muara', 'kecamatan' => 'Blanakan', 'kabupaten' => 'Subang', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Muara Mati', 'desa' => 'Muara Mati', 'kecamatan' => 'Muara Gembong', 'kabupaten' => 'Bekasi', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],

            // Jawa Tengah
            ['nama' => 'KNMP Desa Karanganyar', 'desa' => 'Karanganyar', 'kecamatan' => 'Tambak Dahan', 'kabupaten' => 'Subang', 'provinsi' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()], // Data ini tampak salah provinsi, mengikuti data CSV
            ['nama' => 'KNMP Desa Tambak Rejo', 'desa' => 'Tambak Rejo', 'kecamatan' => 'Gayamsari', 'kabupaten' => 'Semarang', 'provinsi' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Tegalsari', 'desa' => 'Tegalsari', 'kecamatan' => 'Tegal Barat', 'kabupaten' => 'Tegal', 'provinsi' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Karangreja', 'desa' => 'Karangreja', 'kecamatan' => 'Cilacap Utara', 'kabupaten' => 'Cilacap', 'provinsi' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Mororejo', 'desa' => 'Mororejo', 'kecamatan' => 'Kaliwungu', 'kabupaten' => 'Kendal', 'provinsi' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Morodemak', 'desa' => 'Morodemak', 'kecamatan' => 'Bonang', 'kabupaten' => 'Demak', 'provinsi' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],

            // Jawa Timur
            ['nama' => 'KNMP Desa Kedungrejo', 'desa' => 'Kedungrejo', 'kecamatan' => 'Muncar', 'kabupaten' => 'Banyuwangi', 'provinsi' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Palang', 'desa' => 'Palang', 'kecamatan' => 'Palang', 'kabupaten' => 'Tuban', 'provinsi' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Banjar Kemuning', 'desa' => 'Banjar Kemuning', 'kecamatan' => 'Sedati', 'kabupaten' => 'Sidoarjo', 'provinsi' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Puger Kulon', 'desa' => 'Puger Kulon', 'kecamatan' => 'Puger', 'kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Labuhan', 'desa' => 'Labuhan', 'kecamatan' => 'Sepulu', 'kabupaten' => 'Bangkalan', 'provinsi' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],

            // Banten
            ['nama' => 'KNMP Desa Karangantu', 'desa' => 'Karangantu', 'kecamatan' => 'Kasemen', 'kabupaten' => 'Serang', 'provinsi' => 'Banten', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Teluk', 'desa' => 'Teluk', 'kecamatan' => 'Labuan', 'kabupaten' => 'Pandeglang', 'provinsi' => 'Banten', 'created_at' => now(), 'updated_at' => now()],

            // Bali
            ['nama' => 'KNMP Desa Kusamba', 'desa' => 'Kusamba', 'kecamatan' => 'Dawan', 'kabupaten' => 'Klungkung', 'provinsi' => 'Bali', 'created_at' => now(), 'updated_at' => now()],

            // Nusa Tenggara Barat
            ['nama' => 'KNMP Desa Labuan Aji', 'desa' => 'Labuan Aji', 'kecamatan' => 'Lape', 'kabupaten' => 'Sumbawa', 'provinsi' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sekaroh', 'desa' => 'Sekaroh', 'kecamatan' => 'Jerowaru', 'kabupaten' => 'Lombok Timur', 'provinsi' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Pringgabaya', 'desa' => 'Pringgabaya', 'kecamatan' => 'Pringgabaya', 'kabupaten' => 'Lombok Timur', 'provinsi' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Labuhan Haji', 'desa' => 'Labuhan Haji', 'kecamatan' => 'Lape', 'kabupaten' => 'Sumbawa', 'provinsi' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()],

            // Nusa Tenggara Timur
            ['nama' => 'KNMP Desa Oeba', 'desa' => 'Oeba', 'kecamatan' => 'Kupang', 'kabupaten' => 'Kupang', 'provinsi' => 'Nusa Tenggara Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Namosain', 'desa' => 'Namosain', 'kecamatan' => 'Alak', 'kabupaten' => 'Kota Kupang', 'provinsi' => 'Nusa Tenggara Timur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sulamu', 'desa' => 'Sulamu', 'kecamatan' => 'Sulamu', 'kabupaten' => 'Kupang', 'provinsi' => 'Nusa Tenggara Timur', 'created_at' => now(), 'updated_at' => now()],

            // Kalimantan Barat
            ['nama' => 'KNMP Desa Sungai Nibung', 'desa' => 'Sungai Nibung', 'kecamatan' => 'Teluk Batang', 'kabupaten' => 'Kayong Utara', 'provinsi' => 'Kalimantan Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sungai Jawi', 'desa' => 'Sungai Jawi', 'kecamatan' => 'Matan Hilir Selatan', 'kabupaten' => 'Ketapang', 'provinsi' => 'Kalimantan Barat', 'created_at' => now(), 'updated_at' => now()],

            // Kalimantan Selatan
            ['nama' => 'KNMP Desa Paringin', 'desa' => 'Paringin', 'kecamatan' => 'Paringin', 'kabupaten' => 'Balangan', 'provinsi' => 'Kalimantan Selatan', 'created_at' => now(), 'updated_at' => now()],

            // Kalimantan Utara
            ['nama' => 'KNMP Desa Tanjung Palas', 'desa' => 'Tanjung Palas', 'kecamatan' => 'Tanjung Palas', 'kabupaten' => 'Bulungan', 'provinsi' => 'Kalimantan Utara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Tanjung Selor', 'desa' => 'Tanjung Selor', 'kecamatan' => 'Tanjung Selor', 'kabupaten' => 'Bulungan', 'provinsi' => 'Kalimantan Utara', 'created_at' => now(), 'updated_at' => now()],

            // Sulawesi Utara
            ['nama' => 'KNMP Desa Bahowo', 'desa' => 'Bahowo', 'kecamatan' => 'Malalayang', 'kabupaten' => 'Manado', 'provinsi' => 'Sulawesi Utara', 'created_at' => now(), 'updated_at' => now()],

            // Sulawesi Tengah
            ['nama' => 'KNMP Desa Tondo', 'desa' => 'Tondo', 'kecamatan' => 'Palu Utara', 'kabupaten' => 'Palu', 'provinsi' => 'Sulawesi Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Loli', 'desa' => 'Loli', 'kecamatan' => 'Dolo Selatan', 'kabupaten' => 'Sigi', 'provinsi' => 'Sulawesi Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Siduwonge', 'desa' => 'Siduwonge', 'kecamatan' => 'Dampal Selatan', 'kabupaten' => 'Toli-Toli', 'provinsi' => 'Sulawesi Tengah', 'created_at' => now(), 'updated_at' => now()],

            // Sulawesi Barat
            ['nama' => 'KNMP Desa Rangas', 'desa' => 'Rangas', 'kecamatan' => 'Simboro', 'kabupaten' => 'Mamuju', 'provinsi' => 'Sulawesi Barat', 'created_at' => now(), 'updated_at' => now()],

            // Sulawesi Selatan
            ['nama' => 'KNMP Desa Untia', 'desa' => 'Untia', 'kecamatan' => 'Biringkanaya', 'kabupaten' => 'Makassar', 'provinsi' => 'Sulawesi Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Balangloe Tarowang', 'desa' => 'Balangloe Tarowang', 'kecamatan' => 'Tarowang', 'kabupaten' => 'Jeneponto', 'provinsi' => 'Sulawesi Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Aeng Batu-Batu', 'desa' => 'Aeng Batu-Batu', 'kecamatan' => 'Galesong Utara', 'kabupaten' => 'Takalar', 'provinsi' => 'Sulawesi Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Banagan', 'desa' => 'Banagan', 'kecamatan' => 'Dampal Utara', 'kabupaten' => 'Toli-Toli', 'provinsi' => 'Sulawesi Selatan', 'created_at' => now(), 'updated_at' => now()],

            // Sulawesi Tenggara
            ['nama' => 'KNMP Desa Gerak Makmur', 'desa' => 'Gerak Makmur', 'kecamatan' => 'Sampolawa', 'kabupaten' => 'Buton Selatan', 'provinsi' => 'Sulawesi Tenggara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Anaiwoi', 'desa' => 'Anaiwoi', 'kecamatan' => 'Tanggetada', 'kabupaten' => 'Kolaka', 'provinsi' => 'Sulawesi Tenggara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorue Jaya', 'desa' => 'Sorue Jaya', 'kecamatan' => 'Soropia', 'kabupaten' => 'Konawe', 'provinsi' => 'Sulawesi Tenggara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Malalanda', 'desa' => 'Malalanda', 'kecamatan' => 'Kulisusu', 'kabupaten' => 'Buton Utara', 'provinsi' => 'Sulawesi Tenggara', 'created_at' => now(), 'updated_at' => now()],

            // Maluku Utara
            ['nama' => 'KNMP Desa Supu', 'desa' => 'Supu', 'kecamatan' => 'Loloda Utara', 'kabupaten' => 'Halmahera Utara', 'provinsi' => 'Maluku Utara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sangowo Timur', 'desa' => 'Sangowo Timur', 'kecamatan' => 'Morotai Timur', 'kabupaten' => 'Pulau Morotai', 'provinsi' => 'Maluku Utara', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Wasileo', 'desa' => 'Wasileo', 'kecamatan' => 'Maba Utara', 'kabupaten' => 'Halmahera Timur', 'provinsi' => 'Maluku Utara', 'created_at' => now(), 'updated_at' => now()],

            // Maluku
            ['nama' => 'KNMP Desa Amahai', 'desa' => 'Amahai', 'kecamatan' => 'Amahai', 'kabupaten' => 'Maluku Tengah', 'provinsi' => 'Maluku', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Tulehu', 'desa' => 'Tulehu', 'kecamatan' => 'Salahutu', 'kabupaten' => 'Maluku Tengah', 'provinsi' => 'Maluku', 'created_at' => now(), 'updated_at' => now()],

            // Papua Barat
            ['nama' => 'KNMP Desa Mararena', 'desa' => 'Mararena', 'kecamatan' => 'Ransiki', 'kabupaten' => 'Manokwari Selatan', 'provinsi' => 'Papua Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Saengga', 'desa' => 'Saengga', 'kecamatan' => 'Ransiki', 'kabupaten' => 'Manokwari Selatan', 'provinsi' => 'Papua Barat', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Ransiki', 'desa' => 'Ransiki', 'kecamatan' => 'Ransiki', 'kabupaten' => 'Manokwari Selatan', 'provinsi' => 'Papua Barat', 'created_at' => now(), 'updated_at' => now()],

            // Papua
            ['nama' => 'KNMP Desa Sorong', 'desa' => 'Sorong', 'kecamatan' => 'Sorong Kota', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()], // Data ini tampak salah provinsi/kecamatan, mengikuti data CSV
            ['nama' => 'KNMP Desa Sorong Utara', 'desa' => 'Sorong Utara', 'kecamatan' => 'Sorong Utara', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Barat', 'desa' => 'Sorong Barat', 'kecamatan' => 'Sorong Barat', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Timur', 'desa' => 'Sorong Timur', 'kecamatan' => 'Sorong Timur', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Selatan', 'desa' => 'Sorong Selatan', 'kecamatan' => 'Sorong Selatan', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Tengah', 'desa' => 'Sorong Tengah', 'kecamatan' => 'Sorong Tengah', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Utara', 'desa' => 'Sorong Utara', 'kecamatan' => 'Sorong Utara', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KNMP Desa Sorong Barat', 'desa' => 'Sorong Barat', 'kecamatan' => 'Sorong Barat', 'kabupaten' => 'Kota Sorong', 'provinsi' => 'Papua', 'created_at' => now(), 'updated_at' => now()],

        ];

        DB::table('knmp')->insert($data);
    }
}
