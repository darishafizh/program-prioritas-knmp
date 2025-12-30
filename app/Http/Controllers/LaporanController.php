<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\ProfileKnmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use App\Models\InformasiResponden;
use App\Models\BuktiUpload;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $knmpList = Knmp::with(['province', 'regency', 'district', 'village'])->orderBy('nama')->get();
        
        // Get selected KNMP (default to first if exists)
        $selectedKnmpId = $request->get('knmp_id', $knmpList->first()?->id);
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
            'komoditasUtama' => '-',
            'pendapatanPerTahun' => 0,
            'volumeProduksiPerTahun' => 0,
            'pendapatanNelayan' => 0,
            'koperasiDesaMerahPutih' => null,
            'latitude' => null,
            'longitude' => null,
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
                $stats['volumeProduksiPerTahun'] = $stats['profile']->volume_produksi_ton ?? 0;
                $stats['pendapatanPerTahun'] = $stats['profile']->nilai_produksi ?? 0;
                
                // Komoditas utama
                $komoditas = [];
                if ($stats['profile']->komoditas_utama_1) $komoditas[] = $stats['profile']->komoditas_utama_1;
                if ($stats['profile']->komoditas_utama_2) $komoditas[] = $stats['profile']->komoditas_utama_2;
                $stats['komoditasUtama'] = count($komoditas) > 0 ? implode(', ', $komoditas) : '-';
                
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
        }
        
        return view('laporan.index', compact('knmpList', 'selectedKnmp', 'selectedKnmpId', 'stats'));
    }
}
