<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnmpRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = DB::table('knmp')
            ->select('id')
            ->orderBy('id')
            ->limit(65)
            ->get();

        $counter = 1;

        foreach ($records as $row) {
            DB::table('knmp')
                ->where('id', $row->id)
                ->update([
                    'province_id' => $counter,
                    'regency_id'  => $counter,
                    'district_id' => $counter,
                    'village_id'  => $counter,
                ]);

            $counter++;
        }
    }
}
