<?php

namespace App\Http\Controllers;

use App\Models\InformasiUmum;
use App\Models\Knmp;
use App\Models\ProfileKnmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use App\Models\BuktiUpload;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\TimelinePengerjaan;
use Illuminate\Http\Request;

class InformasiUmumController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Filter KNMP list based on user access, only select needed columns and relationships for dropdown
        $knmpQuery = Knmp::with(['province:id,name', 'regency:id,name'])->select('id', 'nama', 'province_id', 'regency_id');

        // If user is a village user (not admin/super_admin), only show their assigned KNMP
        if ($user->isVillageUser() && !$user->isAdmin() && !$user->isSuperAdmin()) {
            $knmpQuery->where('id', $user->knmp_id);
        }

        $knmpList = $knmpQuery->orderBy('nama')->get();

        // Determine default KNMP ID
        if ($user->isVillageUser() && !$user->isAdmin() && !$user->isSuperAdmin()) {
             // Village user is locked to their KNMP
            $selectedKnmpId = $request->get('knmp_id', $user->knmp_id);
            if ($selectedKnmpId != $user->knmp_id) {
                $selectedKnmpId = $user->knmp_id;
            }
        } else {
            // Admin: Check if there is a 'last_active_knmp' or simply pick one with recent uploads if no specific ID requested
            if (!$request->has('knmp_id')) {
                // Try to find KNMP with most recent upload or update
                $latestUpload = BuktiUpload::latest()->first();
                $defaultId = $latestUpload ? $latestUpload->knmp_id : $knmpList->first()?->id;
                $selectedKnmpId = $defaultId;
            } else {
                $selectedKnmpId = $request->get('knmp_id');
            }
        }

        $selectedKnmp = Knmp::with(['province', 'regency', 'district', 'village'])->find($selectedKnmpId);

        // Initialize statistics
        $stats = [
            'profile' => null,
            'progres' => null,
            'progresDetails' => collect(),
            'jmlKepalaKeluarga' => 0,
            'totalNelayan' => 0,
            'jumlahKapal' => 0,
            'serapanTenagaKerja' => 0,
            // Komoditas 1
            'komoditas1' => '-',
            'volumeKomoditas1' => 0,
            'nilaiKomoditas1' => 0,
            'hargaKomoditas1' => 0,
            // Komoditas 2
            'komoditas2' => '-',
            'volumeKomoditas2' => 0,
            'nilaiKomoditas2' => 0,
            'hargaKomoditas2' => 0,
            // Other stats
            'pendapatanNelayan' => 0,
            'koperasiDesaMerahPutih' => null,
            'latitude' => null,
            'longitude' => null,
        ];

        // Initialize monitoring stats for Section C-J
        $monitoringStats = [
            // D. Tanggapan Masyarakat
            'tanggapan' => [
                'total' => 0,
                'sesuai' => 0,
                'tidakSesuai' => 0,
                'persenSesuai' => 0,
                'avgKesenangan' => 0,
                'distribusiKesenangan' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
            ],
            // E. Tingkat Kebahagiaan
            'kebahagiaan' => [
                'avgSkor' => 0,
                'totalResponden' => 0,
                'kategoriSkor' => [],
            ],
            // J. Bukti Pendukung
            'bukti' => [
                'totalFiles' => 0,
                'totalSize' => 0,
                'files' => collect(),
            ],
        ];

        if ($selectedKnmp) {
            // Get coordinates from KNMP
            $stats['latitude'] = $selectedKnmp->latitude;
            $stats['longitude'] = $selectedKnmp->longitude;

            // Profile KNMP
            $stats['profile'] = ProfileKnmp::where('knmp_id', $selectedKnmp->id)->first();

            if ($stats['profile']) {
                $stats['jmlKepalaKeluarga'] = $stats['profile']->jml_penduduk_des ?? 0;
                $stats['totalNelayan'] = $stats['profile']->jml_nelayan ?? 0;
                $stats['jumlahKapal'] = $stats['profile']->jumlah_kapal ?? 0;
                $stats['pendapatanNelayan'] = $stats['profile']->pendapatan_rata_rata_nelayan ?? 0;

                // Komoditas Utama 1
                $stats['komoditas1'] = $stats['profile']->komoditas_utama_1 ?? '-';
                $stats['hargaKomoditas1'] = $stats['profile']->harga_rata_komoditas_1 ?? 0;
                // Calculate volume and value for komoditas 1
                $stats['volumeKomoditas1'] = $stats['profile']->volume_produksi_ton ?? 0;
                $stats['nilaiKomoditas1'] = $stats['profile']->nilai_produksi ?? 0;

                // Komoditas Utama 2
                $stats['komoditas2'] = $stats['profile']->komoditas_utama_2 ?? '-';
                $stats['hargaKomoditas2'] = $stats['profile']->harga_rata_komoditas_2 ?? 0;

                // Koperasi info
                $stats['koperasiDesaMerahPutih'] = [
                    'nama' => $stats['profile']->calon_koperasi ?? 'Belum Ada',
                    'ketua' => $stats['profile']->nama_ketua ?? '-',
                    'sk' => $stats['profile']->sk_kopdeskel ?? '-',
                    'nomorInduk' => $stats['profile']->nomor_induk_kopdeskel ?? '-',
                    'anggotaLaki' => $stats['profile']->jumlah_anggota_laki ?? 0,
                    'anggotaPerempuan' => $stats['profile']->jumlah_anggota_perempuan ?? 0,
                ];
            }

            // Progres KNMP
            $stats['progres'] = ProgresKnmp::where('knmp_id', $selectedKnmp->id)->first();

            if ($stats['progres']) {
                // Serapan Tenaga Kerja
                $stats['serapanTenagaKerja'] = $stats['progres']->tk_total ?? 0;

                // Get progres details for each component
                $stats['progresDetails'] = ProgresKnmpDetail::where('progres_id', $stats['progres']->id)
                    ->orderBy('kode')
                    ->get();
                // Calculate Overall Progress (Average of 4 Components: A, B, C, D)
                $components = ['A', 'B', 'C', 'D'];
                $componentAverages = [];

                foreach ($components as $code) {
                    $details = $stats['progresDetails']->filter(function ($item) use ($code) {
                        return str_starts_with($item->kode, $code);
                    });

                    if ($details->count() > 0) {
                        $componentAverages[] = $details->avg('persen');
                    } else {
                        $componentAverages[] = 0;
                    }
                }

                $stats['progresNasional'] = count($componentAverages) > 0 ? array_sum($componentAverages) / count($componentAverages) : 0;
            } else {
                $stats['progresNasional'] = 0;
            }

            // --- KPI Calculations (Filtered by KNMP) ---

            // 1. Indeks Kesesuaian Kebutuhan
            // Formula: (Count(kesesuaian_kebutuhan=1) / Total) * 100
            // Filter by KNMP via Responden -> InformasiResponden -> knmp_id (Need to check relationships)
            // Assuming TanggapanMasyarakat belongs to Responden, and Responden belongs to KNMP
            // OR checks if TanggapanMasyarakat has direct knmp_id or via responden.
            // Let's check models first. 
            // For now, I will assume we need to join with responden table which has knmp_id.
            
            // Checking TanggapanMasyarakat model...
            // It usually has responden_id. InformasiResponden has knmp_id.
            
            $totalTanggapan = \App\Models\TanggapanMasyarakat::whereHas('responden', function($q) use ($selectedKnmp) {
                $q->where('knmp_id', $selectedKnmp->id);
            })->count();

            $sesuaiKebutuhan = \App\Models\TanggapanMasyarakat::whereHas('responden', function($q) use ($selectedKnmp) {
                $q->where('knmp_id', $selectedKnmp->id);
            })->where('kesesuaian_kebutuhan', 1)->count();
            
            $stats['indeksKesesuaianKebutuhan'] = $totalTanggapan > 0 ? round(($sesuaiKebutuhan / $totalTanggapan) * 100, 2) : 0;

            // 2. Indeks Kesejahteraan Nelayan (Rata-rata Skor Kebahagiaan)
             $stats['indeksKesejahteraan'] = \App\Models\TingkatKebahagiaanNelayan::whereHas('responden', function($q) use ($selectedKnmp) {
                $q->where('knmp_id', $selectedKnmp->id);
            })->avg('skor_nilai') ?? 0;
            $stats['indeksKesejahteraan'] = round($stats['indeksKesejahteraan'], 2);

            // 3. Tingkat Kelembagaan Nelayan
            // Formula: % Anggota Kelompok/Koperasi >= 3 (Aktif)
            $totalSosial = \App\Models\SosialKelembagaan::whereHas('responden', function($q) use ($selectedKnmp) {
                $q->where('knmp_id', $selectedKnmp->id);
            })->count();

            $anggotaAktif = \App\Models\SosialKelembagaan::whereHas('responden', function($q) use ($selectedKnmp) {
                $q->where('knmp_id', $selectedKnmp->id);
            })->where(function ($q) {
                $q->where('anggota_kelompok', '>=', 3)
                  ->orWhere('anggota_koperasi', '>=', 3);
            })->count();

            $stats['tingkatKelembagaan'] = $totalSosial > 0 ? round(($anggotaAktif / $totalSosial) * 100, 2) : 0;


            // J. Bukti Pendukung
            // Use DB aggregates instead of loading all models into memory
            $monitoringStats['bukti']['totalFiles'] = BuktiUpload::where('knmp_id', $selectedKnmp->id)->count();
            $monitoringStats['bukti']['totalSize'] = BuktiUpload::where('knmp_id', $selectedKnmp->id)->sum('ukuran_file');
            $monitoringStats['bukti']['files'] = BuktiUpload::where('knmp_id', $selectedKnmp->id)->latest()->take(6)->get();
        }

        // Fetch timeline data for S-Curve chart
        $timelineData = collect();
        if ($selectedKnmp) {
            $timelineData = TimelinePengerjaan::where('knmp_id', $selectedKnmp->id)
                ->orderBy('periode_mingguan', 'asc')
                ->get();
        }

        return view('informasi_umum.index', compact('knmpList', 'selectedKnmp', 'selectedKnmpId', 'stats', 'monitoringStats', 'timelineData'));
    }

    public function create()
    {
        return view('dashboard.informasi_umum');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_responden' => 'required|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'status_responden' => 'nullable|string|max:255',
            'jenis_program' => 'nullable|string|max:255',
        ]);

        InformasiUmum::create($validated);

        return redirect()->route('informasi_umum.create')->with('success', 'Data Informasi Umum berhasil disimpan.');
    }
}
