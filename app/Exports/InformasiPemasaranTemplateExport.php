<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InformasiPemasaranTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $respondenIds;

    public function __construct($respondenIds = null)
    {
        $this->respondenIds = $respondenIds;
    }

    public function array(): array
    {
        if (empty($this->respondenIds)) {
            return [];
        }

        $respondents = InformasiResponden::whereIn('id', $this->respondenIds)
            ->orderBy('id')
            ->get(['id', 'nama_responden']);

        return $respondents->map(function ($responden) {
            return [
                $responden->id,
                '', // kendala_pemasaran_text
                '', // cara_penanganan_ikan
                '', // eceran_kg
                '', // koperasi_kg
                '', // tengkulak_kg
                '', // pengepul_kg
                '', // pedagang_besar_kg
                '', // lainnya_kg
                '', // lainnya_keterangan
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'kendala_pemasaran_text',
            'cara_penanganan_ikan',
            'eceran_kg',
            'koperasi_kg',
            'tengkulak_kg',
            'pengepul_kg',
            'pedagang_besar_kg',
            'lainnya_kg',
            'lainnya_keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6F42C1'],
                ],
            ],
        ];
    }
}
