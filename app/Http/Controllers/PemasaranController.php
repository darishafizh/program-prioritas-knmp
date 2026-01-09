<?php

namespace App\Http\Controllers;

use App\Models\DetailPemasaranIkan;
use App\Models\InformasiPemasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasaranController extends Controller
{
    /**
     * Store Informasi Pemasaran Perikanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
            'kendala_pemasaran' => 'required|string',
            'cara_penanganan_ikan' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $pemasaran = InformasiPemasaran::create([
                'knmp_id' => $request->knmp_id,
                'responden_id' => $request->responden_id,
                'kendala_pemasaran_text' => $request->kendala_pemasaran,
                'cara_penanganan_ikan' => $request->cara_penanganan_ikan,
            ]);

            DetailPemasaranIkan::create([
                'pemasaran_id' => $pemasaran->id,
                'responden_id' => $request->responden_id,
                'eceran_kg' => $request->pemasaran_eceran_kg ?? 0,
                'koperasi_kg' => $request->pemasaran_koperasi_kg ?? 0,
                'tengkulak_kg' => $request->pemasaran_tengkulak_kg ?? 0,
                'pengepul_kg' => $request->pemasaran_pengepul_kg ?? 0,
                'pedagang_besar_kg' => $request->pemasaran_pedagang_besar_kg ?? 0,
                'lainnya_kg' => $request->pemasaran_lainnya_kg ?? 0,
                'lainnya_keterangan' => $request->pemasaran_lainnya_ket,
            ]);

            DB::commit();
            return back()->with('success', 'Informasi Pemasaran berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
