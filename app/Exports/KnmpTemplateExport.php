<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KnmpTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['nama', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'latitude', 'longitude'];
    }

    public function array(): array
    {
        return [
            ['KNMP Contoh', 'JAWA BARAT', 'KABUPATEN INDRAMAYU', 'KANDANGHAUR', 'ERETAN WETAN', '-6.3167', '107.9000'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
