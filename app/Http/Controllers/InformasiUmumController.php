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

            // Progres Nasional (Overall)
            $stats['progresNasional'] = \App\Models\ProgresKnmpNasional::where('knmp_id', $selectedKnmp->id)->value('progres') ?? 0;

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
