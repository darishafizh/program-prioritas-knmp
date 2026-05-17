<?php

namespace App\Imports;

use App\Models\ProgresHarian;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProgresHarianImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithCalculatedFormulas
{
    public $failures = [];
    public $successCount = 0;
    public $duplicateCount = 0;
    public $notFoundCount = 0;
    public $emptyCount = 0;
    public $errorCount = 0;

    /**
     * Get total failure count
     */
    public function totalFailures()
    {
        return $this->duplicateCount + $this->notFoundCount + $this->emptyCount + $this->errorCount;
    }

    /**
     * Process the collection of rows from Excel
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $existingKnmps = \App\Models\Knmp::with('konstruksiKnmp')->get()->keyBy('id');

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            if (empty($row['knmp_id'])) {
                $this->emptyCount++;
                continue;
            }

            $knmpId = (int) $row['knmp_id'];

            if (!$existingKnmps->has($knmpId)) {
                $this->notFoundCount++;
                continue;
            }

            $knmp = $existingKnmps->get($knmpId);
            
            // Ensure KonstruksiKnmp exists for this KNMP
            $konstruksi = $knmp->konstruksiKnmp;
            if (!$konstruksi) {
                // If it doesn't exist, we create it so we can attach progress
                // This might happen if someone imports progress before the stage is officially set to 'konstruksi'
                $konstruksi = \App\Models\KonstruksiKnmp::create([
                    'knmp_id' => $knmpId
                ]);
            }

            $knmpKonstruksiId = $konstruksi->id;

            // Handle date parsing from Excel
            $tanggal = null;
            if (isset($row['tanggal_progres']) && $row['tanggal_progres'] !== '') {
                try {
                    if (is_numeric($row['tanggal_progres'])) {
                        $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_progres'])->format('Y-m-d');
                    } else {
                        $tanggal = \Carbon\Carbon::parse($row['tanggal_progres'])->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $this->errorCount++;
                    Log::error("Import Progres Harian - Baris {$rowNumber}: Format tanggal tidak valid");
                    continue; // Skip this row if date is invalid
                }
            } else {
                $this->errorCount++;
                Log::error("Import Progres Harian - Baris {$rowNumber}: Tanggal progres kosong");
                continue; // Skip if date is empty
            }

            $progresValue = $row['progres'] ?? 0;
            if (is_string($progresValue)) {
                $progresValue = str_replace(',', '.', $progresValue);
            }
            $progresValue = (float) $progresValue;

            try {
                ProgresHarian::updateOrCreate(
                    [
                        'knmp_konstruksi_id' => $knmpKonstruksiId,
                        'tanggal' => $tanggal
                    ],
                    [
                        'progres' => $progresValue,
                        'keterangan' => $row['keterangan'] ?? null,
                    ]
                );
                $this->successCount++;
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Import Progres Harian - Baris {$rowNumber}", ['error' => $e->getMessage()]);
                $errorCode = $e->errorInfo[1] ?? null;
                if ($errorCode == 1062) {
                    $this->duplicateCount++;
                } else {
                    $this->errorCount++;
                }
            } catch (\Exception $e) {
                Log::error("Import Progres Harian - Baris {$rowNumber}", ['error' => $e->getMessage()]);
                $this->errorCount++;
            }
        }
    }

}
