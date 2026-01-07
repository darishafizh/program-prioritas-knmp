<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgresKnmpTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'anggaran_total',
            'anggaran_konstruksi',
            'anggaran_sarpras',
            'tk_total',
            'tk_laki',
            'tk_perempuan',
            'tk_upah',
            'tk_durasi',
            'tk_lokal',
            'tk_luar',
            'tk_non_konstruksi_jumlah',
            'tk_non_konstruksi_ket',
            'kendala',
            'cctv',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '17A2B8'],
                ],
            ],
        ];
    }
}
