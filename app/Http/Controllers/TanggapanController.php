<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\TanggapanMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanggapanController extends Controller
{
    /**
     * Custom validation messages in Indonesian
     */
    private function validationMessages()
    {
        return [
            'responden_id.required' => 'Responden wajib dipilih terlebih dahulu.',
            'responden_id.exists' => 'Data Responden tidak valid. Silakan pilih ulang.',

            'kesesuaian_kebutuhan.required' => 'Kesesuaian Kebutuhan wajib dipilih.',
            'kesesuaian_kebutuhan.boolean' => 'Pilihan Kesesuaian Kebutuhan tidak valid.',

            'item_tidak_sesuai.required' => 'Item yang Tidak Sesuai wajib diisi jika memilih "Tidak Sesuai".',
            'item_tidak_sesuai.string' => 'Item yang Tidak Sesuai harus berupa teks.',

            'tingkat_kesenangan.required' => 'Tingkat Kesenangan wajib dipilih.',
            'tingkat_kesenangan.string' => 'Tingkat Kesenangan tidak valid.',

            'alasan_tidak_senang.required' => 'Alasan Tidak Senang wajib diisi jika memilih "Tidak Senang".',
            'alasan_tidak_senang.string' => 'Alasan Tidak Senang harus berupa teks.',

            'harapan_masyarakat.required' => 'Harapan Masyarakat wajib diisi.',
            'harapan_masyarakat.string' => 'Harapan Masyarakat harus berupa teks.',

            'masukan_saran_perbaikan.required' => 'Masukan/Saran Perbaikan wajib diisi.',
            'masukan_saran_perbaikan.string' => 'Masukan/Saran Perbaikan harus berupa teks.',
        ];
    }

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

        $validated = $request->validate($rules, $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $knmp) {
                TanggapanMasyarakat::updateOrCreate(
                    [
                        'knmp_id' => $knmp->id,
                        'responden_id' => $validated['responden_id'],
                    ],
                    [
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
                    ]
                );
            });

            return back()->with('success', 'Tanggapan Masyarakat berhasil disimpan');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi atau hubungi administrator.');
        }
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

        $validated = $request->validate($rules, $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $knmp, $request) {
                $tanggapan = TanggapanMasyarakat::where('knmp_id', $knmp->id)
                    ->where('responden_id', $validated['responden_id'])
                    ->first();

                if (!$tanggapan) {
                    throw new \Exception('Data Tanggapan tidak ditemukan');
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
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'tidak ditemukan')) {
                return back()->with('error', 'Data Tanggapan tidak ditemukan. Silakan refresh halaman.');
            }
            return back()->with('error', 'Gagal memperbarui data. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
