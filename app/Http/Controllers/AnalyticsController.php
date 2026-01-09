<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Knmp;
use App\Models\InformasiResponden;
use App\Models\TingkatKebahagiaanNelayan;

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
        $currentSurveys = InformasiResponden::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $currentKnmpProgress = DB::table('progres_knmp')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->count();
        $currentTenagaKerja = DB::table('progres_knmp')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->sum('tk_total') ?? 0;
        $currentAvgCapaian = DB::table('progres_knmp_details')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->avg('persen') ?? 0;

        // ===================================
        // PREVIOUS PERIOD STATS
        // ===================================
        $previousSurveys = InformasiResponden::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $previousKnmpProgress = DB::table('progres_knmp')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();
        $previousTenagaKerja = DB::table('progres_knmp')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('tk_total') ?? 0;
        $previousAvgCapaian = DB::table('progres_knmp_details')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->avg('persen') ?? 0;

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

        // ===================================
        // TREND DATA (LAST 12 MONTHS)
        // ===================================
        $trendData = [];
        $trendLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = $now->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $now->copy()->subMonths($i)->endOfMonth();

            $trendLabels[] = $monthStart->format('M Y');

            $trendData['surveys'][] = InformasiResponden::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $trendData['tenaga_kerja'][] = (int) (DB::table('progres_knmp')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('tk_total') ?? 0);
            $trendData['capaian'][] = round(DB::table('progres_knmp_details')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->avg('persen') ?? 0, 1);
        }

        // ===================================
        // YoY COMPARISON (Year over Year)
        // ===================================
        $currentYearStart = $now->copy()->startOfYear();
        $previousYearStart = $currentYearStart->copy()->subYear();
        $previousYearEnd = $previousYearStart->copy()->endOfYear();

        $yoySurveysCurrent = InformasiResponden::where('created_at', '>=', $currentYearStart)->count();
        $yoySurveysPrevious = InformasiResponden::whereBetween('created_at', [$previousYearStart, $previousYearEnd])->count();
        $yoyGrowth = $yoySurveysPrevious > 0
            ? round((($yoySurveysCurrent - $yoySurveysPrevious) / $yoySurveysPrevious) * 100, 1)
            : 0;

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
            // Previous period
            'previousSurveys',
            'previousKnmpProgress',
            'previousTenagaKerja',
            'previousAvgCapaian',
            // Growth
            'growthSurveys',
            'growthKnmpProgress',
            'growthTenagaKerja',
            'growthCapaian',
            // Trend
            'trendData',
            'trendLabels',
            // YoY
            'yoySurveysCurrent',
            'yoySurveysPrevious',
            'yoyGrowth'
        ));
    }
}
