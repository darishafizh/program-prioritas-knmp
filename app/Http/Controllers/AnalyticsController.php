<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Knmp;
use App\Models\InformasiResponden;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\ProgresKnmpNasional; // Added

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('compare', 'month'); // month, quarter, year

        $now = Carbon::now('Asia/Jakarta');

        // Define current and previous period based on selection
        switch ($period) {
            case 'quarter':
                $currentStart = $now->copy()->startOfQuarter();
                $currentEnd = $now->copy()->endOfQuarter();
                $previousStart = $currentStart->copy()->subQuarter();
                $previousEnd = $previousStart->copy()->endOfQuarter();
                $periodLabel = 'Kuartal';
                break;
            case 'year':
                $currentStart = $now->copy()->startOfYear();
                $currentEnd = $now->copy()->endOfYear();
                $previousStart = $currentStart->copy()->subYear();
                $previousEnd = $previousStart->copy()->endOfYear();
                $periodLabel = 'Tahun';
                break;
            default: // month
                $currentStart = $now->copy()->startOfMonth();
                $currentEnd = $now->copy()->endOfMonth();
                $previousStart = $currentStart->copy()->subMonth();
                $previousEnd = $previousStart->copy()->endOfMonth();
                $periodLabel = 'Bulan';
        }

        // ===================================
        // CURRENT PERIOD STATS
        // ===================================

        // Survey Terisi - konsisten dengan Dashboard (cek whereExists di tingkat_kebahagiaan_nelayan)
        $currentSurveys = InformasiResponden::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tingkat_kebahagiaan_nelayan')
                ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
        })
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->distinct('id')
            ->count();

        // KNMP dengan data progres
        $currentKnmpProgress = DB::table('progres_knmp')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->distinct('knmp_id')
            ->count('knmp_id');

        // Tenaga Kerja Terserap
        $currentTenagaKerja = DB::table('progres_knmp')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->sum('tk_total') ?? 0;

        // Rata-rata Capaian Indikator
        $currentAvgCapaian = DB::table('progres_knmp_details')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->avg('persen') ?? 0;

        // Rata-rata Indeks Kebahagiaan (current period)
        $currentKebahagiaan = TingkatKebahagiaanNelayan::whereBetween('created_at', [$currentStart, $currentEnd])
            ->avg('skor_nilai') ?? 0;

        // ===================================
        // PREVIOUS PERIOD STATS
        // ===================================

        // Survey Terisi - konsisten dengan Dashboard
        $previousSurveys = InformasiResponden::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tingkat_kebahagiaan_nelayan')
                ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
        })
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->distinct('id')
            ->count();

        $previousKnmpProgress = DB::table('progres_knmp')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->distinct('knmp_id')
            ->count('knmp_id');

        $previousTenagaKerja = DB::table('progres_knmp')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('tk_total') ?? 0;

        $previousAvgCapaian = DB::table('progres_knmp_details')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->avg('persen') ?? 0;

        $previousKebahagiaan = TingkatKebahagiaanNelayan::whereBetween('created_at', [$previousStart, $previousEnd])
            ->avg('skor_nilai') ?? 0;

        // ===================================
        // CALCULATE GROWTH PERCENTAGES
        // ===================================
        $growthSurveys = $previousSurveys > 0
            ? round((($currentSurveys - $previousSurveys) / $previousSurveys) * 100, 1)
            : ($currentSurveys > 0 ? 100 : 0);
        $growthKnmpProgress = $previousKnmpProgress > 0
            ? round((($currentKnmpProgress - $previousKnmpProgress) / $previousKnmpProgress) * 100, 1)
            : ($currentKnmpProgress > 0 ? 100 : 0);
        $growthTenagaKerja = $previousTenagaKerja > 0
            ? round((($currentTenagaKerja - $previousTenagaKerja) / $previousTenagaKerja) * 100, 1)
            : ($currentTenagaKerja > 0 ? 100 : 0);
        $growthCapaian = $previousAvgCapaian > 0
            ? round((($currentAvgCapaian - $previousAvgCapaian) / $previousAvgCapaian) * 100, 1)
            : ($currentAvgCapaian > 0 ? 100 : 0);
        $growthKebahagiaan = $previousKebahagiaan > 0
            ? round((($currentKebahagiaan - $previousKebahagiaan) / $previousKebahagiaan) * 100, 1)
            : ($currentKebahagiaan > 0 ? 100 : 0);

        // ===================================
        // COMPARISON BAR CHART DATA
        // ===================================
        $comparisonLabels = ['Survey Terisi', 'KNMP Aktif', 'Tenaga Kerja', 'Kebahagiaan'];
        $comparisonCurrent = [
            $currentSurveys,
            $currentKnmpProgress,
            $currentTenagaKerja,
            round($currentKebahagiaan, 1)
        ];
        $comparisonPrevious = [
            $previousSurveys,
            $previousKnmpProgress,
            $previousTenagaKerja,
            round($previousKebahagiaan, 1)
        ];

        // ===================================
        // TREND DATA (LAST 12 MONTHS)
        // ===================================
        $trendData = [];
        $trendLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = $now->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $now->copy()->subMonths($i)->endOfMonth();

            $trendLabels[] = $monthStart->format('M Y');

            // Survey trend - konsisten dengan Dashboard
            $trendData['surveys'][] = InformasiResponden::whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tingkat_kebahagiaan_nelayan')
                    ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
            })
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->distinct('id')
                ->count();

            $trendData['tenaga_kerja'][] = (int) (DB::table('progres_knmp')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('tk_total') ?? 0);

            $trendData['capaian'][] = round(DB::table('progres_knmp_details')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->avg('persen') ?? 0, 1);

            $trendData['kebahagiaan'][] = round(TingkatKebahagiaanNelayan::whereBetween('created_at', [$monthStart, $monthEnd])
                ->avg('skor_nilai') ?? 0, 1);
        }

        // ===================================
        // YoY COMPARISON (Year over Year)
        // ===================================
        $currentYearStart = $now->copy()->startOfYear();
        $previousYearStart = $currentYearStart->copy()->subYear();
        $previousYearEnd = $previousYearStart->copy()->endOfYear();

        $yoySurveysCurrent = InformasiResponden::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tingkat_kebahagiaan_nelayan')
                ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
        })
            ->where('created_at', '>=', $currentYearStart)
            ->distinct('id')
            ->count();

        $yoySurveysPrevious = InformasiResponden::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tingkat_kebahagiaan_nelayan')
                ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
        })
            ->whereBetween('created_at', [$previousYearStart, $previousYearEnd])
            ->distinct('id')
            ->count();

        $yoyGrowth = $yoySurveysPrevious > 0
            ? round((($yoySurveysCurrent - $yoySurveysPrevious) / $yoySurveysPrevious) * 100, 1)
            : 0;

        // ===================================
        // TOTAL STATS (ALL TIME) - untuk konteks
        // ===================================
        $totalSurveyAllTime = InformasiResponden::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tingkat_kebahagiaan_nelayan')
                ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
        })->distinct('id')->count();

        $totalKnmpAllTime = Knmp::count();
        $totalTenagaKerjaAllTime = DB::table('progres_knmp')->sum('tk_total') ?? 0;

        // ===================================
        // PROGRES KNMP NASIONAL
        // ===================================
        $progresNasional = ProgresKnmpNasional::with('knmp')->orderBy('progres', 'desc')->get();
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        return view('analytics.index', compact(
            'period',
            'periodLabel',
            'currentStart',
            'currentEnd',
            'previousStart',
            'previousEnd',
            // Current period
            'currentSurveys',
            'currentKnmpProgress',
            'currentTenagaKerja',
            'currentAvgCapaian',
            'currentKebahagiaan',
            // Previous period
            'previousSurveys',
            'previousKnmpProgress',
            'previousTenagaKerja',
            'previousAvgCapaian',
            'previousKebahagiaan',
            // Growth
            'growthSurveys',
            'growthKnmpProgress',
            'growthTenagaKerja',
            'growthCapaian',
            'growthKebahagiaan',
            // Comparison chart data
            'comparisonLabels',
            'comparisonCurrent',
            'comparisonPrevious',
            // Trend
            'trendData',
            'trendLabels',
            // YoY
            'yoySurveysCurrent',
            'yoySurveysPrevious',
            'yoyGrowth',
            // All time totals
            'totalSurveyAllTime',
            'totalKnmpAllTime',
            'totalTenagaKerjaAllTime',
            // Progres Nasional
            'progresNasional',
            'progresNasionalAvg'
        ));
    }
}
