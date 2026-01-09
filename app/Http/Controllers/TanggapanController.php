<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\TanggapanMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanggapanController extends Controller
{
    /**
     * Store Tanggapan Masyarakat
     */
    public function store(Request $request, Knmp $knmp)
    {
        $rules = [
            'responden_id' => 'required|exists:informasi_responden,id',
            'kesesuaian_kebutuhan' => 'required|boolean',
            'tingkat_kesenangan' => 'required|string',
            'harapan_masyarakat' => 'required|string',
            'masukan_saran_perbaikan' => 'required|string',
        ];

        if ($request->kesesuaian_kebutuhan == 0) {
            $rules['item_tidak_sesuai'] = 'required|string';
        }

        if ($request->tingkat_kesenangan === 'Tidak Senang') {
            $rules['alasan_tidak_senang'] = 'required|string';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $knmp) {
            TanggapanMasyarakat::create([
                'knmp_id' => $knmp->id,
                'responden_id' => $validated['responden_id'],
                'kesesuaian_kebutuhan' => (bool) $validated['kesesuaian_kebutuhan'],
                'item_tidak_sesuai' =>
                    $validated['kesesuaian_kebutuhan'] == 0
                    ? $validated['item_tidak_sesuai']
                    : null,
                'tingkat_kesenangan' => $validated['tingkat_kesenangan'],
                'alasan_tidak_senang' =>
                    $validated['tingkat_kesenangan'] === 'Tidak Senang'
                    ? $validated['alasan_tidak_senang']
                    : null,
                'harapan_masyarakat' => $validated['harapan_masyarakat'],
                'masukan_saran_perbaikan' => $validated['masukan_saran_perbaikan'],
            ]);
        });

        return back()->with('success', 'Tanggapan Masyarakat berhasil disimpan');
    }

    /**
     * Update Tanggapan Masyarakat
     */
    public function update(Request $request, Knmp $knmp)
    {
        $rules = [
            'responden_id' => 'required|exists:informasi_responden,id',
            'kesesuaian_kebutuhan' => 'required|boolean',
            'tingkat_kesenangan' => 'required|string',
            'harapan_masyarakat' => 'required|string',
            'masukan_saran_perbaikan' => 'required|string',
        ];

        if ($request->kesesuaian_kebutuhan == 0) {
            $rules['item_tidak_sesuai'] = 'required|string';
        }

        if ($request->tingkat_kesenangan === 'Tidak Senang') {
            $rules['alasan_tidak_senang'] = 'required|string';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $knmp, $request) {
            $tanggapan = TanggapanMasyarakat::where('knmp_id', $knmp->id)
                ->where('responden_id', $validated['responden_id'])
                ->first();

            if (!$tanggapan) {
                return back()->with('error', 'Data Tanggapan tidak ditemukan');
            }

            $tanggapan->update([
                'kesesuaian_kebutuhan' => (bool) $validated['kesesuaian_kebutuhan'],
                'item_tidak_sesuai' =>
                    $validated['kesesuaian_kebutuhan'] == 0
                    ? $validated['item_tidak_sesuai']
                    : null,
                'tingkat_kesenangan' => $validated['tingkat_kesenangan'],
                'alasan_tidak_senang' =>
                    $validated['tingkat_kesenangan'] === 'Tidak Senang'
                    ? $validated['alasan_tidak_senang']
                    : null,
                'harapan_masyarakat' => $validated['harapan_masyarakat'],
                'masukan_saran_perbaikan' => $validated['masukan_saran_perbaikan'],
            ]);
        });

        return back()->with('success', 'Tanggapan Masyarakat berhasil diperbarui');
    }
}
