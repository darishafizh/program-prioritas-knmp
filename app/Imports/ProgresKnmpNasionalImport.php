<?php

namespace App\Imports;

use App\Models\ProgresKnmpNasional;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProgresKnmpNasionalImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    /**
     * Process the collection of rows from Excel
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if knmp_id is missing
            if (empty($row['knmp_id'])) {
                continue;
            }

            // Cast to integer to ensure matching with DB primary key type
            $knmpId = (int) $row['knmp_id'];

            // Get progres value and clean it
            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }
            $progresValue = (float) $progresValue;

            // Use updateOrCreate for reliable update/insert
            ProgresKnmpNasional::updateOrCreate(
                ['knmp_id' => $knmpId],
                ['progres' => $progresValue]
            );

            Log::info("Updated progres KNMP Nasional", [
                'knmp_id' => $knmpId,
                'progres' => $progresValue
            ]);
        }
    }
}

