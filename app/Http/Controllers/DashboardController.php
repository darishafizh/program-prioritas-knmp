<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\InformasiResponden;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\TargetRealisasi;
use App\Models\InformasiPendapatanRumahTangga;
use App\Models\SosialKelembagaan;
use App\Models\ProfileKnmp;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Knmp;
use App\Models\ProgresKnmpNasional;
use App\Models\TanggapanMasyarakat;

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

        // Filter tahap
        $tahap = $request->get('tahap', 'all');
        $tahapLabel = $tahap !== 'all' ? 'Tahap ' . $tahap : 'Semua Tahap';

        $desa_knmp_query = Knmp::with([
            'province:id,name',
            'regency:id,name',
            'district:id,name',
            'village:id,name',
            'profileKnmp',
            'progresKnmp',
            'latestProgresNasional',
        ])
            ->withCount('informasiResponden');

        if ($tahap !== 'all') {
            $desa_knmp_query->where('tahap', $tahap);
        }

        $desa_knmp = $desa_knmp_query->get();
        $knmpIds = $desa_knmp->pluck('id')->toArray();

        // 1. Hitung responden yang telah mengisi survey
        $surveyQuery = InformasiResponden::query()
            ->whereIn('knmp_id', $knmpIds)
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
        $totalResponden = InformasiResponden::whereIn('knmp_id', $knmpIds)->count();
        $responden_dengan_data = InformasiResponden::whereIn('knmp_id', $knmpIds)->where(function ($query) {
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
            ->whereIn('progres_id', function ($q) use ($knmpIds) {
                $q->select('id')->from('progres_knmp')->whereIn('knmp_id', $knmpIds);
            })
            ->avg('persen') ?? 0;

        // 4. Hitung Rata-rata Indeks Kebahagiaan Nelayan
        $rataRataKebahagiaan = TingkatKebahagiaanNelayan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->avg('skor_nilai') ?? 0;

        // ===================================
        // DATA UNTUK STATISTIK NASIONAL
        // ===================================

        // Progres KNMP Nasional (dari tabel progres_knmp_nasional)
        // Get available dates for filter dropdown (filtered by tahap via knmp_id)
        $availableProgressDates = ProgresKnmpNasional::whereIn('knmp_id', $knmpIds)
            ->selectRaw('DISTINCT tanggal')
            ->whereNotNull('tanggal')
            ->orderBy('tanggal', 'desc')
            ->pluck('tanggal')
            ->toArray();

        // Get selected date from request or use latest available
        $selectedProgresDate = $request->get('progres_date');
        if (!$selectedProgresDate && count($availableProgressDates) > 0) {
            $selectedProgresDate = $availableProgressDates[0]; // Latest date
        }

        $deltaPeriod = $request->get('delta_period', 'latest');
        
        // Determine previous date for delta calculation
        $previousDate = null;
        if ($deltaPeriod === 'weekly') {
            $targetWeeklyDate = \Carbon\Carbon::parse($selectedProgresDate)->subDays(7)->format('Y-m-d');
            foreach ($availableProgressDates as $date) {
                if ($date <= $targetWeeklyDate) {
                    $previousDate = $date;
                    break;
                }
            }
        } else {
            $currentIndex = array_search($selectedProgresDate, $availableProgressDates);
            if ($currentIndex !== false && isset($availableProgressDates[$currentIndex + 1])) {
                $previousDate = $availableProgressDates[$currentIndex + 1];
            }
        }

        // Data for Trend Line Chart
        $trendDataQuery = ProgresKnmpNasional::whereIn('knmp_id', $knmpIds)
            ->select('tanggal', DB::raw('AVG(progres) as avg_progres'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
        $trendDates = $trendDataQuery->pluck('tanggal')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M y'))->toArray();
        $trendAverages = $trendDataQuery->pluck('avg_progres')->map(fn($val) => round($val, 2))->toArray();

        // Query progres data by selected date
        $progresNasionalQuery = ProgresKnmpNasional::with('knmp')
            ->whereIn('knmp_id', $knmpIds)
            ->orderBy('progres', 'desc');
        if ($selectedProgresDate) {
            $progresNasionalQuery->where('tanggal', $selectedProgresDate);
        }
        $progresNasional = $progresNasionalQuery->get()->unique('knmp_id')->values();
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        // Fetch previous progress data to calculate delta
        $previousProgresData = [];
        if ($previousDate) {
            $previousProgresData = ProgresKnmpNasional::whereIn('knmp_id', $knmpIds)
                ->where('tanggal', $previousDate)
                ->pluck('progres', 'knmp_id')
                ->toArray();
        }

        // Attach delta to each KNMP
        foreach ($progresNasional as $item) {
            $prevProgres = $previousProgresData[$item->knmp_id] ?? $item->progres; // if no previous, delta is 0
            $item->delta = $item->progres - $prevProgres;
        }

        // ===================================
        // NEW KPI CALCULATIONS
        // ===================================

        // 1. Total KNMP (sudah ada: count($desa_knmp))
        $totalKnmp = count($desa_knmp);

        // Progress Nasional
        $totalKnmpNasional = count($desa_knmp);
        $targetKnmp = 100; // Target KNMP Nasional (dapat disesuaikan)
        $progressNasional = $targetKnmp > 0 ? min(round(($totalKnmpNasional / $targetKnmp) * 100, 1), 100) : 0;

        // Total Tenaga Kerja Terserap
        $totalTenagaKerja = DB::table('progres_knmp')->whereIn('knmp_id', $knmpIds)->sum('tk_total') ?? 0;

        // Available tahap values for filter
        $availableTahap = Knmp::whereNotNull('tahap')->distinct()->orderBy('tahap')->pluck('tahap')->toArray();


        return view('dashboard.index', compact(
            'greeting',
            'greetingIcon',
            'period',
            'periodLabel',
            'tahap',
            'tahapLabel',
            'availableTahap',
            'desa_knmp',
            'totalSurveyTerisi',
            'tingkatKelengkapanData',
            'capaianIndikator',
            'rataRataKebahagiaan',
            // Data statistik nasional
            'progressNasional',
            'totalTenagaKerja',
            'totalKnmpNasional',
            'targetKnmp',
            // Data progres nasional dan kopdeskel
            'progresNasional',
            'progresNasionalAvg',
            'availableProgressDates',
            'selectedProgresDate',
            'deltaPeriod',
            'trendDates',
            'trendAverages',
            // New KPI data
            'totalKnmp'
        ));
    }

    /**
     * API endpoint for real-time dashboard data (AJAX polling)
     */
    public function apiData(Request $request)
    {
        $period = $request->get('period', 'all');
        $startDate = match ($period) {
            'week' => Carbon::now('Asia/Jakarta')->startOfWeek(),
            'month' => Carbon::now('Asia/Jakarta')->startOfMonth(),
            'year' => Carbon::now('Asia/Jakarta')->startOfYear(),
            default => null,
        };

        $tahap = $request->get('tahap', 'all');
        $desa_knmp_query = Knmp::with([
            'province',
            'regency',
            'district',
            'village',
            'profileKnmp',
            'progresKnmp',
            'latestProgresNasional',
        ])->withCount('informasiResponden');

        if ($tahap !== 'all') {
            $desa_knmp_query->where('tahap', $tahap);
        }

        $desa_knmp = $desa_knmp_query->get();
        $knmpIds = $desa_knmp->pluck('id')->toArray();

        // 1. Responden yang telah mengisi survey
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

        // 2. Tingkat Kelengkapan Data
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
            ? round(($responden_dengan_data / $totalResponden) * 100, 2) : 0;

        // 3. Rata-rata Capaian Indikator
        $capaianIndikator = DB::table('progres_knmp_details')->avg('persen') ?? 0;

        // 4. Rata-rata Indeks Kebahagiaan
        $rataRataKebahagiaan = TingkatKebahagiaanNelayan::avg('skor_nilai') ?? 0;

        // Progres KNMP Nasional
        $selectedProgresDate = $request->get('progres_date');
        if (!$selectedProgresDate) {
            $selectedProgresDate = ProgresKnmpNasional::selectRaw('DISTINCT tanggal')
                ->whereNotNull('tanggal')->orderBy('tanggal', 'desc')->value('tanggal');
        }
        $progresNasionalQuery = ProgresKnmpNasional::with('knmp')->orderBy('progres', 'desc');
        if ($selectedProgresDate) {
            $progresNasionalQuery->where('tanggal', $selectedProgresDate);
        }
        $progresNasional = $progresNasionalQuery->get();
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        // KPI Calculations
        $totalKnmp = count($desa_knmp);

        // Ketersediaan Infrastruktur
        $infraColumns = [
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
            'infra_waserda'
        ];
        $profiles = ProfileKnmp::select($infraColumns)->get();
        $totalPercentage = 0;
        $countProfiles = $profiles->count();
        foreach ($profiles as $profile) {
            $filledCount = 0;
            foreach ($infraColumns as $col) {
                if ($profile->$col)
                    $filledCount++;
            }
            $totalPercentage += ($filledCount / 12) * 100;
        }
        $ketersediaanInfrastruktur = $countProfiles > 0 ? round($totalPercentage / $countProfiles, 2) : 0;

        // Indeks Kesesuaian Kebutuhan
        $totalTanggapan = TanggapanMasyarakat::count();
        $sesuaiKebutuhan = TanggapanMasyarakat::where('kesesuaian_kebutuhan', 1)->count();
        $indeksKesesuaianKebutuhan = $totalTanggapan > 0
            ? round(($sesuaiKebutuhan / $totalTanggapan) * 100, 2) : 0;

        // Pendapatan RT Nelayan
        $pendapatanRtNelayan = InformasiPendapatanRumahTangga::avg('pendapatan_total') ?? 0;

        // Indeks Kesejahteraan
        $indeksKesejahteraan = round($rataRataKebahagiaan, 2);

        // Tingkat Kelembagaan
        $totalSosial = SosialKelembagaan::count();
        $anggotaKelompokKoperasi = SosialKelembagaan::where(function ($q) {
            $q->where('anggota_kelompok', '>=', 3)->orWhere('anggota_koperasi', '>=', 3);
        })->count();
        $tingkatKelembagaan = $totalSosial > 0
            ? round(($anggotaKelompokKoperasi / $totalSosial) * 100, 2) : 0;

        // Total Tenaga Kerja
        $totalTenagaKerja = DB::table('progres_knmp')->sum('tk_total') ?? 0;

        // Progres Nasional table data
        $progresNasionalData = $progresNasional->map(function ($item) {
            return [
                'nama' => $item->knmp ? $item->knmp->nama : 'KNMP #' . $item->knmp_id,
                'progres' => round($item->progres, 2),
            ];
        })->values();

        return response()->json([
            'totalKnmp' => number_format($totalKnmp, 0, ',', '.'),
            'ketersediaanInfrastruktur' => number_format($ketersediaanInfrastruktur, 2, ',', '.') . '%',
            'pendapatanRtNelayan' => 'Rp ' . number_format($pendapatanRtNelayan, 0, ',', '.'),
            'indeksKesesuaianKebutuhan' => number_format($indeksKesesuaianKebutuhan, 2, ',', '.') . '%',
            'indeksKesejahteraan' => number_format($indeksKesejahteraan, 2, ',', '.'),
            'tingkatKelembagaan' => number_format($tingkatKelembagaan, 2, ',', '.') . '%',
            'progresNasionalAvg' => number_format($progresNasionalAvg, 2),
            'progresNasionalCount' => count($progresNasional),
            'progresNasionalSelesai' => $progresNasional->where('progres', 100)->count(),
            'progresNasionalData' => $progresNasionalData,
            'totalSurveyTerisi' => $totalSurveyTerisi,
            'tingkatKelengkapanData' => $tingkatKelengkapanData,
            'timestamp' => now()->format('H:i:s'),
        ]);
    }

    /**
     * Export Dashboard to PDF
     */
    public function exportPdf(Request $request)
    {
        $tahap = $request->get('tahap', 'all');
        $selectedProgresDate = $request->get('progres_date');

        $desa_knmp_query = Knmp::with([
            'province:id,name', 'regency:id,name', 'district:id,name', 'village:id,name',
            'progresKnmp', 'latestProgresNasional', 'buktiUploads',
        ]);

        if ($tahap !== 'all') {
            $desa_knmp_query->where('tahap', $tahap);
        }

        $desa_knmp = $desa_knmp_query->orderBy('id')->get();
        $knmpIds = $desa_knmp->pluck('id')->toArray();

        // Get progres nasional for selected date
        $progresData = [];
        if (!$selectedProgresDate) {
            $selectedProgresDate = ProgresKnmpNasional::whereIn('knmp_id', $knmpIds)
                ->whereNotNull('tanggal')->orderBy('tanggal', 'desc')->value('tanggal');
        }
        if ($selectedProgresDate) {
            $progresData = ProgresKnmpNasional::whereIn('knmp_id', $knmpIds)
                ->where('tanggal', $selectedProgresDate)->pluck('progres', 'knmp_id')->toArray();
        }

        $avgProgres = count($progresData) > 0 ? round(array_sum($progresData) / count($progresData), 2) : 0;

        // Build table data
        $tableData = [];
        foreach ($desa_knmp as $knmp) {
            $progres = $progresData[$knmp->id] ?? 0;
            
            // Kolom lokasi baris 1 (nama knmp) dan baris 2 (Kec, Kab, Prov)
            $lokasi_baris_1 = $knmp->nama;
            
            // Format baris 2: Kecamatan, Kabupaten, Provinsi
            $lokasi_parts = [];
            if ($knmp->district) $lokasi_parts[] = 'Kec. ' . ucwords(strtolower($knmp->district->name));
            if ($knmp->regency) $lokasi_parts[] = ucwords(strtolower($knmp->regency->name));
            if ($knmp->province) $lokasi_parts[] = ucwords(strtolower($knmp->province->name));
            $lokasi_baris_2 = implode(', ', $lokasi_parts);

            $tableData[] = [
                'nama_knmp' => $knmp->nama, // Used for photos
                'lokasi_1' => $lokasi_baris_1,
                'lokasi_2' => $lokasi_baris_2,
                'nama_penyedia' => '', // Dikososngkan untuk saat ini
                'progres' => round($progres, 2),
                'keterangan' => '', // Dikosongkan untuk saat ini
            ];
        }

        // Group photos by island
        $islandMapping = [
            'Sumatera' => ['ACEH','SUMATERA UTARA','SUMATERA BARAT','RIAU','JAMBI','SUMATERA SELATAN','BENGKULU','LAMPUNG','KEPULAUAN BANGKA BELITUNG','KEPULAUAN RIAU'],
            'Jawa' => ['DKI JAKARTA','JAWA BARAT','JAWA TENGAH','DAERAH ISTIMEWA YOGYAKARTA','JAWA TIMUR','BANTEN'],
            'Kalimantan' => ['KALIMANTAN BARAT','KALIMANTAN TENGAH','KALIMANTAN SELATAN','KALIMANTAN TIMUR','KALIMANTAN UTARA'],
            'Sulawesi' => ['SULAWESI UTARA','SULAWESI TENGAH','SULAWESI SELATAN','SULAWESI TENGGARA','GORONTALO','SULAWESI BARAT'],
            'Bali & Nusa Tenggara' => ['BALI','NUSA TENGGARA BARAT','NUSA TENGGARA TIMUR'],
            'Maluku' => ['MALUKU','MALUKU UTARA'],
            'Papua' => ['PAPUA','PAPUA BARAT','PAPUA SELATAN','PAPUA TENGAH','PAPUA PEGUNUNGAN','PAPUA BARAT DAYA'],
        ];

        $photosByIsland = [];
        foreach ($desa_knmp as $knmp) {
            if ($knmp->buktiUploads->isEmpty()) continue;
            $provinceName = strtoupper(optional($knmp->province)->name ?? '');
            $island = 'Lainnya';
            foreach ($islandMapping as $pulau => $provinces) {
                if (in_array($provinceName, $provinces)) { $island = $pulau; break; }
            }
            $photos = $knmp->buktiUploads->filter(function ($b) {
                return str_contains(strtolower($b->tipe_file ?? ''), 'image/') && strtolower($b->kondisi ?? '') === 'after';
            })->take(1);
            if ($photos->isNotEmpty()) {
                $photosByIsland[$island][] = [
                    'nama' => $knmp->nama,
                    'lokasi' => optional($knmp->regency)->name . ', ' . optional($knmp->province)->name,
                    'photos' => $photos,
                ];
            }
        }
        ksort($photosByIsland);

        $tahapLabel = $tahap !== 'all' ? ($tahap == 1 ? 'I' : ($tahap == 2 ? 'II' : ($tahap == 3 ? 'III' : $tahap))) : 'Semua';
        $exportDate = Carbon::now('Asia/Jakarta')->format('d F Y');
        $totalLokasi = count($desa_knmp);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf', compact(
            'tahap', 'tahapLabel', 'exportDate', 'totalLokasi', 'avgProgres',
            'tableData', 'photosByIsland', 'selectedProgresDate'
        ))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Progres_KNMP_Tahap_' . $tahapLabel . '_' . date('Y-m-d') . '.pdf';
        return $pdf->stream($filename);
    }
}
