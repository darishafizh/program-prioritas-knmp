<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\InformasiResponden;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\TargetRealisasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Knmp;
use App\Models\ProgresKnmpNasional;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter periode waktu
        $period = $request->get('period', 'all');
        $periodLabel = match ($period) {
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
            default => 'Semua Waktu',
        };

        // Tentukan tanggal mulai berdasarkan filter
        $startDate = match ($period) {
            'week' => Carbon::now('Asia/Jakarta')->startOfWeek(),
            'month' => Carbon::now('Asia/Jakarta')->startOfMonth(),
            'year' => Carbon::now('Asia/Jakarta')->startOfYear(),
            default => null,
        };

        // Ucapan selamat berdasarkan waktu Asia/Jakarta
        $currentHour = Carbon::now('Asia/Jakarta')->hour;
        if ($currentHour >= 5 && $currentHour < 11) {
            $greeting = 'Selamat Pagi';
            $greetingIcon = 'mdi-weather-sunny';
        } elseif ($currentHour >= 11 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
            $greetingIcon = 'mdi-white-balance-sunny';
        } elseif ($currentHour >= 15 && $currentHour < 18) {
            $greeting = 'Selamat Sore';
            $greetingIcon = 'mdi-weather-sunset';
        } else {
            $greeting = 'Selamat Malam';
            $greetingIcon = 'mdi-weather-night';
        }

        $desa_knmp = Knmp::with(['province', 'regency', 'district', 'village'])
            ->get();

        // 1. Hitung responden yang telah mengisi survey
        $surveyQuery = InformasiResponden::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tingkat_kebahagiaan_nelayan')
                    ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
            });
        if ($startDate) {
            $surveyQuery->where('created_at', '>=', $startDate);
        }
        $totalSurveyTerisi = $surveyQuery->distinct('id')->count();

        // 2. Hitung Tingkat Kelengkapan Data (Persentase form yang diisi)
        // Setiap responden seharusnya mengisi 10 form (A-J)
        $totalResponden = InformasiResponden::count();
        $responden_dengan_data = InformasiResponden::where(function ($query) {
            $query->whereHas('tingkatKebahagiaan')
                ->orWhereHas('tanggapanMasyarakat')
                ->orWhereHas('informasiUsaha')
                ->orWhereHas('informasiPemasaran')
                ->orWhereHas('pendapatanRt')
                ->orWhereHas('sosialKelembagaan');
        })->count();

        $tingkatKelengkapanData = $totalResponden > 0
            ? round(($responden_dengan_data / $totalResponden) * 100, 2)
            : 0;

        // 3. Hitung Rata-rata Capaian Indikator (dari progres_knmp_details)
        $capaianIndikator = DB::table('progres_knmp_details')
            ->avg('persen') ?? 0;

        // 4. Hitung Rata-rata Indeks Kebahagiaan Nelayan
        $rataRataKebahagiaan = TingkatKebahagiaanNelayan::avg('skor_nilai') ?? 0;





        // ===================================
        // DATA UNTUK STATISTIK NASIONAL
        // ===================================

        // Progres KNMP Nasional (dari tabel progres_knmp_nasional)
        $progresNasional = ProgresKnmpNasional::with('knmp')
            ->orderBy('progres', 'desc')
            ->get();
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        // Rata-rata Anggota Kopdeskel
        $rataRataAnggotaKopdeskel = DB::table('profile_knmp')
            ->selectRaw('AVG(COALESCE(jumlah_anggota_laki, 0) + COALESCE(jumlah_anggota_perempuan, 0)) as avg_anggota')
            ->value('avg_anggota') ?? 0;

        // Progress Nasional
        $totalKnmpNasional = count($desa_knmp);
        $targetKnmp = 100; // Target KNMP Nasional (dapat disesuaikan)
        $progressNasional = $targetKnmp > 0 ? min(round(($totalKnmpNasional / $targetKnmp) * 100, 1), 100) : 0;

        // Total Tenaga Kerja Terserap
        $totalTenagaKerja = DB::table('progres_knmp')->sum('tk_total') ?? 0;

    
        // Jumlah provinsi yang sudah ter-cover
        // $totalProvinsiCovered = $statistikProvinsi->count();

        return view('dashboard.index', compact(
            'greeting',
            'greetingIcon',
            'period',
            'periodLabel',
            'desa_knmp',
            'totalSurveyTerisi',
            'tingkatKelengkapanData',
            'capaianIndikator',
            'rataRataKebahagiaan',
            // 'desaAsetBertambah',
            // Data untuk grafik
            // 'capaianPerKnmp',
            // 'labelKnmp',
            // 'distribusiAsetData',
            // 'distribusiAsetLabels',
            // 'penyerapanTenagaKerja',
            // 'penyerapanLabels',
            // 'tingkatKesejahteraanData',
            // 'tingkatKesejahteraanLabels',
            // Data statistik nasional
            'progressNasional',
            'totalTenagaKerja',
            // 'statistikProvinsi',
            // 'topProvinsi',
            // 'bottomProvinsi',
            // 'totalProvinsiCovered',
            'totalKnmpNasional',
            'targetKnmp',
            // Data progres nasional dan kopdeskel
            'progresNasional',
            'progresNasionalAvg',
            'rataRataAnggotaKopdeskel'
        ));
    }

    /**
     * Export Dashboard to PDF
     */
    public function exportPdf(Request $request)
    {
        // Reuse same data calculation from index()
        $period = $request->get('period', 'all');
        $periodLabel = match ($period) {
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
            default => 'Semua Waktu',
        };

        $startDate = match ($period) {
            'week' => Carbon::now('Asia/Jakarta')->startOfWeek(),
            'month' => Carbon::now('Asia/Jakarta')->startOfMonth(),
            'year' => Carbon::now('Asia/Jakarta')->startOfYear(),
            default => null,
        };

        $desa_knmp = Knmp::with(['province', 'regency', 'district', 'village'])->get();

        // Survey stats
        $surveyQuery = InformasiResponden::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tingkat_kebahagiaan_nelayan')
                    ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
            });
        if ($startDate) {
            $surveyQuery->where('created_at', '>=', $startDate);
        }
        $totalSurveyTerisi = $surveyQuery->distinct('id')->count();

        // Tingkat Kelengkapan Data
        $totalResponden = InformasiResponden::count();
        $responden_dengan_data = InformasiResponden::where(function ($query) {
            $query->whereHas('tingkatKebahagiaan')
                ->orWhereHas('tanggapanMasyarakat')
                ->orWhereHas('informasiUsaha')
                ->orWhereHas('informasiPemasaran')
                ->orWhereHas('pendapatanRt')
                ->orWhereHas('sosialKelembagaan');
        })->count();

        $tingkatKelengkapanData = $totalResponden > 0
            ? round(($responden_dengan_data / $totalResponden) * 100, 2)
            : 0;

        // Capaian Indikator
        $capaianIndikator = DB::table('progres_knmp_details')->avg('persen') ?? 0;

        // Kebahagiaan
        $rataRataKebahagiaan = TingkatKebahagiaanNelayan::avg('skor_nilai') ?? 0;







        // Tenaga Kerja
        $totalTenagaKerja = DB::table('progres_knmp')->sum('tk_total') ?? 0;

        // Progress Nasional
        $totalKnmpNasional = count($desa_knmp);
        $targetKnmp = 100;
        $progressNasional = $targetKnmp > 0 ? min(round(($totalKnmpNasional / $targetKnmp) * 100, 1), 100) : 0;

        $exportDate = Carbon::now('Asia/Jakarta')->format('d F Y H:i');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf', compact(
            'periodLabel',
            'exportDate',
            'desa_knmp',
            'totalSurveyTerisi',
            'tingkatKelengkapanData',
            'tingkatKelengkapanData',
            'capaianIndikator',
            'rataRataKebahagiaan',
            // 'desaAsetBertambah',
            // 'capaianPerKnmpData',
            // 'topProvinsi',
            // 'bottomProvinsi',
            'totalTenagaKerja',
            'progressNasional',
            'totalKnmpNasional',
            'targetKnmp'
        ))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Dashboard_KNMP_' . date('Y-m-d_His') . '.pdf';

        return $pdf->stream($filename);
    }
}
