<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SosialKelembagaanTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
                '', // anggota_kelompok
                '', // manfaat_kelompok
                '', // anggota_koperasi
                '', // tertarik_koperasi
                '', // manfaat_koperasi
                '', // koperasi_rapat_tahunan
                '', // koperasi_partisipasi_aktif
                '', // koperasi_pengurus_kompeten
                '', // koperasi_transparan
                '', // koperasi_keuangan_sehat
                '', // koperasi_jaringan_pasar
                '', // koperasi_kepercayaan_usaha
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'responden_id',
            'anggota_kelompok',
            'manfaat_kelompok',
            'anggota_koperasi',
            'tertarik_koperasi',
            'manfaat_koperasi',
            'koperasi_rapat_tahunan',
            'koperasi_partisipasi_aktif',
            'koperasi_pengurus_kompeten',
            'koperasi_transparan',
            'koperasi_keuangan_sehat',
            'koperasi_jaringan_pasar',
            'koperasi_kepercayaan_usaha',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E83E8C'],
                ],
            ],
        ];
    }
}
