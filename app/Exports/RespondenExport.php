<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RespondenExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $knmpId;

    public function __construct($knmpId = null)
    {
        $this->knmpId = $knmpId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = InformasiResponden::with(['knmp', 'province', 'regency', 'district', 'village']);

        if ($this->knmpId) {
            $query->where('knmp_id', $this->knmpId);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama KNMP',
            'Nama Responden',
            'NIK',
            'Nomor KUSUKA',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Jenis Kelamin',
            'Suku Bangsa',
            'Pendidikan Terakhir',
            'WPP',
            'Alamat',
            'No. HP Responden',
            'Jumlah Anggota Rumah Tangga',
            'Jumlah Anggota Perempuan',
            'Jumlah Anggota Bekerja',
            'Jumlah Anggota Perempuan Bekerja',
            'Jumlah ABK',
            'Pengalaman Usaha (Tahun)',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Desa/Kelurahan',
            'Tanggal Wawancara',
            'Nama Enumerator',
            'Jenis Kelamin Enumerator',
            'No. HP Enumerator',
        ];
    }

    /**
     * @param InformasiResponden $responden
     * @return array
     */
    public function map($responden): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $responden->knmp->nama ?? '-',
            $responden->nama_responden,
            $responden->nik,
            $responden->nomor_kusuka,
            $responden->tempat_lahir,
            $responden->tanggal_lahir,
            $responden->umur,
            $responden->jenis_kelamin,
            $responden->suku_bangsa,
            $responden->pendidikan_terakhir,
            $responden->wpp,
            $responden->alamat,
            $responden->no_hp_responden,
            $responden->jumlah_anggota_rumah,
            $responden->jumlah_anggota_perempuan_rumah,
            $responden->jumlah_anggota_bekerja,
            $responden->jumlah_anggota_perempuan_bekerja,
            $responden->jumlah_abk,
            $responden->pengalaman_usaha,
            $responden->province->name ?? '-',
            $responden->regency->name ?? '-',
            $responden->district->name ?? '-',
            $responden->village->name ?? '-',
            $responden->tanggal_wawancara,
            $responden->nama_enumerator,
            $responden->jenis_kelamin_enumerator,
            $responden->no_hp_enumerator,
        ];
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
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
