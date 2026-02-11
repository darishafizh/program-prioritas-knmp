<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgresController extends Controller
{
    /**
     * Custom validation messages in Indonesian
     */
    private function validationMessages()
    {
        return [
            'anggaran_total.required' => 'Total Anggaran wajib diisi.',
            'anggaran_total.numeric' => 'Total Anggaran harus berupa angka.',
            'anggaran_total.min' => 'Total Anggaran tidak boleh negatif.',

            'anggaran_konstruksi.required' => 'Anggaran Konstruksi wajib diisi.',
            'anggaran_konstruksi.numeric' => 'Anggaran Konstruksi harus berupa angka.',
            'anggaran_konstruksi.min' => 'Anggaran Konstruksi tidak boleh negatif.',

            'anggaran_sarpras.required' => 'Anggaran Pengadaan Sarpras wajib diisi.',
            'anggaran_sarpras.numeric' => 'Anggaran Pengadaan Sarpras harus berupa angka.',
            'anggaran_sarpras.min' => 'Anggaran Pengadaan Sarpras tidak boleh negatif.',

            'tk_laki.required' => 'Jumlah Tenaga Kerja Laki-laki wajib diisi.',
            'tk_laki.integer' => 'Jumlah Tenaga Kerja Laki-laki harus berupa angka.',
            'tk_laki.min' => 'Jumlah Tenaga Kerja Laki-laki tidak boleh negatif.',

            'tk_perempuan.required' => 'Jumlah Tenaga Kerja Perempuan wajib diisi.',
            'tk_perempuan.integer' => 'Jumlah Tenaga Kerja Perempuan harus berupa angka.',
            'tk_perempuan.min' => 'Jumlah Tenaga Kerja Perempuan tidak boleh negatif.',

            'tk_upah.required' => 'Upah Tenaga Kerja per Hari wajib diisi.',
            'tk_upah.integer' => 'Upah Tenaga Kerja per Hari harus berupa angka bulat.',
            'tk_upah.min' => 'Upah Tenaga Kerja per Hari tidak boleh negatif.',

            'tk_durasi.required' => 'Lama Bekerja di Proyek wajib diisi.',
            'tk_durasi.integer' => 'Lama Bekerja di Proyek harus berupa angka bulat.',
            'tk_durasi.min' => 'Lama Bekerja di Proyek tidak boleh negatif.',

            'tk_lokal.required' => 'Jumlah Tenaga Kerja Lokal wajib diisi.',
            'tk_lokal.integer' => 'Jumlah Tenaga Kerja Lokal harus berupa angka.',
            'tk_lokal.min' => 'Jumlah Tenaga Kerja Lokal tidak boleh negatif.',

            'tk_luar.required' => 'Jumlah Tenaga Kerja dari Luar wajib diisi.',
            'tk_luar.integer' => 'Jumlah Tenaga Kerja dari Luar harus berupa angka.',
            'tk_luar.min' => 'Jumlah Tenaga Kerja dari Luar tidak boleh negatif.',

            'tk_non_konstruksi_jumlah.integer' => 'Jumlah Tenaga Kerja Non Konstruksi harus berupa angka.',
            'tk_non_konstruksi_jumlah.min' => 'Jumlah Tenaga Kerja Non Konstruksi tidak boleh negatif.',

            'tk_non_konstruksi_ket.string' => 'Keterangan Tenaga Kerja Non Konstruksi harus berupa teks.',
            'tk_non_konstruksi_ket.max' => 'Keterangan Tenaga Kerja Non Konstruksi maksimal 255 karakter.',

            'progress.required' => 'Data Progress Pembangunan wajib diisi.',
            'progress.array' => 'Format data Progress Pembangunan tidak valid.',

            'progress.*.*.target.integer' => 'Target harus berupa angka bulat.',
            'progress.*.*.target.min' => 'Target tidak boleh negatif.',

            'progress.*.*.persen.numeric' => 'Persentase progres harus berupa angka.',
            'progress.*.*.persen.min' => 'Persentase progres minimal 0%.',
            'progress.*.*.persen.max' => 'Persentase progres maksimal 100%.',

            'progress.*.*.keterangan.string' => 'Keterangan harus berupa teks.',
            'progress.*.*.keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ];
    }

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
            'tk_upah' => 'required|integer|min:0',
            'tk_durasi' => 'required|integer|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|integer|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',
        ], $this->validationMessages());

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
            Log::error('Gagal menyimpan Progres KNMP: ' . $e->getMessage(), [
                'knmp_id' => $knmp->id,
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
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
            'tk_upah' => 'required|integer|min:0',
            'tk_durasi' => 'required|integer|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|integer|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',
        ], $this->validationMessages());

        DB::beginTransaction();

        try {
            $progres = ProgresKnmp::where('knmp_id', $knmp->id)->first();

            if (!$progres) {
                return back()->with('error', 'Data Progres KNMP tidak ditemukan. Silakan refresh halaman.');
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
            Log::error('Gagal memperbarui Progres KNMP: ' . $e->getMessage(), [
                'knmp_id' => $knmp->id,
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}
