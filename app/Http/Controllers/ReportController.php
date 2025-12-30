<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\InformasiResponden;
use App\Models\ProfileKnmp;
use App\Models\ProgresKnmp;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\InformasiUsaha;
use App\Models\InformasiPemasaran;
use App\Models\InformasiPendapatanRumahTangga;
use App\Models\SosialKelembagaan;
use App\Models\BuktiUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // ======================================
    // GENERATE PDF LIST KUESIONER RESPONDEN
    // ======================================
    public function generateRespondenQuestionnairesPdf(Knmp $knmp, InformasiResponden $responden)
    {
        // Validasi responden milik KNMP
        if ($responden->knmp_id != $knmp->id) {
            abort(404);
        }

        // Data pertanyaan Tingkat Kebahagiaan
        $tingkatKebahagiaan_pertanyaan = [
            'kepuasan_hidup_personal' => [
                1 => 'Saya puas dengan kondisi hidup saya saat ini',
                2 => 'Saya merasa hidup saya bermakna dan berharga',
                3 => 'Saya merasa bahagia dengan pencapaian saya',
                4 => 'Saya puas dengan hubungan keluarga saya',
            ],
            'kepuasan_hidup_sosial' => [
                1 => 'Saya memiliki hubungan yang baik dengan tetangga',
                2 => 'Saya merasa diterima di masyarakat',
                3 => 'Saya aktif dalam kegiatan sosial masyarakat',
                4 => 'Saya puas dengan dukungan sosial dari komunitas',
            ],
            'perasaan' => [
                1 => 'Saya merasa optimis tentang masa depan',
                2 => 'Saya jarang mengalami stres dalam kehidupan sehari-hari',
                3 => 'Saya merasa sehat secara fisik dan mental',
                4 => 'Saya merasa aman dan terlindungi',
            ],
            'makna_hidup' => [
                1 => 'Pekerjaan saya memberikan makna hidup',
                2 => 'Saya memiliki tujuan hidup yang jelas',
                3 => 'Saya merasa kontribusi saya berarti bagi keluarga dan masyarakat',
                4 => 'Saya merasa kehidupan nelayan ini layak untuk diteruskan',
            ],
        ];

        // 1. PROSES PEMBANGUNAN KNMP (PROFIL KNMP + PROGRES)
        $profileKnmp = ProfileKnmp::where('knmp_id', $knmp->id)->first();

        $progresKnmp = ProgresKnmp::where('knmp_id', $knmp->id)
            ->with('details')
            ->get();

        // 2. TANGGAPAN MASYARAKAT
        $tanggapanMasyarakat = TanggapanMasyarakat::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 3. TINGKAT KEBAHAGIAAN NELAYAN
        $tingkatKebahagiaan = TingkatKebahagiaanNelayan::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->get()
            ->groupBy('kategori');

        // 4. INFORMASI USAHA (EXISTING)
        $informasiUsaha = InformasiUsaha::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->with('ikan')
            ->get();

        // 5. INFORMASI PEMASARAN
        $informasiPemasaran = InformasiPemasaran::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->with('detail_pemasaran')
            ->first();

        // 6. PENDAPATAN RUMAH TANGGA
        $pendapatanRt = InformasiPendapatanRumahTangga::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 7. SOSIAL & KELEMBAGAAN
        $sosialKelembagaan = SosialKelembagaan::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 8. BUKTI PENDUKUNG
        $buktiPendukung = BuktiUpload::where('knmp_id', $knmp->id)
            ->get();

        $html = view('survey.pdf.questionnaire-responden', [
            'knmp' => $knmp,
            'responden' => $responden,
            'profileKnmp' => $profileKnmp,
            'progresKnmp' => $progresKnmp,
            'tanggapanMasyarakat' => $tanggapanMasyarakat,
            'tingkatKebahagiaan' => $tingkatKebahagiaan,
            'tingkatKebahagiaan_pertanyaan' => $tingkatKebahagiaan_pertanyaan,
            'informasiUsaha' => $informasiUsaha,
            'informasiPemasaran' => $informasiPemasaran,
            'pendapatanRt' => $pendapatanRt,
            'sosialKelembagaan' => $sosialKelembagaan,
            'buktiPendukung' => $buktiPendukung,
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Kuesioner_' . str_replace(' ', '_', $responden->nama_responden) . '_' . date('d-m-Y_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function questionnairesListPdf(Knmp $knmp)
    {
        // Ambil semua responden dengan data yang relevan
        $responden = InformasiResponden::where('knmp_id', $knmp->id)
            ->with(['knmp'])
            ->orderBy('tanggal_wawancara', 'desc')
            ->get()
            ->map(function ($item) use ($knmp) {
                // Cek apakah responden ini sudah mengisi SEMUA form yang wajib
                $hasTanggapan = DB::table('tanggapan_masyarakat')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasTingkatKebahagiaan = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasInformasiUsaha = DB::table('informasi_usaha')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasPemasaran = DB::table('informasi_pemasaran')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasPendapatanRT = DB::table('informasi_pendapatan_rumah_tangga')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasSosialKelembagaan = DB::table('sosial_kelembagaan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                // Hitung total form yang terisi (dari 6 form wajib)
                $filledForms = collect([
                    $hasTanggapan,
                    $hasTingkatKebahagiaan,
                    $hasInformasiUsaha,
                    $hasPemasaran,
                    $hasPendapatanRT,
                    $hasSosialKelembagaan
                ])->filter()->count();

                $totalForms = 6;

                // Hitung total jawaban untuk ditampilkan
                $totalRecords = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->count();

                // Ambil tanggal terakhir pengisian dari semua tabel
                $lastUpdatedDates = collect([
                    DB::table('tanggapan_masyarakat')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('tingkat_kebahagiaan_nelayan')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_usaha')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_pemasaran')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_pendapatan_rumah_tangga')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('sosial_kelembagaan')->where('responden_id', $item->id)->max('updated_at'),
                ])->filter()->max();

                return [
                    'id' => $item->id,
                    'nama_responden' => $item->nama_responden,
                    'nik' => $item->nik,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tanggal_wawancara' => $item->tanggal_wawancara,
                    'nama_enumerator' => $item->nama_enumerator,
                    'total_answers' => $totalRecords,
                    'filled_forms' => $filledForms,
                    'total_forms' => $totalForms,
                    'last_updated' => $lastUpdatedDates,
                    'is_complete' => $filledForms === $totalForms, // SEMUA form harus terisi
                ];
            });

        return view('survey.questionnaires-list-pdf', compact('knmp', 'responden'));
    }
}
