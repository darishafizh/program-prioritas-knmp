<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Aceh', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bengkulu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sumatera Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lampung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kep. Riau', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sumatera Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jawa Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Banten', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DI Yogyakarta', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jawa Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jawa Timur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nusa Tenggara Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bali', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nusa Tenggara Timur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kalimantan Tengah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kalimantan Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sulawesi Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sulawesi Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gorontalo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sulawesi Tenggara', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maluku Utara', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maluku', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Papua Barat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Papua', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('knmp_provinces')->insert($data);
    }
}
