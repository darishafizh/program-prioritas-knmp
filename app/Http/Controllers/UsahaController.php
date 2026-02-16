<?php

namespace App\Http\Controllers;

use App\Models\InformasiUsaha;
use App\Models\InformasiUsahaIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsahaController extends Controller
{
    /**
     * Store Informasi Usaha & Ikan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
            'nama_kapal' => 'required|string',
            'tahun_pembuatan' => 'required|numeric',
            'jenis_alat_tangkap' => 'required|string',
            'ikan_utama' => 'required|array|min:1',
            'ikan_utama.*.jenis' => 'required|string',
            'ikan_utama.*.kg_trip' => 'required|numeric',
            'ikan_utama.*.persen' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $usaha = InformasiUsaha::updateOrCreate(
                [
                    'knmp_id' => $request->knmp_id,
                    'responden_id' => $request->responden_id,
                ],
                [
                    'nama_kapal' => $request->nama_kapal,
                    'tahun_pembuatan' => $request->tahun_pembuatan,
                    'ukuran_gt' => $request->ukuran_gt,
                    'dimensi_perahu' => $request->dimensi_perahu,
                    'jenis_bahan_baku' => $this->getScore('jenis_bahan_baku', $request->jenis_bahan_baku),
                    'jenis_mesin' => $this->getScore('jenis_mesin', $request->jenis_mesin),
                    'alat_penyimpanan' => $this->getScore('alat_penyimpanan', $request->alat_penyimpanan),
                    'jenis_alat_tangkap' => $request->jenis_alat_tangkap,
                    'hari_per_trip' => $request->hari_per_trip,
                    'waktu_melaut_jam' => $request->waktu_melaut_jam,
                    'jarak_penangkapan_mil' => $request->jarak_penangkapan_mil,
                    'waktu_tempuh_jam' => $request->waktu_tempuh_jam,
                    'jml_trip_per_bulan' => $request->jml_trip_per_bulan,
                    'jml_bulan_melaut' => $request->jml_bulan_melaut,
                    'produksi_kg_per_trip' => $request->produksi_kg_per_trip,
                    'penjualan_rp_per_trip' => $request->penjualan_rp_per_trip,
                    'biaya_solar_rp' => $request->biaya_solar_rp,
                    'volume_solar_liter' => $request->volume_solar_liter,
                    'biaya_bensin_rp' => $request->biaya_bensin_rp,
                    'volume_bensin_liter' => $request->volume_bensin_liter,
                    'biaya_es_balok_rp' => $request->biaya_es_balok_rp,
                    'volume_es_balok' => $request->volume_es_balok,
                    'biaya_es_kantong_rp' => $request->biaya_es_kantong_rp,
                    'volume_es_kantong' => $request->volume_es_kantong,
                    'total_biaya_operasional' => $request->total_biaya_operasional,
                ]
            );

            // Hapus ikan lama lalu insert ulang (jumlah ikan bisa berubah)
            InformasiUsahaIkan::where('informasi_usaha_id', $usaha->id)->delete();

            foreach ($request->ikan_utama as $row) {
                InformasiUsahaIkan::create([
                    'informasi_usaha_id' => $usaha->id,
                    'responden_id' => $request->responden_id,
                    'jenis' => $row['jenis'],
                    'kg_trip' => $row['kg_trip'],
                    'persen' => $row['persen'],
                ]);
            }

            DB::commit();

            return back()->with('success', 'Informasi Usaha berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Helper to map text answers to scores
     */
    private function getScore($type, $value)
    {
        if (is_null($value)) return null;
        if (is_numeric($value)) return (int) $value;

        $val = strtolower(trim($value));

        if ($type === 'jenis_bahan_baku') {
            // Fiber (4), Kayu Laminasi (3), Kayu (2), Besi (1), Lainnya (1)
            if ($val === 'fiber') return 4;
            if ($val === 'kayu laminasi') return 3;
            if ($val === 'kayu') return 2;
            if ($val === 'besi') return 1;
            if ($val === 'lainnya') return 1;
        }

        if ($type === 'jenis_mesin') {
            // Motor Tempel Pribadi (4), Motor Tempel Bantuan (3), Sampan (1)
            if ($val === 'motor tempel pribadi') return 4;
            if ($val === 'motor tempel bantuan') return 3;
            if (str_contains($val, 'sampan')) return 1;
        }

        if ($type === 'alat_penyimpanan') {
            // Coolbox (4), Palka (3), Stereofoam Box (2), Tong plastik (1), Lainnya (1)
            if ($val === 'coolbox') return 4;
            if ($val === 'palka') return 3;
            if (str_contains($val, 'stereofoam')) return 2;
            if (str_contains($val, 'tong')) return 1;
            if ($val === 'lainnya') return 1;
        }

        return 0; // Default
    }

}
