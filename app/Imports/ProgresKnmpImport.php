<?php

namespace App\Imports;

use App\Models\ProgresKnmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProgresKnmpImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new ProgresKnmp([
            'knmp_id' => $this->knmpId,
            'anggaran_total' => $row['anggaran_total'] ?? null,
            'anggaran_konstruksi' => $row['anggaran_konstruksi'] ?? null,
            'anggaran_sarpras' => $row['anggaran_sarpras'] ?? null,
            'tk_total' => $row['tk_total'] ?? null,
            'tk_laki' => $row['tk_laki'] ?? null,
            'tk_perempuan' => $row['tk_perempuan'] ?? null,
            'tk_upah' => $row['tk_upah'] ?? null,
            'tk_durasi' => $row['tk_durasi'] ?? null,
            'tk_lokal' => $row['tk_lokal'] ?? null,
            'tk_luar' => $row['tk_luar'] ?? null,
            'tk_non_konstruksi_jumlah' => $row['tk_non_konstruksi_jumlah'] ?? null,
            'tk_non_konstruksi_ket' => $row['tk_non_konstruksi_ket'] ?? null,
            'kendala' => $row['kendala'] ?? null,
            'cctv' => $row['cctv'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'anggaran_total' => 'nullable|numeric',
        ];
    }
}
