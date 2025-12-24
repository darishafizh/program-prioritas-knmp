<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\InformasiResponden;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\TargetRealisasi;

class DashboardController extends Controller
{
    public function index()
    {
        $desa_knmp = DB::table('knmp')
            ->select('id', 'nama', 'latitude', 'longitude')
            ->get();

        // 1. Hitung responden yang telah mengisi survey
        $totalSurveyTerisi = InformasiResponden::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tingkat_kebahagiaan_nelayan')
                    ->whereColumn('tingkat_kebahagiaan_nelayan.responden_id', 'informasi_responden.id');
            })
            ->distinct('id')
            ->count();

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

        return view('dashboard.index', compact(
            'desa_knmp',
            'totalSurveyTerisi',
            'tingkatKelengkapanData',
            'capaianIndikator',
            'rataRataKebahagiaan',
            'desaAsetBertambah'
        ));
    }
}
