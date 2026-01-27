<?php

namespace App\Imports;

use App\Models\ProgresKnmpNasional;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProgresKnmpNasionalImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if knmp_id is missing
        if (empty($row['knmp_id'])) {
            return null;
        }

        // Cast to integer to ensure matching with DB primary key type
        $knmpId = (int) $row['knmp_id'];

        // Find existing record manually to debug/ensure update happens
        $progresRecord = ProgresKnmpNasional::where('knmp_id', $knmpId)->first();

        if ($progresRecord) {
            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }
            $progresRecord->progres = (float) $progresValue;
            $progresRecord->save();
            // Return null to prevent Laravel Excel from trying to insert an already existing record
            return null;
        } else {
            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }

            return new ProgresKnmpNasional([
                'knmp_id' => $knmpId,
                'progres' => (float) $progresValue
            ]);
        }
    }
}
