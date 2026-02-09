<?php

namespace App\Http\Controllers;

use App\Models\InformasiUmum;
use App\Models\Knmp;
use App\Models\ProfileKnmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use App\Models\InformasiResponden;
use App\Models\BuktiUpload;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\InformasiUsaha;
use App\Models\InformasiPemasaran;
use App\Models\InformasiPendapatanRumahTangga;
use App\Models\SosialKelembagaan;
use Illuminate\Http\Request;

class InformasiUmumController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Filter KNMP list based on user access
        $knmpQuery = Knmp::with(['province', 'regency', 'district', 'village']);

        // If user is a village user (not admin), only show their assigned KNMP
        if ($user->isVillageUser() && !$user->isAdmin()) {
            $knmpQuery->where('id', $user->knmp_id);
        }

        $knmpList = $knmpQuery->orderBy('nama')->get();

        // Get selected KNMP (default to first if exists)
        $selectedKnmpId = $request->get('knmp_id', $knmpList->first()?->id);

        // Ensure user can only access their allowed KNMP
        if ($user->isVillageUser() && !$user->isAdmin()) {
            // Verify the selected KNMP belongs to this user
            if ($selectedKnmpId != $user->knmp_id) {
                $selectedKnmpId = $user->knmp_id;
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
            // C. Informasi Responden
            'responden' => [
                'total' => 0,
                'laki' => 0,
                'perempuan' => 0,
                'avgPengalaman' => 0,
                'pendidikan' => [],
            ],
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
            // F. Informasi Usaha
            'usaha' => [
                'total' => 0,
                'avgProduksiPerTrip' => 0,
                'avgBiayaOperasional' => 0,
                'avgPenjualanPerTrip' => 0,
            ],
            // G. Informasi Pemasaran
            'pemasaran' => [
                'total' => 0,
                'kendalaUtama' => [],
            ],
            // H. Pendapatan Rumah Tangga
            'pendapatanRt' => [
                'total' => 0,
                'avgPendapatanPerikanan' => 0,
                'avgPendapatanNonPerikanan' => 0,
                'avgPendapatanTotal' => 0,
                'avgKontribusiNelayan' => 0,
            ],
            // I. Sosial Kelembagaan
            'sosial' => [
                'total' => 0,
                'anggotaKelompok' => 0,
                'anggotaKoperasi' => 0,
                'tertarikKoperasi' => 0,
                'persenAnggotaKelompok' => 0,
                'persenAnggotaKoperasi' => 0,
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
            }

            // Jumlah Kapal - from InformasiResponden or estimate from nelayan
            $respondenCount = InformasiResponden::where('knmp_id', $selectedKnmp->id)->count();
            $stats['jumlahKapal'] = $respondenCount > 0 ? $respondenCount : round($stats['totalNelayan'] / 3);

            // ==========================================
            // MONITORING STATS SECTION C-J
            // ==========================================

            // Kondisi Demografi
            $responden = InformasiResponden::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['responden']['total'] = $responden->count();
            $monitoringStats['responden']['laki'] = $responden->where('jenis_kelamin', 'Laki-laki')->count();
            $monitoringStats['responden']['perempuan'] = $responden->where('jenis_kelamin', 'Perempuan')->count();
            $monitoringStats['responden']['avgPengalaman'] = $responden->count() > 0 
                ? round($responden->avg('pengalaman_usaha') ?? 0, 1) : 0;
            
            // Data demografi tambahan untuk storytelling
            $monitoringStats['responden']['avgUsia'] = $responden->count() > 0 
                ? round($responden->avg('umur') ?? 0) : 0;
            $monitoringStats['responden']['avgAnggotaKeluarga'] = $responden->count() > 0 
                ? round($responden->avg('jumlah_anggota_rumah') ?? 0, 1) : 0;
            $monitoringStats['responden']['avgABK'] = $responden->count() > 0 
                ? round($responden->avg('jumlah_abk') ?? 0, 1) : 0;
            
            // Pendidikan - ambil yang paling dominan
            $pendidikanGrouped = $responden->groupBy('pendidikan_terakhir')
                ->map(fn($group) => $group->count())
                ->sortDesc();
            $monitoringStats['responden']['pendidikan'] = $pendidikanGrouped->take(5)->toArray();
            $monitoringStats['responden']['pendidikanDominan'] = $pendidikanGrouped->keys()->first() ?? 'Tidak diketahui';
            $monitoringStats['responden']['persenPendidikanDominan'] = $responden->count() > 0 && $pendidikanGrouped->first()
                ? round(($pendidikanGrouped->first() / $responden->count()) * 100) : 0;

            // D. Tanggapan Masyarakat
            $tanggapan = TanggapanMasyarakat::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['tanggapan']['total'] = $tanggapan->count();
            
            // Count kesesuaian_kebutuhan properly (handle null, empty, 0, 1, '0', '1', true, false)
            $respondedCount = $tanggapan->filter(fn($t) => $t->kesesuaian_kebutuhan !== null && $t->kesesuaian_kebutuhan !== '')->count();
            $sesuaiCount = $tanggapan->filter(fn($t) => $t->kesesuaian_kebutuhan == 1 || $t->kesesuaian_kebutuhan === true || $t->kesesuaian_kebutuhan === '1')->count();
            $tidakSesuaiCount = $tanggapan->filter(fn($t) => $t->kesesuaian_kebutuhan === 0 || $t->kesesuaian_kebutuhan === false || $t->kesesuaian_kebutuhan === '0')->count();
            
            $monitoringStats['tanggapan']['sesuai'] = $sesuaiCount;
            $monitoringStats['tanggapan']['tidakSesuai'] = $tidakSesuaiCount;
            $monitoringStats['tanggapan']['responded'] = $respondedCount;
            $monitoringStats['tanggapan']['persenSesuai'] = $respondedCount > 0 
                ? round(($sesuaiCount / $respondedCount) * 100, 1) : 0;
            
            // Convert text tingkat_kesenangan to numeric score (scale 1-3)
            // Tidak Senang = 1, Biasa Saja = 2, Senang = 3
            $kesenanganTextToScore = [
                'senang' => 3,
                'biasa saja' => 2,
                'tidak senang' => 1,
            ];
            
            $scores = $tanggapan->map(function($item) use ($kesenanganTextToScore) {
                $value = strtolower(trim($item->tingkat_kesenangan ?? ''));
                return $kesenanganTextToScore[$value] ?? 0;
            })->filter(fn($score) => $score > 0);
            
            $monitoringStats['tanggapan']['avgKesenangan'] = $scores->count() > 0 
                ? round($scores->avg(), 1) : 0;
            $monitoringStats['tanggapan']['maxSkorKesenangan'] = 3; // Max score is 3
            
            // Distribusi tingkat kesenangan berdasarkan teks (case-insensitive)
            $monitoringStats['tanggapan']['distribusiKesenangan'] = [
                'Senang' => $tanggapan->filter(fn($t) => strtolower(trim($t->tingkat_kesenangan ?? '')) === 'senang')->count(),
                'Biasa Saja' => $tanggapan->filter(fn($t) => strtolower(trim($t->tingkat_kesenangan ?? '')) === 'biasa saja')->count(),
                'Tidak Senang' => $tanggapan->filter(fn($t) => strtolower(trim($t->tingkat_kesenangan ?? '')) === 'tidak senang')->count(),
            ];

            // E. Tingkat Kebahagiaan Nelayan
            $kebahagiaan = TingkatKebahagiaanNelayan::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['kebahagiaan']['totalResponden'] = $kebahagiaan->pluck('responden_id')->unique()->count();
            $monitoringStats['kebahagiaan']['avgSkor'] = $kebahagiaan->count() > 0 
                ? round($kebahagiaan->avg('skor_nilai') ?? 0, 1) : 0;
            $monitoringStats['kebahagiaan']['kategoriSkor'] = $kebahagiaan->groupBy('kategori')
                ->map(fn($group) => round($group->avg('skor_nilai') ?? 0, 1))
                ->toArray();

            // F. Informasi Usaha
            $usaha = InformasiUsaha::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['usaha']['total'] = $usaha->count();
            $monitoringStats['usaha']['avgProduksiPerTrip'] = $usaha->count() > 0 
                ? round($usaha->avg('produksi_kg_per_trip') ?? 0, 1) : 0;
            $monitoringStats['usaha']['avgBiayaOperasional'] = $usaha->count() > 0 
                ? round($usaha->avg('total_biaya_operasional') ?? 0) : 0;
            $monitoringStats['usaha']['avgPenjualanPerTrip'] = $usaha->count() > 0 
                ? round($usaha->avg('penjualan_rp_per_trip') ?? 0) : 0;

            // G. Informasi Pemasaran
            $pemasaran = InformasiPemasaran::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['pemasaran']['total'] = $pemasaran->count();
            // Collect kendala pemasaran
            $kendalaAll = $pemasaran->pluck('kendala_pemasaran_text')->filter()->values();
            $monitoringStats['pemasaran']['kendalaUtama'] = $kendalaAll->take(5)->toArray();

            // H. Pendapatan Rumah Tangga
            $pendapatanRt = InformasiPendapatanRumahTangga::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['pendapatanRt']['total'] = $pendapatanRt->count();
            $monitoringStats['pendapatanRt']['avgPendapatanPerikanan'] = $pendapatanRt->count() > 0 
                ? round($pendapatanRt->avg('pendapatan_perikanan') ?? 0) : 0;
            $monitoringStats['pendapatanRt']['avgPendapatanNonPerikanan'] = $pendapatanRt->count() > 0 
                ? round($pendapatanRt->avg('pendapatan_non_perikanan') ?? 0) : 0;
            $monitoringStats['pendapatanRt']['avgPendapatanTotal'] = $pendapatanRt->count() > 0 
                ? round($pendapatanRt->avg('pendapatan_total') ?? 0) : 0;
            $monitoringStats['pendapatanRt']['avgKontribusiNelayan'] = $pendapatanRt->count() > 0 
                ? round($pendapatanRt->avg('kontribusi_nelayan_persen') ?? 0, 1) : 0;

            // I. Sosial Kelembagaan
            $sosial = SosialKelembagaan::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['sosial']['total'] = $sosial->count();
            $monitoringStats['sosial']['anggotaKelompok'] = $sosial->where('anggota_kelompok', 'Ya')->count();
            $monitoringStats['sosial']['anggotaKoperasi'] = $sosial->where('anggota_koperasi', 'Ya')->count();
            $monitoringStats['sosial']['tertarikKoperasi'] = $sosial->where('tertarik_koperasi', 'Ya')->count();
            $monitoringStats['sosial']['persenAnggotaKelompok'] = $sosial->count() > 0 
                ? round(($monitoringStats['sosial']['anggotaKelompok'] / $sosial->count()) * 100, 1) : 0;
            $monitoringStats['sosial']['persenAnggotaKoperasi'] = $sosial->count() > 0 
                ? round(($monitoringStats['sosial']['anggotaKoperasi'] / $sosial->count()) * 100, 1) : 0;

            // J. Bukti Pendukung
            $bukti = BuktiUpload::where('knmp_id', $selectedKnmp->id)->get();
            $monitoringStats['bukti']['totalFiles'] = $bukti->count();
            $monitoringStats['bukti']['totalSize'] = $bukti->sum('ukuran_file');
            $monitoringStats['bukti']['files'] = $bukti->take(6); // Latest 6 files for preview
        }

        return view('informasi_umum.index', compact('knmpList', 'selectedKnmp', 'selectedKnmpId', 'stats', 'monitoringStats'));
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
