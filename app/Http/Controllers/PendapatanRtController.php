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
            // Allow string or int
            'kontribusi_nelayan_persen' => 'nullable',
            'jumlah_sumber_penghasilan' => 'nullable',
            'ketergantungan_perikanan' => 'nullable',
            'stabilitas_pendapatan' => 'nullable',
            'keterlibatan_perempuan' => 'nullable',
            'kontribusi_perempuan_persen' => 'nullable',
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
                    
                    'kontribusi_nelayan_persen' => $this->getScore('kontribusi_nelayan', $request->kontribusi_nelayan_persen),
                    'jumlah_sumber_penghasilan' => $this->getScore('jumlah_sumber', $request->jumlah_sumber_penghasilan),
                    'ketergantungan_perikanan' => $this->getScore('ketergantungan', $request->ketergantungan_perikanan),
                    'stabilitas_pendapatan' => $this->getScore('stabilitas', $request->stabilitas_pendapatan),
                    'keterlibatan_perempuan' => $this->getScore('keterlibatan_perempuan', $request->keterlibatan_perempuan),
                    'kontribusi_perempuan_persen' => $this->getScore('kontribusi_perempuan', $request->kontribusi_perempuan_persen),
                ]
            );

            DB::commit();
            return back()->with('success', 'Pendapatan Rumah Tangga berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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

        if ($type === 'kontribusi_nelayan') {
            if (str_contains($val, '100%')) return 4;
            if (str_contains($val, 'lebih dari 80')) return 3;
            if (str_contains($val, '50-80')) return 2;
            if (str_contains($val, '50–80')) return 2; // Handle en-dash
            if (str_contains($val, 'kurang dari 50')) return 1;
        }

        if ($type === 'jumlah_sumber') {
            if (str_contains($val, 'lebih dari 3')) return 4;
            if (str_contains($val, '3 sumber')) return 3;
            if (str_contains($val, '2 sumber')) return 2;
            if (str_contains($val, '1 (hanya')) return 1;
        }

        if ($type === 'ketergantungan') {
            if (str_contains($val, 'sangat bergantung')) return 4;
            if (str_contains($val, 'cukup bergantung')) return 3;
            if (str_contains($val, 'sedikit bergantung')) return 2;
            if (str_contains($val, 'tidak bergantung')) return 1;
        }

        if ($type === 'stabilitas') {
            if (str_contains($val, 'stabil sepanjang')) return 4;
            if (str_contains($val, 'cenderung stabil')) return 3;
            if (str_contains($val, 'sangat tidak stabil')) return 1; // Order matters: check "sangat tidak" before "tidak"
            if (str_contains($val, 'tidak stabil')) return 2;
        }

        if ($type === 'keterlibatan_perempuan') {
            if ($val === 'selalu') return 4;
            if ($val === 'sering') return 3;
            if ($val === 'jarang') return 2;
            if (str_contains($val, 'tidak pernah')) return 1;
        }

        if ($type === 'kontribusi_perempuan') {
            if (str_contains($val, 'lebih dari 75')) return 5;
            if (str_contains($val, '51%–75') || str_contains($val, '51%-75')) return 4;
            if (str_contains($val, '25%–50') || str_contains($val, '25%-50')) return 3;
            if (str_contains($val, 'kurang dari 25')) return 2;
            if (str_contains($val, 'tidak dilibatkan')) return 1;
        }

        return 0; // Default
    }
}
