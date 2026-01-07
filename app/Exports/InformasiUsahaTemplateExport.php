<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InformasiUsahaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'nama_kapal',
            'tahun_pembuatan',
            'ukuran_gt',
            'dimensi_perahu',
            'jenis_bahan_baku',
            'jenis_mesin',
            'alat_penyimpanan',
            'jenis_alat_tangkap',
            'hari_per_trip',
            'waktu_melaut_jam',
            'jarak_penangkapan_mil',
            'waktu_tempuh_jam',
            'jml_trip_per_bulan',
            'jml_bulan_melaut',
            'produksi_kg_per_trip',
            'penjualan_rp_per_trip',
            'biaya_solar_rp',
            'volume_solar_liter',
            'biaya_bensin_rp',
            'volume_bensin_liter',
            'biaya_es_balok_rp',
            'volume_es_balok',
            'biaya_es_kantong_rp',
            'volume_es_kantong',
            'total_biaya_operasional',
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
