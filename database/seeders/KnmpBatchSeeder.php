<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update knmp dengan id 1-65, batch_id 1
        DB::table('knmp')
            ->whereBetween('id', [1, 65])
            ->update(['batch_id' => 1]);

        // Update knmp dengan id 109-143, batch_id 2
        DB::table('knmp')
            ->whereBetween('id', [109, 143])
            ->update(['batch_id' => 2]);
    }
}
