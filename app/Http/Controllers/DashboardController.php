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

        // 5. Hitung Jumlah Desa dengan Aset Bertambah (KNMP yang punya data ProgresKnmp)
        $desaAsetBertambah = DB::table('progres_knmp')
            ->distinct('knmp_id')
            ->count('knmp_id');

        // ===================================
        // DATA UNTUK GRAFIK
        // ===================================

        // Chart 1: Capaian Indikator per KNMP
        $capaianPerKnmpData = DB::table('progres_knmp_details')
            ->join('progres_knmp', 'progres_knmp_details.progres_id', '=', 'progres_knmp.id')
            ->join('knmp', 'progres_knmp.knmp_id', '=', 'knmp.id')
            ->select('knmp.nama', DB::raw('COALESCE(AVG(progres_knmp_details.persen), 0) as avg_persen'))
            ->groupBy('knmp.id', 'knmp.nama')
            ->orderBy('knmp.id')
            ->limit(10)
            ->get();

        $labelKnmp = $capaianPerKnmpData->pluck('nama')->toArray();
        $capaianPerKnmp = $capaianPerKnmpData->pluck('avg_persen')->map(function ($val) {
            return round($val, 2);
        })->toArray();

        // Chart 2: Distribusi Kategori Aset (berdasarkan kolom 'komponen')
        $distribusiAset = DB::table('progres_knmp_details')
            ->select('komponen', DB::raw('COUNT(*) as total'))
            ->whereNotNull('komponen')
            ->groupBy('komponen')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $distribusiAsetLabels = $distribusiAset->pluck('komponen')->toArray();
        $distribusiAsetData = $distribusiAset->pluck('total')->toArray();

        // Chart 3: Penyerapan Tenaga Kerja (dari progres_knmp per bulan)
        $penyerapanData = DB::table('progres_knmp')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COALESCE(SUM(tk_total), 0) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $penyerapanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $penyerapanTenagaKerja = [];
        for ($i = 1; $i <= 12; $i++) {
            $penyerapanTenagaKerja[] = isset($penyerapanData[$i]) ? (int) $penyerapanData[$i]->total : 0;
        }

        // Chart 4: Tingkat Kesejahteraan (berdasarkan kategori skor kebahagiaan)
        $kesejahteraanStats = DB::table('tingkat_kebahagiaan_nelayan')
            ->select(DB::raw('
                SUM(CASE WHEN skor_nilai >= 8 THEN 1 ELSE 0 END) as sangat_sejahtera,
                SUM(CASE WHEN skor_nilai >= 6 AND skor_nilai < 8 THEN 1 ELSE 0 END) as sejahtera,
                SUM(CASE WHEN skor_nilai >= 4 AND skor_nilai < 6 THEN 1 ELSE 0 END) as cukup_sejahtera,
                SUM(CASE WHEN skor_nilai < 4 THEN 1 ELSE 0 END) as kurang_sejahtera,
                COUNT(*) as total
            '))
            ->first();

        $totalKesejahteraan = $kesejahteraanStats->total ?: 1;
        $tingkatKesejahteraanLabels = ['Sangat Sejahtera', 'Sejahtera', 'Cukup Sejahtera', 'Kurang Sejahtera'];
        $tingkatKesejahteraanData = [
            round(($kesejahteraanStats->sangat_sejahtera / $totalKesejahteraan) * 100, 0),
            round(($kesejahteraanStats->sejahtera / $totalKesejahteraan) * 100, 0),
            round(($kesejahteraanStats->cukup_sejahtera / $totalKesejahteraan) * 100, 0),
            round(($kesejahteraanStats->kurang_sejahtera / $totalKesejahteraan) * 100, 0),
        ];

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
            'desaAsetBertambah',
            // Data untuk grafik
            'capaianPerKnmp',
            'labelKnmp',
            'distribusiAsetData',
            'distribusiAsetLabels',
            'penyerapanTenagaKerja',
            'penyerapanLabels',
            'tingkatKesejahteraanData',
            'tingkatKesejahteraanLabels'
        ));
    }
}
