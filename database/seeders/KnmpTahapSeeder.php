<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnmpTahapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Knmp::whereBetween('id', [1, 65])->update(['tahap' => 1]);
        \App\Models\Knmp::whereBetween('id', [109, 143])->update(['tahap' => 2]);
    }
}
