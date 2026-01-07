<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfileKnmpTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'jml_penduduk_des',
            'jml_nelayan',
            'pendapatan_rata_rata_nelayan',
            'volume_produksi_ton',
            'nilai_produksi',
            'komoditas_utama_1',
            'komoditas_utama_2',
            'harga_rata_komoditas_1',
            'harga_rata_komoditas_2',
            'infra_jalan_akses',
            'infra_listrik',
            'infra_air_bersih',
            'infra_internet',
            'infra_ipal',
            'infra_dermaga_tambat',
            'infra_tpi',
            'infra_cold_storage',
            'infra_pabrik_es',
            'infra_kantor_koperasi',
            'infra_bengkel_nelayan',
            'infra_waserda',
            'calon_koperasi',
            'nama_ketua',
            'sk_kopdeskel',
            'nomor_induk_kopdeskel',
            'jumlah_anggota_laki',
            'jumlah_anggota_perempuan',
            'koordinat_lokasi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }
}
