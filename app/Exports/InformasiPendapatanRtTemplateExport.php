<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InformasiPendapatanRtTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
                '', // pendapatan_perikanan
                '', // pendapatan_non_perikanan
                '', // pendapatan_total
                '', // kontribusi_nelayan_persen
                '', // jumlah_sumber_penghasilan
                '', // ketergantungan_perikanan
                '', // stabilitas_pendapatan
                '', // keterlibatan_perempuan
                '', // kontribusi_perempuan_persen
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'pendapatan_perikanan',
            'pendapatan_non_perikanan',
            'pendapatan_total',
            'kontribusi_nelayan_persen',
            'jumlah_sumber_penghasilan',
            'ketergantungan_perikanan',
            'stabilitas_pendapatan',
            'keterlibatan_perempuan',
            'kontribusi_perempuan_persen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '20C997'],
                ],
            ],
        ];
    }
}
