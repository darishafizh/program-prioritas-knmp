<?php

namespace App\Imports;

use App\Models\InformasiPemasaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class InformasiPemasaranImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new InformasiPemasaran([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'kendala_pemasaran_text' => $row['kendala_pemasaran_text'] ?? null,
            'cara_penanganan_ikan' => $row['cara_penanganan_ikan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
