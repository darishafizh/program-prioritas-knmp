<?php

namespace App\Imports;

use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgresKnmpImport implements WithMultipleSheets, WithEvents
{
    protected $knmpId;
    protected $progresId;
    protected $importedMain = false;
    protected $importedDetails = 0;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
        Log::info("ProgresKnmpImport started for KNMP ID: {$knmpId}");
    }

    public function sheets(): array
    {
        Log::info("ProgresKnmpImport loading sheets...");
        // Use index-based access only to avoid duplicate processing
        return [
            0 => new ProgresKnmpMainImport($this->knmpId, $this),
            1 => new ProgresKnmpDetailImport($this->knmpId, $this),
        ];
    }

    public function setProgresId($id)
    {
        $this->progresId = $id;
        Log::info("ProgresKnmpImport: progresId set to {$id}");
    }

    public function getProgresId()
    {
        return $this->progresId;
    }

    public function markMainImported()
    {
        $this->importedMain = true;
    }

    public function getImportedMain()
    {
        return $this->importedMain;
    }

    public function incrementDetails()
    {
        $this->importedDetails++;
    }

    public function getImportedDetails()
    {
        return $this->importedDetails;
    }
}

/**
 * Import Sheet 1: Data Utama Progres KNMP
 */
class ProgresKnmpMainImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $knmpId;
    protected $parentImport;
    protected $rowsProcessed = 0;
    protected $dataImported = false; // Flag to prevent overwriting with empty rows

    public function __construct($knmpId, $parentImport)
    {
        $this->knmpId = $knmpId;
        $this->parentImport = $parentImport;
        Log::info("ProgresKnmpMainImport initialized for KNMP ID: {$knmpId}");
    }

    public function model(array $row)
    {
        $this->rowsProcessed++;
        Log::info("ProgresKnmpMainImport processing row {$this->rowsProcessed}");

        // If we already imported data, skip subsequent rows (likely instruction rows)
        if ($this->dataImported) {
            Log::info("ProgresKnmpMainImport: Data already imported, skipping row {$this->rowsProcessed}");
            return null;
        }

        // Check if row has actual meaningful data (at least one numeric field)
        $hasData = !empty($row['anggaran_total']) ||
            !empty($row['anggaran_konstruksi']) ||
            !empty($row['anggaran_sarpras']) ||
            !empty($row['tk_laki']) ||
            !empty($row['tk_perempuan']) ||
            !empty($row['kendala']) ||
            !empty($row['cctv']);

        if (!$hasData) {
            Log::info("ProgresKnmpMainImport: Row {$this->rowsProcessed} has no meaningful data, skipping");
            return null;
        }

        // Check if progres already exists for this KNMP
        $existing = ProgresKnmp::where('knmp_id', $this->knmpId)->first();

        // Process kendala - could be semicolon-separated string
        $kendala = null;
        if (!empty($row['kendala'])) {
            $kendalaList = array_map('trim', explode(';', $row['kendala']));
            $kendala = json_encode($kendalaList);
        }

        $data = [
            'knmp_id' => $this->knmpId,
            'anggaran_total' => $this->parseNumeric($row['anggaran_total'] ?? null),
            'anggaran_konstruksi' => $this->parseNumeric($row['anggaran_konstruksi'] ?? null),
            'anggaran_sarpras' => $this->parseNumeric($row['anggaran_sarpras'] ?? null),
            'tk_laki' => $this->parseNumeric($row['tk_laki'] ?? null),
            'tk_perempuan' => $this->parseNumeric($row['tk_perempuan'] ?? null),
            'tk_upah' => $this->parseNumeric($row['tk_upah'] ?? null),
            'tk_durasi' => $this->parseNumeric($row['tk_durasi'] ?? null),
            'tk_lokal' => $this->parseNumeric($row['tk_lokal'] ?? null),
            'tk_luar' => $this->parseNumeric($row['tk_luar'] ?? null),
            'tk_non_konstruksi_jumlah' => $this->parseNumeric($row['tk_non_konstruksi_jumlah'] ?? null),
            'tk_non_konstruksi_ket' => $row['tk_non_konstruksi_ket'] ?? null,
            'kendala' => $kendala,
            'cctv' => $row['cctv'] ?? null,
        ];

        Log::info("ProgresKnmpMainImport: Data to save", $data);

        try {
            if ($existing) {
                $existing->update($data);
                $this->parentImport->setProgresId($existing->id);
                $this->parentImport->markMainImported();
                $this->dataImported = true; // Mark as imported to skip subsequent rows
                Log::info("ProgresKnmpMainImport: Updated existing record ID {$existing->id}");
                return null; // Don't create new, just update
            }

            $progres = ProgresKnmp::create($data);
            $this->parentImport->setProgresId($progres->id);
            $this->parentImport->markMainImported();
            $this->dataImported = true; // Mark as imported to skip subsequent rows
            Log::info("ProgresKnmpMainImport: Created new record ID {$progres->id}");
        } catch (\Exception $e) {
            Log::error("ProgresKnmpMainImport: Error saving data", [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }

        return null; // We handle creation manually
    }

    /**
     * Parse numeric value from Excel cell (handles formatted numbers)
     */
    protected function parseNumeric($value)
    {
        if (empty($value) && $value !== 0)
            return null;
        if (is_numeric($value))
            return $value;

        // Remove thousand separators and convert decimal separator
        $cleaned = preg_replace('/[^\d.,\-]/', '', (string) $value);
        $cleaned = str_replace(',', '.', $cleaned);

        return is_numeric($cleaned) ? floatval($cleaned) : null;
    }
}

/**
 * Import Sheet 2: Detail Komponen Pembangunan
 */
class ProgresKnmpDetailImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $knmpId;
    protected $parentImport;
    protected $rowsProcessed = 0;

    public function __construct($knmpId, $parentImport)
    {
        $this->knmpId = $knmpId;
        $this->parentImport = $parentImport;
        Log::info("ProgresKnmpDetailImport initialized for KNMP ID: {$knmpId}");
    }

    public function model(array $row)
    {
        $this->rowsProcessed++;

        // Skip if komponen is empty
        if (empty($row['komponen'])) {
            Log::info("ProgresKnmpDetailImport: Row {$this->rowsProcessed} - komponen empty, skipping");
            return null;
        }

        Log::info("ProgresKnmpDetailImport processing row {$this->rowsProcessed}", [
            'kode' => $row['kode'] ?? null,
            'komponen' => $row['komponen'] ?? null,
        ]);

        // Get progres_id from parent or find it
        $progresId = $this->parentImport->getProgresId();

        if (!$progresId) {
            $progres = ProgresKnmp::where('knmp_id', $this->knmpId)->first();
            if (!$progres) {
                // Create a minimal progres record if none exists
                Log::info("ProgresKnmpDetailImport: Creating minimal ProgresKnmp record");
                $progres = ProgresKnmp::create(['knmp_id' => $this->knmpId]);
            }
            $progresId = $progres->id;
            $this->parentImport->setProgresId($progresId);
        }

        // Check if detail already exists
        $existing = ProgresKnmpDetail::where('progres_id', $progresId)
            ->where('kode', $row['kode'] ?? null)
            ->where('komponen', $row['komponen'])
            ->first();

        $data = [
            'progres_id' => $progresId,
            'kode' => $row['kode'] ?? null,
            'komponen' => $row['komponen'],
            'target' => $row['target'] ?? null,
            'persen' => $row['persen'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
        ];

        try {
            if ($existing) {
                $existing->update($data);
                Log::info("ProgresKnmpDetailImport: Updated existing detail ID {$existing->id}");
                $this->parentImport->incrementDetails();
                return null;
            }

            $this->parentImport->incrementDetails();
            Log::info("ProgresKnmpDetailImport: Creating new detail", $data);
            return new ProgresKnmpDetail($data);
        } catch (\Exception $e) {
            Log::error("ProgresKnmpDetailImport: Error saving detail", [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }
}

