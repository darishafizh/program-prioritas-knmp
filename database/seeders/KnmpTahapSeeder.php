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
        // Batch 1 -> Usulan
        \App\Models\Knmp::where('batch_id', 1)->update(['tahap_saat_ini' => 'usulan']);
        
        // Batch 2 -> Konstruksi
        \App\Models\Knmp::where('batch_id', 2)->update(['tahap_saat_ini' => 'konstruksi']);
    }
}
