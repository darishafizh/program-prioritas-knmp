<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Knmp;

/**
 * Sheet: Read-only Reference of KNMPs
 */
class KnmpReferenceSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Referensi KNMP';
    }

    public function array(): array
    {
        return Knmp::with(['province', 'regency', 'district', 'village'])
            ->get()
            ->map(function ($knmp) {
                return [
                    $knmp->id,
                    $knmp->nama,
                    $knmp->province->name ?? '-',
                    $knmp->regency->name ?? '-',
                    $knmp->district->name ?? '-',
                    $knmp->village->name ?? '-',
                ];
            })
            ->toArray();
    }

    public function headings(): array
    {
        return [
            'ID (Salin ke Sheet Data)',
            'Nama KNMP',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Desa',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6C757D'],
                ],
            ],
        ];
    }
}
