<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RespondenTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        // Return empty array - template only has headers
        return [];
    }

    public function headings(): array
    {
        return [
            'nama_responden',
            'nik',
            'nomor_kusuka',
            'tempat_lahir',
            'tanggal_lahir',
            'umur',
            'jenis_kelamin',
            'suku_bangsa',
            'pendidikan_terakhir',
            'wpp',
            'alamat',
            'no_hp_responden',
            'jumlah_anggota_rumah',
            'jumlah_anggota_perempuan_rumah',
            'jumlah_anggota_bekerja',
            'jumlah_anggota_perempuan_bekerja',
            'jumlah_abk',
            'pengalaman_usaha',
            // province_id, regency_id, district_id, village_id removed - auto-populated from KNMP address
            'tanggal_wawancara',
            'nama_enumerator',
            'jenis_kelamin_enumerator',
            'no_hp_enumerator',
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
