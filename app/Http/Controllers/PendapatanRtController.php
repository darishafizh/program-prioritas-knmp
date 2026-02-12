<?php

namespace App\Http\Controllers;

use App\Models\InformasiPendapatanRumahTangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendapatanRtController extends Controller
{
    /**
     * Store Informasi Pendapatan Rumah Tangga
     */
    public function store(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
            'pendapatan_perikanan' => 'required|numeric|min:0',
            'pendapatan_non_perikanan' => 'nullable|numeric|min:0',
            'pendapatan_total' => 'required|numeric|min:0',
            'kontribusi_nelayan_persen' => 'required|string',
            'jumlah_sumber_penghasilan' => 'required|string',
            'ketergantungan_perikanan' => 'required|string',
            'stabilitas_pendapatan' => 'required|string',
            'keterlibatan_perempuan' => 'required|string',
            'kontribusi_perempuan_persen' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            InformasiPendapatanRumahTangga::updateOrCreate(
                [
                    'knmp_id' => $request->knmp_id,
                    'responden_id' => $request->responden_id,
                ],
                [
                    'pendapatan_perikanan' => $request->pendapatan_perikanan,
                    'pendapatan_non_perikanan' => $request->pendapatan_non_perikanan ?? 0,
                    'pendapatan_total' => $request->pendapatan_total,
                    'kontribusi_nelayan_persen' => $request->kontribusi_nelayan_persen,
                    'jumlah_sumber_penghasilan' => $request->jumlah_sumber_penghasilan,
                    'ketergantungan_perikanan' => $request->ketergantungan_perikanan,
                    'stabilitas_pendapatan' => $request->stabilitas_pendapatan,
                    'keterlibatan_perempuan' => $request->keterlibatan_perempuan,
                    'kontribusi_perempuan_persen' => $request->kontribusi_perempuan_persen,
                ]
            );

            DB::commit();
            return back()->with('success', 'Pendapatan Rumah Tangga berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
