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
use App\Models\ProgresHarian;
use App\Models\TanggapanMasyarakat;
use App\Models\TahapKonstruksi;

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

        // Filter tahap (sekarang menggunakan batch_id)
        $tahap = $request->get('tahap', 'all');
        $tahapLabel = 'Semua Tahap';
        if ($tahap !== 'all') {
            $batchObj = \App\Models\Batch::find($tahap);
            $tahapLabel = $batchObj ? $batchObj->nama_tahap : 'Tahap ' . $tahap;
        }

        $desa_knmp_query = Knmp::with([
            'profileKnmp',
            'progresKnmp',
            'latestProgresNasional',
        ])
            ->withCount('informasiResponden');

        if ($tahap !== 'all') {
            $desa_knmp_query->where('batch_id', $tahap);
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

        // Progres KNMP Nasional (dari tabel progres_harian)
        // Get available dates for filter dropdown (filtered by tahap via knmp_id)
        $availableProgressDates = ProgresHarian::whereIn('knmp_id', $knmpIds)
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
        $trendDataQuery = ProgresHarian::whereIn('knmp_id', $knmpIds)
            ->select('tanggal', DB::raw('AVG(progres) as avg_progres'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
        $trendDates = $trendDataQuery->pluck('tanggal')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M y'))->toArray();
        $trendAverages = $trendDataQuery->pluck('avg_progres')->map(fn($val) => round($val, 2))->toArray();

        // Query progres data up to selected date (OPTIMIZED)
        $latestIds = DB::table('progres_harian as ph')
            ->selectRaw('MAX(ph.id) as id')
            ->joinSub(function ($query) use ($knmpIds, $selectedProgresDate) {
                $query->from('progres_harian')
                    ->select('knmp_id', DB::raw('MAX(tanggal) as max_tanggal'))
                    ->whereIn('knmp_id', $knmpIds);
                if ($selectedProgresDate) {
                    $query->where('tanggal', '<=', $selectedProgresDate);
                }
                $query->groupBy('knmp_id');
            }, 'max_dates', function ($join) {
                $join->on('ph.knmp_id', '=', 'max_dates.knmp_id')
                     ->on('ph.tanggal', '=', 'max_dates.max_tanggal');
            })
            ->groupBy('ph.knmp_id', 'ph.tanggal')
            ->pluck('id');

        $progresNasional = DB::table('progres_harian as ph')
            ->join('knmp as k', 'ph.knmp_id', '=', 'k.id')
            ->leftJoin('batch as b', 'k.batch_id', '=', 'b.id')
            ->leftJoin('konstruksi_knmp as kk', 'k.id', '=', 'kk.knmp_id')
            ->leftJoin('penyedia_jasa_konstruksi as pj', 'kk.jasa_konstruksi_id', '=', 'pj.id')
            ->whereIn('ph.id', $latestIds)
            ->select(
                'ph.*',
                'k.nama as knmp_nama',
                'k.kabupaten',
                'k.provinsi',
                'k.kecamatan',
                'k.tahap_saat_ini',
                'k.batch_id',
                'b.nama_tahap as batch_nama',
                'kk.tanggal_mulai',
                'pj.nama as nama_jasa_konstruksi'
            )
            ->orderBy('ph.progres', 'desc')
            ->get();
            
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        // Fetch previous progress data to calculate delta (OPTIMIZED)
        $previousProgresData = [];
        if ($previousDate) {
            $prevIds = DB::table('progres_harian as ph')
                ->selectRaw('MAX(ph.id) as id')
                ->joinSub(function ($query) use ($knmpIds, $previousDate) {
                    $query->from('progres_harian')
                        ->select('knmp_id', DB::raw('MAX(tanggal) as max_tanggal'))
                        ->whereIn('knmp_id', $knmpIds)
                        ->where('tanggal', '<=', $previousDate)
                        ->groupBy('knmp_id');
                }, 'max_dates', function ($join) {
                    $join->on('ph.knmp_id', '=', 'max_dates.knmp_id')
                         ->on('ph.tanggal', '=', 'max_dates.max_tanggal');
                })
                ->groupBy('ph.knmp_id', 'ph.tanggal')
                ->pluck('id');
            
            $previousProgresData = ProgresHarian::whereIn('id', $prevIds)
                ->pluck('progres', 'knmp_id')
                ->toArray();
        }

        // Attach delta to each KNMP
        foreach ($progresNasional as $item) {
            $prevProgres = $previousProgresData[$item->knmp_id] ?? $item->progres; // if no previous, delta is 0
            $item->delta = $item->progres - $prevProgres;
        }

        // ===================================
        // ANALISIS PROGRES KNMP
        // ===================================

        // 1. Sebaran persentase progres (5 kriteria)
        $sebaranProgres = [
            '0-20%' => 0,
            '21-40%' => 0,
            '41-60%' => 0,
            '61-80%' => 0,
            '81-100%' => 0,
        ];
        foreach ($progresNasional as $item) {
            $p = $item->progres;
            if ($p <= 20) $sebaranProgres['0-20%']++;
            elseif ($p <= 40) $sebaranProgres['21-40%']++;
            elseif ($p <= 60) $sebaranProgres['41-60%']++;
            elseif ($p <= 80) $sebaranProgres['61-80%']++;
            else $sebaranProgres['81-100%']++;
        }

        // Hitung deviasi secara dinamis berdasarkan tanggal_mulai
        $deviasiData = [];
        if (!$progresNasional->isEmpty()) {
            // Ambil semua data konstruksi dan timeline
            $allKonstruksi = DB::table('konstruksi_knmp')
                ->whereIn('knmp_id', $knmpIds)
                ->get()
                ->keyBy('knmp_id');

            $allTimelines = DB::table('tahap_konstruksi')
                ->whereIn('knmp_konstruksi_id', $allKonstruksi->pluck('id'))
                ->orderBy('periode_mingguan')
                ->get()
                ->groupBy('knmp_konstruksi_id');

            // Tanggal acuan: gunakan tanggal saat ini untuk menentukan minggu keberapa
            $todayDate = $selectedProgresDate ? \Carbon\Carbon::parse($selectedProgresDate) : \Carbon\Carbon::now();

            foreach ($progresNasional as $item) {
                $kId = $item->knmp_id;
                $progresAktual = (float)$item->progres;
                
                $konstruksi = $allKonstruksi->get($kId);
                if (!$konstruksi) {
                    $deviasiData[$kId] = 0;
                    continue;
                }

                $timelines = $allTimelines->get($konstruksi->id) ?? collect();
                $startDate = $konstruksi->tanggal_mulai ? \Carbon\Carbon::parse($konstruksi->tanggal_mulai) : null;

                if (!$startDate || $timelines->isEmpty()) {
                    $rencanaRaw = 0;
                } else {
                    // Hitung minggu saat ini: dari tanggal_mulai ke tanggal hari ini
                    $diffDays = $startDate->diffInDays($todayDate, false);
                    $currentWeek = max(1, (int) floor($diffDays / 7) + 1);
                    
                    // Cari bobot rencana kumulatif untuk minggu tersebut
                    $tlRencana = $timelines->where('periode_mingguan', $currentWeek)->first();
                    if (!$tlRencana) {
                        // Jika sudah lewat total minggu, gunakan minggu terakhir
                        $tlRencana = $timelines->sortByDesc('periode_mingguan')->first();
                    }
                    $rencanaRaw = $tlRencana ? $tlRencana->bobot_rencana_kumulatif : 0;
                }
                
                // Simpan data rencana pada item
                $item->rencana_kumulatif = $rencanaRaw;

                // Normalisasi jika data rencana menggunakan skala permil (max > 100)
                $maxPlan = $timelines->max('bobot_rencana_kumulatif') ?? 100;
                $scale = $maxPlan > 100 ? $maxPlan / 100 : 1;
                $rencanaPersen = round((float)$rencanaRaw / $scale, 2);
                
                // Deviasi = progres terbaru - rencana di minggu saat ini
                $deviasiData[$kId] = round($progresAktual - $rencanaPersen, 2);
            }
        }

        foreach ($progresNasional as $item) {
            $item->deviasi = $deviasiData[$item->knmp_id] ?? 0;
        }

        // Filter hanya yang progresnya < 100 untuk list performa
        $activeProgresNasional = $progresNasional->filter(function($item) {
            return (float)$item->progres < 100;
        });

        // 2. Performa 10 KNMP tertinggi deviasinya (deviasi >= 0)
        $top10Knmp = $activeProgresNasional
            ->filter(function($item) {
                return (float)$item->deviasi >= 0;
            })
            ->sortByDesc('deviasi')
            ->take(10)
            ->values();

        // 3. Performa 10 KNMP terendah deviasinya (deviasi < 0)
        $bottom10Knmp = $activeProgresNasional
            ->filter(function($item) {
                return (float)$item->deviasi < 0;
            })
            ->sortBy('deviasi')
            ->take(10)
            ->values();

        // Cek status penyelesaian per tahap (apakah semua 100%)
        $tahapSelesaiStatus = $progresNasional->groupBy('batch_id')->map(function ($items) {
            return $items->count() > 0 && $items->every(function ($item) {
                return (float)$item->progres >= 100;
            });
        });

        // Critical alert (stagnan 5 hari) — hanya berlaku untuk progres < 100
        $fiveDaysAgo = \Carbon\Carbon::parse($selectedProgresDate)->subDays(5)->format('Y-m-d');

        $top10Ids = $top10Knmp->pluck('knmp_id')->toArray();
        $bottom10Ids = $bottom10Knmp->pluck('knmp_id')->toArray();
        $allCheckIds = array_unique(array_merge($top10Ids, $bottom10Ids));

        $pastProgresData = collect();
        if (count($allCheckIds) > 0) {
            $pastProgresData = ProgresHarian::whereIn('knmp_id', $allCheckIds)
                ->where('tanggal', '<=', $fiveDaysAgo)
                ->orderBy('tanggal', 'desc')
                ->get()
                ->groupBy('knmp_id')
                ->map(function ($items) {
                    return $items->first();
                });
        }

        $applyStagnanFlag = function ($collection) use ($pastProgresData) {
            foreach ($collection as $item) {
                $item->is_stagnan = false;
                $item->past_progres = null;
                $item->past_progres_date = null;
                $item->is_complete = ((float) $item->progres) >= 100;

                $past = $pastProgresData[$item->knmp_id] ?? null;
                if ($past !== null) {
                    $item->past_progres = $past->progres;
                    $item->past_progres_date = $past->tanggal;
                    if (! $item->is_complete && (float) $item->progres == (float) $past->progres) {
                        $item->is_stagnan = true;
                    }
                }
            }
        };
        $applyStagnanFlag($top10Knmp);
        $applyStagnanFlag($bottom10Knmp);

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
        $availableTahap = \App\Models\Batch::orderBy('id')->get();


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
            'totalKnmp',
            // Analisis Progres
            'sebaranProgres',
            'top10Knmp',
            'bottom10Knmp',
            'tahapSelesaiStatus',
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
            'profileKnmp',
            'progresKnmp',
            'latestProgresNasional',
        ])->withCount('informasiResponden');

        if ($tahap !== 'all') {
            $desa_knmp_query->where('batch_id', $tahap);
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
        $rataRataKebahagiaan = TingkatKebahagiaanNelayan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->avg('skor_nilai') ?? 0;

        // Progres KNMP Nasional
        $selectedProgresDate = $request->get('progres_date');
        if (!$selectedProgresDate) {
            $selectedProgresDate = ProgresHarian::selectRaw('DISTINCT tanggal')
                ->whereNotNull('tanggal')->orderBy('tanggal', 'desc')->value('tanggal');
        }
        // Mendapatkan ID terbaru per KNMP
        $latestIds = DB::table('progres_harian as ph')
            ->selectRaw('MAX(ph.id) as id')
            ->joinSub(function ($query) use ($knmpIds, $selectedProgresDate) {
                $query->from('progres_harian')
                    ->select('knmp_id', DB::raw('MAX(tanggal) as max_tanggal'))
                    ->whereIn('knmp_id', $knmpIds);
                if ($selectedProgresDate) {
                    $query->where('tanggal', '<=', $selectedProgresDate);
                }
                $query->groupBy('knmp_id');
            }, 'max_dates', function ($join) {
                $join->on('ph.knmp_id', '=', 'max_dates.knmp_id')
                     ->on('ph.tanggal', '=', 'max_dates.max_tanggal');
            })
            ->groupBy('ph.knmp_id', 'ph.tanggal')
            ->pluck('id');

        $progresNasional = DB::table('progres_harian as ph')
            ->join('knmp as k', 'ph.knmp_id', '=', 'k.id')
            ->leftJoin('batch as b', 'k.batch_id', '=', 'b.id')
            ->leftJoin('konstruksi_knmp as kk', 'k.id', '=', 'kk.knmp_id')
            ->leftJoin('penyedia_jasa_konstruksi as pj', 'kk.jasa_konstruksi_id', '=', 'pj.id')
            ->whereIn('ph.id', $latestIds)
            ->select(
                'ph.*',
                'k.nama as knmp_nama',
                'k.kabupaten',
                'k.provinsi',
                'k.kecamatan',
                'k.tahap_saat_ini',
                'k.batch_id',
                'b.nama_tahap as batch_nama',
                'kk.tanggal_mulai',
                'pj.nama as nama_jasa_konstruksi'
            )
            ->orderBy('ph.progres', 'desc')
            ->get();
        
        // --- START DELTA CALCULATION ---
        $availableProgressDates = ProgresHarian::whereIn('knmp_id', $knmpIds)
            ->selectRaw('DISTINCT tanggal')
            ->whereNotNull('tanggal')
            ->orderBy('tanggal', 'desc')
            ->pluck('tanggal')
            ->toArray();

        $previousDate = null;
        $currentIndex = array_search($selectedProgresDate, $availableProgressDates);
        if ($currentIndex !== false && isset($availableProgressDates[$currentIndex + 1])) {
            $previousDate = $availableProgressDates[$currentIndex + 1];
        }

        $previousProgresData = [];
        if ($previousDate) {
            $prevIds = DB::table('progres_harian as ph')
                ->selectRaw('MAX(ph.id) as id')
                ->joinSub(function ($query) use ($knmpIds, $previousDate) {
                    $query->from('progres_harian')
                        ->select('knmp_id', DB::raw('MAX(tanggal) as max_tanggal'))
                        ->whereIn('knmp_id', $knmpIds)
                        ->where('tanggal', '<=', $previousDate)
                        ->groupBy('knmp_id');
                }, 'max_dates', function ($join) {
                    $join->on('ph.knmp_id', '=', 'max_dates.knmp_id')
                         ->on('ph.tanggal', '=', 'max_dates.max_tanggal');
                })
                ->groupBy('ph.knmp_id', 'ph.tanggal')
                ->pluck('id');
            
            $previousProgresData = ProgresHarian::whereIn('id', $prevIds)
                ->pluck('progres', 'knmp_id')
                ->toArray();
        }

        foreach ($progresNasional as $item) {
            $prevProgres = $previousProgresData[$item->knmp_id] ?? $item->progres;
            $item->delta = $item->progres - $prevProgres;
        }
        // --- END DELTA CALCULATION ---

        $progresNasionalAvg = count($progresNasional) > 0 ? $progresNasional->avg('progres') : 0;

        // KPI Calculations
        $totalKnmp = count($desa_knmp);        // Hitung deviasi secara dinamis berdasarkan tanggal_mulai
        $deviasiData = [];
        if (!$progresNasional->isEmpty()) {
            // Ambil semua data konstruksi dan timeline
            $allKonstruksi = DB::table('konstruksi_knmp')
                ->whereIn('knmp_id', $knmpIds)
                ->get()
                ->keyBy('knmp_id');

            $allTimelines = DB::table('tahap_konstruksi')
                ->whereIn('knmp_konstruksi_id', $allKonstruksi->pluck('id'))
                ->orderBy('periode_mingguan')
                ->get()
                ->groupBy('knmp_konstruksi_id');

            $progresDateObj = $selectedProgresDate ? \Carbon\Carbon::parse($selectedProgresDate) : \Carbon\Carbon::now();

            foreach ($progresNasional as $item) {
                $kId = $item->knmp_id;
                $progresAktual = (float)$item->progres;
                
                $konstruksi = $allKonstruksi->get($kId);
                if (!$konstruksi) {
                    $deviasiData[$kId] = 0;
                    continue;
                }

                $timelines = $allTimelines->get($konstruksi->id) ?? collect();
                $startDate = $konstruksi->tanggal_mulai ? \Carbon\Carbon::parse($konstruksi->tanggal_mulai) : null;

                if (!$startDate || $timelines->isEmpty()) {
                    $rencanaRaw = 0;
                } else {
                    $diffDays = $startDate->diffInDays($progresDateObj, false);
                    $currentWeek = $diffDays < 0 ? 1 : (int) floor($diffDays / 7) + 1;
                    $tlRencana = $timelines->where('periode_mingguan', $currentWeek)->first();
                    if (!$tlRencana) {
                        $tlRencana = $timelines->sortByDesc('periode_mingguan')->first();
                    }
                    $rencanaRaw = $tlRencana ? $tlRencana->bobot_rencana_kumulatif : 0;
                }
                
                $item->rencana_kumulatif = $rencanaRaw;

                $maxPlan = $timelines->max('bobot_rencana_kumulatif') ?? 100;
                $scale = $maxPlan > 100 ? $maxPlan / 100 : 1;
                $rencanaPersen = (float)$rencanaRaw / $scale;
                
                $deviasiData[$kId] = round($progresAktual - $rencanaPersen, 2);
            }
        }

        foreach ($progresNasional as $item) {
            $item->deviasi = $deviasiData[$item->knmp_id] ?? 0;
        }

        // Available tahap values for filter
        $availableTahap = \App\Models\Batch::orderBy('id')->get();

        // Ketersediaan Infrastruktur
        $infraColumns = [
            'infra_jalan_akses', 'infra_listrik', 'infra_air_bersih', 'infra_internet',
            'infra_ipal', 'infra_dermaga_tambat', 'infra_tpi', 'infra_cold_storage',
            'infra_pabrik_es', 'infra_kantor_koperasi', 'infra_bengkel_nelayan', 'infra_waserda'
        ];
        $profiles = ProfileKnmp::select($infraColumns)->whereIn('knmp_id', $knmpIds)->get();
        $totalPercentage = 0;
        $countProfiles = $profiles->count();
        foreach ($profiles as $profile) {
            $filledCount = 0;
            foreach ($infraColumns as $col) {
                if ($profile->$col) $filledCount++;
            }
            $totalPercentage += ($filledCount / 12) * 100;
        }
        $ketersediaanInfrastruktur = $countProfiles > 0 ? round($totalPercentage / $countProfiles, 2) : 0;
 
        // Indeks Kesesuaian Kebutuhan
        $respondenIds = InformasiResponden::whereIn('knmp_id', $knmpIds)->pluck('id');
        $totalTanggapan = TanggapanMasyarakat::whereIn('responden_id', $respondenIds)->count();
        $sesuaiKebutuhan = TanggapanMasyarakat::whereIn('responden_id', $respondenIds)->where('kesesuaian_kebutuhan', 1)->count();
        $indeksKesesuaianKebutuhan = $totalTanggapan > 0 ? round(($sesuaiKebutuhan / $totalTanggapan) * 100, 2) : 0;
;

        // Pendapatan RT Nelayan
        $pendapatanRtNelayan = InformasiPendapatanRumahTangga::whereIn('responden_id', $respondenIds)->avg('pendapatan_total') ?? 0;

        // Indeks Kesejahteraan
        $indeksKesejahteraan = round($rataRataKebahagiaan, 2);

        // Tingkat Kelembagaan
        $totalSosial = SosialKelembagaan::whereIn('responden_id', $respondenIds)->count();
        $anggotaKelompokKoperasi = SosialKelembagaan::whereIn('responden_id', $respondenIds)->where(function ($q) {
            $q->where('anggota_kelompok', '>=', 3)->orWhere('anggota_koperasi', '>=', 3);
        })->count();
        $tingkatKelembagaan = $totalSosial > 0
            ? round(($anggotaKelompokKoperasi / $totalSosial) * 100, 2) : 0;

        // Total Tenaga Kerja
        $totalTenagaKerja = DB::table('progres_knmp')->whereIn('knmp_id', $knmpIds)->sum('tk_total') ?? 0;

        // Progres Nasional table data
        $progresNasionalData = $progresNasional->map(function ($item) {
            return [
                'id' => $item->id,
                'knmp_id' => $item->knmp_id,
                'nama' => $item->knmp_nama ?? 'KNMP #' . $item->knmp_id,
                'progres' => round($item->progres, 2),
                'nama_jasa_konstruksi' => $item->nama_jasa_konstruksi ?? '-',
                'delta' => $item->delta ?? 0,
                'keterangan' => $item->keterangan,
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

        $desa_knmp_query = Knmp::query();

        if ($tahap !== 'all') {
            $desa_knmp_query->where('batch_id', $tahap);
        }

        $knmpIds = $desa_knmp_query->pluck('id')->toArray();

        // Mendapatkan ID progres terbaru per KNMP
        if (!$selectedProgresDate) {
            $selectedProgresDate = ProgresHarian::whereIn('knmp_id', $knmpIds)
                ->whereNotNull('tanggal')->orderBy('tanggal', 'desc')->value('tanggal');
        }

        $latestIds = DB::table('progres_harian as ph')
            ->selectRaw('MAX(ph.id) as id')
            ->joinSub(function ($query) use ($knmpIds, $selectedProgresDate) {
                $query->from('progres_harian')
                    ->select('knmp_id', DB::raw('MAX(tanggal) as max_tanggal'))
                    ->whereIn('knmp_id', $knmpIds);
                if ($selectedProgresDate) {
                    $query->where('tanggal', '<=', $selectedProgresDate);
                }
                $query->groupBy('knmp_id');
            }, 'max_dates', function ($join) {
                $join->on('ph.knmp_id', '=', 'max_dates.knmp_id')
                     ->on('ph.tanggal', '=', 'max_dates.max_tanggal');
            })
            ->groupBy('ph.knmp_id', 'ph.tanggal')
            ->pluck('id');

        // Mengambil data utama menggunakan JOIN (5 Table: knmp, progres_harian, batch, tahap_konstruksi, penyedia_jasa_konstruksi)
        $desa_knmp_data = DB::table('progres_harian as ph')
            ->join('knmp as k', 'ph.knmp_id', '=', 'k.id')
            ->leftJoin('batch as b', 'k.batch_id', '=', 'b.id')
            ->leftJoin('konstruksi_knmp as kk', 'k.id', '=', 'kk.knmp_id')
            ->leftJoin('penyedia_jasa_konstruksi as pj', 'kk.jasa_konstruksi_id', '=', 'pj.id')
            ->whereIn('ph.id', $latestIds)
            ->select(
                'ph.*',
                'k.nama as knmp_nama',
                'k.kabupaten',
                'k.provinsi',
                'k.kecamatan',
                'k.tahap_saat_ini',
                'k.batch_id',
                'b.nama_tahap as batch_nama',
                'kk.tanggal_mulai',
                'pj.nama as nama_jasa_konstruksi'
            )
            ->get();

        $avgProgres = !$desa_knmp_data->isEmpty() ? round($desa_knmp_data->avg('progres'), 2) : 0;

        // Hitung deviasi secara dinamis berdasarkan tanggal_mulai
        $deviasiData = [];
        if (!$desa_knmp_data->isEmpty()) {
            // Ambil semua data konstruksi dan timeline
            $allKonstruksi = DB::table('konstruksi_knmp')
                ->whereIn('knmp_id', $knmpIds)
                ->get()
                ->keyBy('knmp_id');

            $allTimelines = DB::table('tahap_konstruksi')
                ->whereIn('knmp_konstruksi_id', $allKonstruksi->pluck('id'))
                ->orderBy('periode_mingguan')
                ->get()
                ->groupBy('knmp_konstruksi_id');

            // Tanggal acuan: gunakan tanggal saat ini untuk menentukan minggu keberapa
            $todayDate = $selectedProgresDate ? \Carbon\Carbon::parse($selectedProgresDate) : \Carbon\Carbon::now();

            foreach ($desa_knmp_data as $item) {
                $kId = $item->knmp_id;
                $progresAktual = (float)$item->progres;
                
                $konstruksi = $allKonstruksi->get($kId);
                if (!$konstruksi) {
                    $deviasiData[$kId] = 0;
                    continue;
                }

                $timelines = $allTimelines->get($konstruksi->id) ?? collect();
                $startDate = $konstruksi->tanggal_mulai ? \Carbon\Carbon::parse($konstruksi->tanggal_mulai) : null;

                if (!$startDate || $timelines->isEmpty()) {
                    $rencanaRaw = 0;
                } else {
                    // Hitung minggu saat ini: dari tanggal_mulai ke tanggal hari ini
                    $diffDays = $startDate->diffInDays($todayDate, false);
                    $currentWeek = max(1, (int) floor($diffDays / 7) + 1);

                    // Cari bobot rencana kumulatif untuk minggu tersebut
                    $tlRencana = $timelines->where('periode_mingguan', $currentWeek)->first();
                    if (!$tlRencana) {
                        $tlRencana = $timelines->sortByDesc('periode_mingguan')->first();
                    }
                    $rencanaRaw = $tlRencana ? $tlRencana->bobot_rencana_kumulatif : 0;
                }
                
                $item->rencana_kumulatif = $rencanaRaw;

                // Normalisasi jika data rencana menggunakan skala permil (max > 100)
                $maxPlan = $timelines->max('bobot_rencana_kumulatif') ?? 100;
                $scale = $maxPlan > 100 ? $maxPlan / 100 : 1;
                $rencanaPersen = round((float)$rencanaRaw / $scale, 2);
                
                // Deviasi = progres terbaru - rencana di minggu saat ini
                $deviasiData[$kId] = round($progresAktual - $rencanaPersen, 2);
            }
        }

        // Build table data
        $tableData = [];
        foreach ($desa_knmp_data as $knmp) {
            $progres = $knmp->progres;
            
            // Kolom lokasi baris 1 (nama knmp) dan baris 2 (Kec, Kab, Prov)
            $lokasi_baris_1 = $knmp->knmp_nama;
            
            // Format baris 2: Kecamatan, Kabupaten, Provinsi
            $lokasi_parts = [];
            if ($knmp->kecamatan) $lokasi_parts[] = 'Kec. ' . ucwords(strtolower($knmp->kecamatan));
            if ($knmp->kabupaten) $lokasi_parts[] = ucwords(strtolower($knmp->kabupaten));
            if ($knmp->provinsi) $lokasi_parts[] = ucwords(strtolower($knmp->provinsi));
            $lokasi_baris_2 = implode(', ', $lokasi_parts);
 
            $deviasi = $deviasiData[$knmp->knmp_id] ?? null;
 
            $status_text = 'On Progres';
            $status_color = '#64748b'; // Gray
            $deviasi_formatted = null;
            $deviasi_color = '#64748b';
 
            if ($progres >= 100) {
                $status_text = 'Selesai';
                $status_color = '#3b82f6'; // Blue
            } elseif ($deviasi !== null) {
                if ($deviasi >= 0) {
                    $status_text = 'On Track';
                    $status_color = '#10b981'; // Green
                } else {
                    $status_text = 'Underperform';
                    $status_color = '#ef4444'; // Red
                }
            }
 
            if ($deviasi !== null) {
                $deviasi_formatted = ($deviasi >= 0 ? '+' : '-') . number_format(abs($deviasi), 2, '.', ',') . '%';
                $deviasi_color = $deviasi >= 0 ? '#10b981' : '#ef4444';
            }
 
            $tableData[] = [
                'nama_knmp' => $knmp->knmp_nama,
                'lokasi_1' => $lokasi_baris_1,
                'lokasi_2' => $lokasi_baris_2,
                'nama_penyedia' => $knmp->nama_jasa_konstruksi ?? '-',
                'progres' => round($progres, 2),
                'status_text' => $status_text,
                'status_color' => $status_color,
                'deviasi_formatted' => $deviasi_formatted,
                'deviasi_color' => $deviasi_color,
                'tahap' => $knmp->tahap_saat_ini,
                'keterangan' => $knmp->keterangan ?: '-',
            ];
        }

        // Urutkan berdasarkan progres terbesar ke terkecil
        usort($tableData, function ($a, $b) {
            return $b['progres'] <=> $a['progres'];
        });

        // Group by tahap
        $tableDataByTahap = [];
        foreach ($tableData as $row) {
            $tahapKey = $row['tahap'] ?: 'Lainnya';
            if (!isset($tableDataByTahap[$tahapKey])) {
                $tableDataByTahap[$tahapKey] = [];
            }
            $tableDataByTahap[$tahapKey][] = $row;
        }
        ksort($tableDataByTahap);

        // Ambil data KNMP dengan relasi buktiUploads untuk pengelompokan foto
        $desa_knmp = \App\Models\Knmp::with(['buktiUploads'])->whereIn('id', $knmpIds)->get();

        // Group photos by tahap then province (1 location = 1 photo, condition "after")
        $photosByProvince = [];
        $photosByTahap = [];
        foreach ($desa_knmp as $knmp) {
            if ($knmp->buktiUploads->isEmpty()) {
                continue;
            }
            $photos = $knmp->buktiUploads->filter(function ($b) {
                return str_contains(strtolower($b->tipe_file ?? ''), 'image/')
                    && strtolower($b->kondisi ?? '') === 'after';
            })->take(1);
            if ($photos->isEmpty()) {
                continue;
            }

            $provinceName = ucwords(strtolower($knmp->provinsi ?? 'Lainnya'));
            $tahapKey = $knmp->tahap_saat_ini ?: 'Lainnya';

            $lokasi_parts = [];
            if ($knmp->kecamatan) {
                $lokasi_parts[] = 'Kec. ' . ucwords(strtolower($knmp->kecamatan));
            }
            if ($knmp->kabupaten) {
                $lokasi_parts[] = ucwords(strtolower($knmp->kabupaten));
            }
            $lokasi = implode(', ', $lokasi_parts);

            $photoItem = [
                'nama' => $knmp->nama,
                'lokasi' => $lokasi,
                'photos' => $photos,
            ];

            $photosByProvince[$provinceName][] = $photoItem;
            $photosByTahap[$tahapKey][$provinceName][] = $photoItem;
        }
        ksort($photosByProvince);
        ksort($photosByTahap);
        foreach ($photosByTahap as &$provinces) {
            ksort($provinces);
        }
        unset($provinces);

        if ($tahap !== 'all') {
            $tahapLabel = $tahap == 1 ? 'I' : ($tahap == 2 ? 'II' : ($tahap == 3 ? 'III' : $tahap));
        } else {
            $availableTahaps = \App\Models\Knmp::whereNotNull('tahap_saat_ini')->distinct()->orderBy('tahap_saat_ini')->pluck('tahap_saat_ini')->toArray();
            $romanTahaps = array_map(function($t) {
                return $t == 1 ? 'I' : ($t == 2 ? 'II' : ($t == 3 ? 'III' : $t));
            }, $availableTahaps);
            
            if (count($romanTahaps) == 0) {
                $tahapLabel = 'Semua';
            } elseif (count($romanTahaps) == 1) {
                $tahapLabel = $romanTahaps[0];
            } elseif (count($romanTahaps) == 2) {
                $tahapLabel = $romanTahaps[0] . ' dan ' . $romanTahaps[1];
            } else {
                $tahapLabel = implode(', ', $romanTahaps);
            }
        }

        $exportDate = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');
        $totalLokasi = count($desa_knmp);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf', compact(
            'tahap', 'tahapLabel', 'exportDate', 'totalLokasi', 'avgProgres',
            'tableData', 'tableDataByTahap', 'photosByProvince', 'photosByTahap', 'selectedProgresDate'
        ))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Progres_KNMP_Tahap_' . $tahapLabel . '_' . date('Y-m-d') . '.pdf';
        
        // Set cookie so the frontend can hide the loader
        return $pdf->stream($filename)->withCookie(cookie('fileDownload', 'true', 1, null, null, false, false));
    }

    /**
     * Update Keterangan for a ProgresHarian record
     */
    public function updateKeterangan(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'nullable|array',
        ]);

        $progres = ProgresHarian::findOrFail($id);

        // Join multiple choices with comma
        $keterangan = $request->keterangan ? implode(', ', $request->keterangan) : null;

        $progres->update([
            'keterangan' => $keterangan
        ]);

        return redirect()->back()->with('success', 'Keterangan berhasil diperbarui.');
    }
}
