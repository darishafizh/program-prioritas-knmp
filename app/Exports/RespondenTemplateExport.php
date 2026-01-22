<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Knmp;
use Illuminate\Support\Facades\Auth;

class RespondenTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $knmpId;
    protected $knmp;

    public function __construct($knmpId = null)
    {
        // Use provided knmpId or get from authenticated user
        $this->knmpId = $knmpId ?? Auth::user()->knmp_id ?? null;

        if ($this->knmpId) {
            $this->knmp = Knmp::find($this->knmpId);
        }
    }

    public function array(): array
    {
        // Return one sample row with pre-filled location IDs from KNMP
        if ($this->knmp) {
            return [
                [
                    '', // nama_responden
                    '', // nik
                    '', // nomor_kusuka
                    '', // tempat_lahir
                    '', // tanggal_lahir
                    '', // umur
                    '', // jenis_kelamin
                    '', // suku_bangsa
                    '', // pendidikan_terakhir
                    '', // wpp
                    '', // alamat
                    '', // no_hp_responden
                    '', // jumlah_anggota_rumah
                    '', // jumlah_anggota_perempuan_rumah
                    '', // jumlah_anggota_bekerja
                    '', // jumlah_anggota_perempuan_bekerja
                    '', // jumlah_abk
                    '', // pengalaman_usaha
                    $this->knmp->province_id ?? '', // province_id - auto-filled from KNMP
                    $this->knmp->regency_id ?? '', // regency_id - auto-filled from KNMP
                    $this->knmp->district_id ?? '', // district_id - auto-filled from KNMP
                    $this->knmp->village_id ?? '', // village_id - auto-filled from KNMP
                    '', // tanggal_wawancara
                    '', // nama_enumerator
                    '', // jenis_kelamin_enumerator
                    '', // no_hp_enumerator
                ],
            ];
        }

        // Return empty array if no KNMP
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
            'province_id',
            'regency_id',
            'district_id',
            'village_id',
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
