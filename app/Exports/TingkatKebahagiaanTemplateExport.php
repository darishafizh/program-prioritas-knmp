<?php

namespace App\Exports;

use App\Models\InformasiResponden;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TingkatKebahagiaanTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $respondenIds;

    /**
     * Per-question category mapping
     */
    protected $questions = [
        1  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Saya memiliki pendidikan/keterampilan yang memadai untuk menunjang pekerjaan nelayan saya.'],
        2  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Pelatihan/penyuluhan yang saya ikuti bermanfaat bagi peningkatan hasil tangkapan.'],
        3  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Pekerjaan/usaha utama saya saat ini memberikan penghasilan yang layak bagi keluarga.'],
        4  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Saya merasa pekerjaan/usaha utama saya stabil dan berkelanjutan.'],
        5  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Kesehatan saya dalam satu bulan terakhir cukup baik untuk bekerja di laut.'],
        6  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Saya mudah mengakses layanan kesehatan saat dibutuhkan.'],
        7  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Kondisi rumah dan fasilitas dasar (air, listrik, sanitasi) di rumah saya memadai.'],
        8  => ['kategori' => 'A.1 Kepuasan Hidup Personal', 'pertanyaan' => 'Saya merasa nyaman dan aman tinggal di rumah saya saat ini.'],
        9  => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Hubungan dalam keluarga saya harmonis.'],
        10 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Kami dapat menyelesaikan masalah keluarga dengan baik.'],
        11 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Saya memiliki waktu luang yang cukup untuk beristirahat atau berkumpul dengan keluarga.'],
        12 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Keseimbangan antara bekerja dan waktu untuk keluarga terjaga.'],
        13 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Saya memiliki hubungan sosial yang baik dengan sesama nelayan dan tetangga.'],
        14 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Saya aktif dalam kegiatan sosial/komunitas di kampung.'],
        15 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Lingkungan kampung/pelabuhan terasa bersih dan tertata.'],
        16 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Fasilitas umum di lingkungan saya cukup memadai.'],
        17 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Saya merasa aman dari tindak kriminal/konflik di lingkungan saya.'],
        18 => ['kategori' => 'A.2 Kepuasan Hidup Sosial', 'pertanyaan' => 'Pengaturan keamanan/pengawasan di pelabuhan/dermaga berjalan baik.'],
        19 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Dalam dua minggu terakhir, saya sering merasa senang/gembira setelah melaut.'],
        20 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Saya bersemangat menjalani kegiatan sehari-hari sebagai nelayan.'],
        21 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Saya merasa cemas/khawatir terhadap masa depan pekerjaan saya.'],
        22 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Saya sering merasa was-was terhadap ketersediaan BBM/es atau harga ikan.'],
        23 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Saya merasa tertekan dengan beban kerja atau tekanan sosial di pelabuhan.'],
        24 => ['kategori' => 'B. Perasaan', 'pertanyaan' => 'Saya sering merasa lelah batin atau putus asa.'],
        25 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya mampu mengambil keputusan penting dalam hidup dan pekerjaan saya secara mandiri.'],
        26 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya bertanggung jawab terhadap pilihan-pilihan saya.'],
        27 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya mampu mengelola lingkungan kerja (kapal, alat, tim) dengan baik.'],
        28 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya dapat menyesuaikan diri dengan perubahan kondisi laut/pasar.'],
        29 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya terus belajar untuk meningkatkan diri (keterampilan, teknologi, praktik pascapanen).'],
        30 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya memiliki rencana pengembangan diri untuk 1–3 tahun ke depan.'],
        31 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya memiliki hubungan positif dan saling mendukung dengan orang lain di komunitas.'],
        32 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya merasa menjadi bagian penting di koperasi/komunitas nelayan.'],
        33 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya memiliki tujuan hidup yang jelas untuk keluarga dan pekerjaan.'],
        34 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya melihat masa depan yang ingin saya capai dan saya mengetahuinya.'],
        35 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya menerima kekuatan dan keterbatasan diri saya.'],
        36 => ['kategori' => 'C. Makna Hidup', 'pertanyaan' => 'Saya merasa hidup ini hampa dan tidak bermakna.'],
    ];

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

        $rows = [];
        foreach ($respondents as $responden) {
            foreach ($this->questions as $no => $q) {
                $rows[] = [
                    $responden->nama_responden,
                    $no,
                    $q['kategori'],
                    $q['pertanyaan'],
                    '', // jawaban_teks — user fills this via dropdown
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'nama_responden',
            'nomor_soal',
            'kategori',
            'pertanyaan',
            'jawaban_teks',
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

    /**
     * Add dropdown data validation for jawaban_teks column
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = count($this->array()) + 1; // +1 for header

                if ($lastRow < 2) return;

                // Apply dropdown validation to jawaban_teks column (F)
                $options = '"Sangat Tidak Setuju,Tidak Setuju,Netral,Setuju,Sangat Setuju"';

                for ($row = 2; $row <= $lastRow; $row++) {
                    $validation = $sheet->getCell("E{$row}")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input tidak valid');
                    $validation->setError('Pilih salah satu: Sangat Tidak Setuju, Tidak Setuju, Netral, Setuju, Sangat Setuju');
                    $validation->setPromptTitle('Pilih Jawaban');
                    $validation->setPrompt('Klik panah untuk memilih jawaban.');
                    $validation->setFormula1($options);
                }

                // Protect pre-filled columns (A-D) with light gray background
                $sheet->getStyle("A2:D{$lastRow}")->getFill()->setFillType(
                    \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                );
                $sheet->getStyle("A2:D{$lastRow}")->getFill()->getStartColor()->setRGB('F2F2F2');

                // Lock pre-filled columns
                $sheet->getStyle("A2:D{$lastRow}")->getProtection()->setLocked(
                    \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED
                );
                // Unlock jawaban column
                $sheet->getStyle("E2:E{$lastRow}")->getProtection()->setLocked(
                    \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED
                );

                // Highlight jawaban_teks column header with green
                $sheet->getStyle('E1')->getFill()->setFillType(
                    \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                );
                $sheet->getStyle('E1')->getFill()->getStartColor()->setRGB('70AD47');

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(25);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(28);
                $sheet->getColumnDimension('D')->setWidth(60);
                $sheet->getColumnDimension('E')->setWidth(24);

                // Enable sheet protection so pre-filled data can't be edited
                $sheet->getProtection()->setSheet(true);
                $sheet->getProtection()->setSort(false);
                $sheet->getProtection()->setAutoFilter(false);
            },
        ];
    }
}
