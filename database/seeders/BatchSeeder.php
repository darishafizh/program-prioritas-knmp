<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_tahap' => 'I', 'tahun' => '2025'],
            ['nama_tahap' => 'II', 'tahun' => '2025'],
            ['nama_tahap' => 'I', 'tahun' => '2026'],
        ];

        DB::table('batch')->insert($data);
    }
}
