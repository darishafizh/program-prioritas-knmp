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
            'province',
            'regency',
            'district',
            'village',
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
        // Get available dates for filter dropdown
        $availableProgressDates = ProgresKnmpNasional::selectRaw('DISTINCT tanggal')
            ->whereNotNull('tanggal')
            ->orderBy('tanggal', 'desc')
            ->pluck('tanggal')
            ->toArray();

        // Get selected date from request or use latest available
        $selectedProgresDate = $request->get('progres_date');
        if (!$selectedProgresDate && count($availableProgressDates) > 0) {
            $selectedProgresDate = $availableProgressDates[0]; // Latest date
        }

        // Query progres data by selected date
        $progresNasionalQuery = ProgresKnmpNasional::with('knmp')
            ->whereIn('knmp_id', $knmpIds)
            ->orderBy('progres', 'desc');
        if ($selectedProgresDate) {
            $progresNasionalQuery->where('tanggal', $selectedProgresDate);
        }
        $progresNasional = $progresNasionalQuery->get()->unique('knmp_id')->values();
        $progresNasionalAvg = $progresNasional->avg('progres') ?? 0;

        // ===================================
        // NEW KPI CALCULATIONS
        // ===================================

        // 1. Total KNMP (sudah ada: count($desa_knmp))
        $totalKnmp = count($desa_knmp);

        // 2. Ketersediaan Infrastruktur (%) - berdasarkan 12 item infrastruktur di profile_knmp
        // Hitung rata-rata ketersediaan dari 12 item (infra_jalan_akses, infra_listrik, dll)
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

        $profiles = ProfileKnmp::whereIn('knmp_id', $knmpIds)->select($infraColumns)->get();
        $totalPercentage = 0;
        $countProfiles = $profiles->count();

        foreach ($profiles as $profile) {
            $filledCount = 0;
            foreach ($infraColumns as $col) {
                if ($profile->$col) {
                    $filledCount++;
                }
            }
            // Persentase ketersediaan per KNMP (dari 12 item)
            $totalPercentage += ($filledCount / 12) * 100;
        }

        $ketersediaanInfrastruktur = $countProfiles > 0
            ? round($totalPercentage / $countProfiles, 2)
            : 0;

        // 3. Indeks Kesesuaian Kebutuhan (%) - persentase responden yang menyatakan sesuai kebutuhan
        $totalTanggapan = TanggapanMasyarakat::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $sesuaiKebutuhan = TanggapanMasyarakat::where('kesesuaian_kebutuhan', 1)->whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $indeksKesesuaianKebutuhan = $totalTanggapan > 0
            ? round(($sesuaiKebutuhan / $totalTanggapan) * 100, 2)
            : 0;

        // 4. Pendapatan RT Nelayan - rata-rata pendapatan total dari informasi_pendapatan_rumah_tangga
        $pendapatanRtNelayan = InformasiPendapatanRumahTangga::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->avg('pendapatan_total') ?? 0;

        // 5. Indeks Kesejahteraan Nelayan - berdasarkan rata-rata skor kebahagiaan (skala 1-10)
        $indeksKesejahteraan = round($rataRataKebahagiaan, 2);

        // 6. Tingkat Kelembagaan Nelayan (%) - persentase nelayan yang tergabung dalam kelompok/koperasi
        // Score: 4=Sangat Aktif, 3=Tidak Aktif, 2=Tidak Pernah, 1=Tidak Ada
        $totalSosial = SosialKelembagaan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $anggotaKelompokKoperasi = SosialKelembagaan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->where(function ($q) {
            $q->where('anggota_kelompok', '>=', 3)
                ->orWhere('anggota_koperasi', '>=', 3);
        })->count();
        $tingkatKelembagaan = $totalSosial > 0
            ? round(($anggotaKelompokKoperasi / $totalSosial) * 100, 2)
            : 0;

        // Rata-rata Anggota Kopdeskel
        $rataRataAnggotaKopdeskel = DB::table('profile_knmp')
            ->whereIn('knmp_id', $knmpIds)
            ->selectRaw('AVG(COALESCE(jumlah_anggota_laki, 0) + COALESCE(jumlah_anggota_perempuan, 0)) as avg_anggota')
            ->value('avg_anggota') ?? 0;

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
            'rataRataAnggotaKopdeskel',
            // New KPI data
            'totalKnmp',
            'ketersediaanInfrastruktur',
            'indeksKesesuaianKebutuhan',
            'pendapatanRtNelayan',
            'indeksKesejahteraan',
            'tingkatKelembagaan'
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

        $desa_knmp = Knmp::with([
            'province',
            'regency',
            'district',
            'village',
            'profileKnmp',
            'progresKnmp',
            'latestProgresNasional',
        ])->withCount('informasiResponden')->get();

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
