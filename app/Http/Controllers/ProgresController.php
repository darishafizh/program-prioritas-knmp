<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresController extends Controller
{
    /**
     * Store Progres KNMP
     */
    public function store(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'anggaran_total' => 'required|numeric|min:0',
            'anggaran_konstruksi' => 'required|numeric|min:0',
            'anggaran_sarpras' => 'required|numeric|min:0',

            'tk_laki' => 'required|integer|min:0',
            'tk_perempuan' => 'required|integer|min:0',
            'tk_upah' => 'required|numeric|min:0',
            'tk_durasi' => 'required|numeric|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|numeric|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',
        ], [], [], 'progresKnmp');

        DB::beginTransaction();

        try {
            $tkTotal = $validated['tk_laki'] + $validated['tk_perempuan'];

            $progres = ProgresKnmp::create([
                'knmp_id' => $knmp->id,
                'anggaran_total' => $validated['anggaran_total'],
                'anggaran_konstruksi' => $validated['anggaran_konstruksi'],
                'anggaran_sarpras' => $validated['anggaran_sarpras'],
                'tk_total' => $tkTotal,
                'tk_laki' => $validated['tk_laki'],
                'tk_perempuan' => $validated['tk_perempuan'],
                'tk_upah' => $validated['tk_upah'],
                'tk_durasi' => $validated['tk_durasi'],
                'tk_lokal' => $validated['tk_lokal'],
                'tk_luar' => $validated['tk_luar'],
                'tk_non_konstruksi_jumlah' => $validated['tk_non_konstruksi_jumlah'] ?? null,
                'tk_non_konstruksi_ket' => $validated['tk_non_konstruksi_ket'] ?? null,
                'kendala' => $request->kendala ?? null,
                'cctv' => $request->cctv ?? null,
            ]);

            foreach ($validated['progress'] as $kode => $items) {
                foreach ($items as $row) {
                    if (
                        empty($row['target']) &&
                        empty($row['persen']) &&
                        empty($row['keterangan'])
                    ) {
                        continue;
                    }

                    ProgresKnmpDetail::create([
                        'progres_id' => $progres->id,
                        'kode' => $kode,
                        'komponen' => $row['komponen'],
                        'target' => $row['target'],
                        'persen' => $row['persen'],
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres Pembangunan KNMP berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update Progres KNMP
     */
    public function update(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'anggaran_total' => 'required|numeric|min:0',
            'anggaran_konstruksi' => 'required|numeric|min:0',
            'anggaran_sarpras' => 'required|numeric|min:0',

            'tk_laki' => 'required|integer|min:0',
            'tk_perempuan' => 'required|integer|min:0',
            'tk_upah' => 'required|numeric|min:0',
            'tk_durasi' => 'required|numeric|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|numeric|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $progres = ProgresKnmp::where('knmp_id', $knmp->id)->first();

            if (!$progres) {
                return back()->with('error', 'Data Progres KNMP tidak ditemukan');
            }

            $tkTotal = $validated['tk_laki'] + $validated['tk_perempuan'];

            $progres->update([
                'anggaran_total' => $validated['anggaran_total'],
                'anggaran_konstruksi' => $validated['anggaran_konstruksi'],
                'anggaran_sarpras' => $validated['anggaran_sarpras'],
                'tk_total' => $tkTotal,
                'tk_laki' => $validated['tk_laki'],
                'tk_perempuan' => $validated['tk_perempuan'],
                'tk_upah' => $validated['tk_upah'],
                'tk_durasi' => $validated['tk_durasi'],
                'tk_lokal' => $validated['tk_lokal'],
                'tk_luar' => $validated['tk_luar'],
                'tk_non_konstruksi_jumlah' => $validated['tk_non_konstruksi_jumlah'] ?? null,
                'tk_non_konstruksi_ket' => $validated['tk_non_konstruksi_ket'] ?? null,
                'kendala' => $request->kendala ?? null,
                'cctv' => $request->cctv ?? null,
            ]);

            ProgresKnmpDetail::where('progres_id', $progres->id)->delete();

            foreach ($validated['progress'] as $kode => $items) {
                foreach ($items as $row) {
                    if (
                        empty($row['target']) &&
                        empty($row['persen']) &&
                        empty($row['keterangan'])
                    ) {
                        continue;
                    }

                    ProgresKnmpDetail::create([
                        'progres_id' => $progres->id,
                        'kode' => $kode,
                        'komponen' => $row['komponen'],
                        'target' => $row['target'],
                        'persen' => $row['persen'],
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres Pembangunan KNMP berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
