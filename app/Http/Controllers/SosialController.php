<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\SosialKelembagaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SosialController extends Controller
{
    /**
     * Store Sosial & Kelembagaan
     */
    /**
     * Store Sosial & Kelembagaan
     */
    public function store(Request $request, Knmp $knmp)
    {
        // Validation: allow string because input might come as text from form
        $request->validate([
            'responden_id' => 'required|exists:informasi_responden,id',
            // fields can be string (text) or integer (if already score)
            'anggota_kelompok' => 'nullable',
            'manfaat_kelompok' => 'nullable',
            'anggota_koperasi' => 'nullable',
            'tertarik_koperasi' => 'nullable',
            'manfaat_koperasi' => 'nullable',
            'koperasi_rapat_tahunan' => 'nullable',
            'koperasi_partisipasi_aktif' => 'nullable',
            'koperasi_pengurus_kompeten' => 'nullable',
            'koperasi_transparan' => 'nullable',
            'koperasi_keuangan_sehat' => 'nullable',
            'koperasi_jaringan_pasar' => 'nullable',
            'koperasi_kepercayaan_usaha' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            SosialKelembagaan::updateOrCreate(
                [
                    'knmp_id' => $knmp->id,
                    'responden_id' => $request->responden_id,
                ],
                [
                    'anggota_kelompok' => $this->getScore('anggota_kelompok', $request->anggota_kelompok),
                    'manfaat_kelompok' => $this->getScore('manfaat_kelompok', $request->manfaat_kelompok),
                    'anggota_koperasi' => $this->getScore('anggota_koperasi', $request->anggota_koperasi),
                    'tertarik_koperasi' => $this->getScore('tertarik_koperasi', $request->tertarik_koperasi),
                    'manfaat_koperasi' => $this->getScore('manfaat_koperasi', $request->manfaat_koperasi),
                    
                    'koperasi_rapat_tahunan' => $this->getScore('ya_tidak', $request->koperasi_rapat_tahunan),
                    'koperasi_partisipasi_aktif' => $this->getScore('ya_tidak', $request->koperasi_partisipasi_aktif),
                    'koperasi_pengurus_kompeten' => $this->getScore('ya_tidak', $request->koperasi_pengurus_kompeten),
                    'koperasi_transparan' => $this->getScore('ya_tidak', $request->koperasi_transparan),
                    'koperasi_keuangan_sehat' => $this->getScore('ya_tidak', $request->koperasi_keuangan_sehat),
                    'koperasi_jaringan_pasar' => $this->getScore('ya_tidak', $request->koperasi_jaringan_pasar),
                    'koperasi_kepercayaan_usaha' => $this->getScore('ya_tidak', $request->koperasi_kepercayaan_usaha),
                ]
            );

            DB::commit();
            return back()->with('success', 'Data Sosial & Kelembagaan berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Helper to map text answers to scores
     */
    private function getScore($type, $value)
    {
        if (is_null($value)) return null;
        if (is_numeric($value)) return (int) $value; // Already a score

        $val = strtolower(trim($value));

        if ($type === 'anggota_kelompok' || $type === 'anggota_koperasi') {
            if (str_contains($val, 'sangat aktif')) return 4;
            if (str_contains($val, 'tidak aktif')) return 3;
            if (str_contains($val, 'tidak pernah')) return 2;
            if (str_contains($val, 'tidak ada')) return 1;
        }

        if ($type === 'manfaat_kelompok' || $type === 'manfaat_koperasi') {
            if (str_contains($val, 'sangat setuju')) return 5; // Assuming 5 scale
            if ($val === 'setuju') return 4;
            if (str_contains($val, 'cukup')) return 3;
            if (str_contains($val, 'kurang')) return 2;
            if (str_contains($val, 'tidak setuju')) return 1;
        }

        if ($type === 'tertarik_koperasi') {
             if (str_contains($val, 'sudah menjadi')) return 4;
             if (str_contains($val, 'sangat tidak')) return 1; // Prioritize precise match first? No, "sangat tidak" contains "tidak"
             if ($val === 'tidak tertarik') return 2;
             if ($val === 'tertarik') return 3;
        }

        if ($type === 'ya_tidak') {
            if ($val === 'ya') return 1;
            if ($val === 'tidak') return 0;
        }

        return 0; // Default fallback
    }
}
