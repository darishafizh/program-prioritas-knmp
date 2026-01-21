<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TanggapanMasyarakatTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
                '', // kesesuaian_kebutuhan
                '', // item_tidak_sesuai
                '', // tingkat_kesenangan
                '', // alasan_tidak_senang
                '', // harapan_masyarakat
                '', // masukan_saran_perbaikan
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'kesesuaian_kebutuhan',
            'item_tidak_sesuai',
            'tingkat_kesenangan',
            'alasan_tidak_senang',
            'harapan_masyarakat',
            'masukan_saran_perbaikan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107'],
                ],
            ],
        ];
    }
}
