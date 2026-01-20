<?php

namespace App\Imports;

use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\DB;

class ProgresKnmpImport implements WithMultipleSheets
{
    protected $knmpId;
    protected $progresId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function sheets(): array
    {
        return [
            'Progres Utama' => new ProgresKnmpMainImport($this->knmpId, $this),
            'Detail Komponen' => new ProgresKnmpDetailImport($this->knmpId, $this),
            // Also support index-based sheet access
            0 => new ProgresKnmpMainImport($this->knmpId, $this),
            1 => new ProgresKnmpDetailImport($this->knmpId, $this),
        ];
    }

    public function setProgresId($id)
    {
        $this->progresId = $id;
    }

    public function getProgresId()
    {
        return $this->progresId;
    }
}

/**
 * Import Sheet 1: Data Utama Progres KNMP
 */
class ProgresKnmpMainImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $knmpId;
    protected $parentImport;

    public function __construct($knmpId, $parentImport)
    {
        $this->knmpId = $knmpId;
        $this->parentImport = $parentImport;
    }

    public function model(array $row)
    {
        // Skip if all values are empty
        if (empty(array_filter($row))) {
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
            'anggaran_total' => $row['anggaran_total'] ?? null,
            'anggaran_konstruksi' => $row['anggaran_konstruksi'] ?? null,
            'anggaran_sarpras' => $row['anggaran_sarpras'] ?? null,
            'tk_laki' => $row['tk_laki'] ?? null,
            'tk_perempuan' => $row['tk_perempuan'] ?? null,
            'tk_upah' => $row['tk_upah'] ?? null,
            'tk_durasi' => $row['tk_durasi'] ?? null,
            'tk_lokal' => $row['tk_lokal'] ?? null,
            'tk_luar' => $row['tk_luar'] ?? null,
            'tk_non_konstruksi_jumlah' => $row['tk_non_konstruksi_jumlah'] ?? null,
            'tk_non_konstruksi_ket' => $row['tk_non_konstruksi_ket'] ?? null,
            'kendala' => $kendala,
            'cctv' => $row['cctv'] ?? null,
        ];

        if ($existing) {
            $existing->update($data);
            $this->parentImport->setProgresId($existing->id);
            return null; // Don't create new, just update
        }

        $progres = ProgresKnmp::create($data);
        $this->parentImport->setProgresId($progres->id);
        
        return null; // We handle creation manually
    }
}

/**
 * Import Sheet 2: Detail Komponen Pembangunan
 */
class ProgresKnmpDetailImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $knmpId;
    protected $parentImport;

    public function __construct($knmpId, $parentImport)
    {
        $this->knmpId = $knmpId;
        $this->parentImport = $parentImport;
    }

    public function model(array $row)
    {
        // Skip if komponen is empty
        if (empty($row['komponen'])) {
            return null;
        }

        // Get progres_id from parent or find it
        $progresId = $this->parentImport->getProgresId();
        
        if (!$progresId) {
            $progres = ProgresKnmp::where('knmp_id', $this->knmpId)->first();
            if (!$progres) {
                // Create a minimal progres record if none exists
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

        if ($existing) {
            $existing->update($data);
            return null;
        }

        return new ProgresKnmpDetail($data);
    }
}
