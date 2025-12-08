<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanggapanMasyarakat;
use Illuminate\Support\Facades\DB;

class TanggapanMasyarakatController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'knmp_id'              => 'required|integer|exists:knmp,id',
            'sesuai_kebutuhan'     => 'required|string|in:Ya, sesuai,Tidak sesuai',
            'tidak_sesuai_item'    => 'nullable|string',
            'senang'               => 'required|string|in:Senang,Biasa saja,Tidak Senang',
            'alasan_tidak_senang'  => 'nullable|string',
            'harapan_masyarakat'   => 'nullable|string',
            'masukan_saran'        => 'nullable|string',
        ]);

        // 🔍 Jika pilih "Ya, sesuai" → pertanyaan no.2 harus NULL
        if ($validatedData['sesuai_kebutuhan'] === 'Ya, sesuai') {
            $validatedData['tidak_sesuai_item'] = null;
        }

        // 🔍 Jika pilih "Senang" atau "Biasa saja" → pertanyaan no.4 harus NULL
        if ($validatedData['senang'] === 'Senang' || $validatedData['senang'] === 'Biasa saja') {
            $validatedData['alasan_tidak_senang'] = null;
        }

        $kesesuaianBoolean = ($validatedData['sesuai_kebutuhan'] === 'Ya, sesuai');

        $dataToStore = [
            'kesesuaian_kebutuhan'    => $kesesuaianBoolean,
            'item_tidak_sesuai'       => $validatedData['tidak_sesuai_item'],
            'tingkat_kesenangan'      => $validatedData['senang'],
            'alasan_tidak_senang'     => $validatedData['alasan_tidak_senang'],
            'harapan_masyarakat'      => $validatedData['harapan_masyarakat'],
            'masukan_saran_perbaikan' => $validatedData['masukan_saran'],
        ];

        try {
            DB::beginTransaction();

            TanggapanMasyarakat::updateOrCreate(
                ['knmp_id' => $validatedData['knmp_id']],
                $dataToStore
            );

            DB::commit();

            return redirect()->back()->with('success', 'Tanggapan masyarakat berhasil disimpan/diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
