<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TingkatKebahagiaanTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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

        // For each responden, create rows for questions 1-10
        $rows = [];
        foreach ($respondents as $responden) {
            for ($i = 1; $i <= 10; $i++) {
                $rows[] = [
                    $responden->id,
                    $i, // nomor_soal
                    '', // kategori
                    '', // jawaban_teks
                    '', // skor_nilai
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'nomor_soal',
            'kategori',
            'jawaban_teks',
            'skor_nilai',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DC3545'],
                ],
            ],
        ];
    }
}
