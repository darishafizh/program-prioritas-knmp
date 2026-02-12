<?php

namespace App\Http\Controllers;

use App\Models\SosialKelembagaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SosialController extends Controller
{
    /**
     * Store Sosial & Kelembagaan
     */
    public function store(Request $request, $knmp)
    {
        $validated = $request->validate([
            'responden_id' => 'required|exists:informasi_responden,id',
            'anggota_kelompok' => 'required|string',
            'manfaat_kelompok' => 'required|string',
            'anggota_koperasi' => 'required|string',
            'tertarik_koperasi' => 'required|string',
            'manfaat_koperasi' => 'required|string',
            'koperasi_rapat_tahunan' => 'required|string',
            'koperasi_partisipasi_aktif' => 'required|string',
            'koperasi_pengurus_kompeten' => 'required|string',
            'koperasi_transparan' => 'required|string',
            'koperasi_keuangan_sehat' => 'required|string',
            'koperasi_jaringan_pasar' => 'required|string',
            'koperasi_kepercayaan_usaha' => 'required|string',
        ], [
            'required' => 'Wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            SosialKelembagaan::updateOrCreate(
                [
                    'knmp_id' => $knmp,
                    'responden_id' => $validated['responden_id'],
                ],
                [
                    'anggota_kelompok' => $validated['anggota_kelompok'],
                    'manfaat_kelompok' => $validated['manfaat_kelompok'],
                    'anggota_koperasi' => $validated['anggota_koperasi'],
                    'tertarik_koperasi' => $validated['tertarik_koperasi'],
                    'manfaat_koperasi' => $validated['manfaat_koperasi'],
                    'koperasi_rapat_tahunan' => $validated['koperasi_rapat_tahunan'],
                    'koperasi_partisipasi_aktif' => $validated['koperasi_partisipasi_aktif'],
                    'koperasi_pengurus_kompeten' => $validated['koperasi_pengurus_kompeten'],
                    'koperasi_transparan' => $validated['koperasi_transparan'],
                    'koperasi_keuangan_sehat' => $validated['koperasi_keuangan_sehat'],
                    'koperasi_jaringan_pasar' => $validated['koperasi_jaringan_pasar'],
                    'koperasi_kepercayaan_usaha' => $validated['koperasi_kepercayaan_usaha'],
                ]
            );

            DB::commit();
            return back()->with('success', 'Data Sosial & Kelembagaan berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
