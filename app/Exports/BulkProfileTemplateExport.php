<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Experiments\Sheets\KnmpReferenceSheet; // Mistype? No, it should be App\Exports\Sheets
use App\Exports\Sheets\KnmpReferenceSheet as SharedKnmpReferenceSheet;

class BulkProfileTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Data Profile' => new ProfileKnmpTemplateSheet(),
            'Referensi KNMP' => new SharedKnmpReferenceSheet(),
        ];
    }
}

/**
 * Sheet 1: Data Template with knmp_id column
 */
class ProfileKnmpTemplateSheet implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Data Profile';
    }

    public function array(): array
    {
        // Sample row with knmp_id placeholder
        return [
            [
                '1 (Lihat Sheet Referensi)', // knmp_id
                '1000', // jml_penduduk_des
                '500', // jml_nelayan
                '2500000', // pendapatan
                '50', // volume
                '500000000', // nilai_produksi
                'Ikan Tongkol', // komoditas 1
                'Ikan Layang', // komoditas 2
                '20000', // harga 1
                '15000', // harga 2
                'Ada', // infra_jalan
                'Ada', // infra_listrik
                'Tidak', // infra_air
                'Ada', // infra_internet
                'Tidak', // infra_ipal
                'Ada', // infra_dermaga
                'Ada', // infra_tpi
                'Tidak', // infra_cold_storage
                'Tidak', // infra_pabrik_es
                'Ada', // infra_kantor
                'Ada', // infra_bengkel
                'Ada', // infra_waserda
                'Koperasi Maju Jaya', // calon_koperasi
                'Budi Santoso', // ketu
                'SK-123/2024', // sk
                '123456789', // nomor_induk
                '50', // jml_anggota_l
                '10', // jml_anggota_p
                '-6.123, 106.123', // koordinat
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'knmp_id', // New Column
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
        // Add note about knmp_id
        $sheet->getComment('A1')->getText()->createTextRun('Isi dengan ID dari Sheet "Referensi KNMP"');

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
            'A1' => [ // Highlight knmp_id column header
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107'], // Amber/Warning color to stand out
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            ]
        ];
    }
}
