<?php

namespace App\Http\Controllers;

use App\Models\ProgresPembangunanKnmp;
use App\Models\KategoriKomponen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresPembangunanKnmpController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'knmp_id' => 'required|integer|exists:knmp,id',

            'total_anggaran' => 'nullable|numeric',
            'anggaran_konstruksi' => 'nullable|numeric',
            'anggaran_sarpras' => 'nullable|numeric',

            'konstruksi' => 'nullable|array',
            'bantuan_b' => 'nullable|array',
            'bantuan_c' => 'nullable|array',
            'spbu' => 'nullable|array',

            'tk_konstruksi_l' => 'nullable|integer',
            'tk_konstruksi_p' => 'nullable|integer',
            'upah_per_hari' => 'nullable|numeric',
            'lama_bekerja' => 'nullable|integer',
            'tk_lokal' => 'nullable|integer',
            'tk_luar' => 'nullable|integer',
            'tk_non_konstruksi' => 'nullable|string',

            'kendala' => 'nullable|array',
            'cctv' => 'nullable|in:Ya,Tidak',
        ]);

        DB::beginTransaction();
        try {

            // SIMPAN DATA UTAMA
            $progres = ProgresPembangunanKnmp::create([
                'knmp_id' => $validated['knmp_id'],
                'total_anggaran' => $validated['total_anggaran'] ?? null,
                'anggaran_konstruksi' => $validated['anggaran_konstruksi'] ?? null,
                'anggaran_sarpras' => $validated['anggaran_sarpras'] ?? null,
                'tk_konstruksi_l' => $validated['tk_konstruksi_l'] ?? null,
                'tk_konstruksi_p' => $validated['tk_konstruksi_p'] ?? null,
                'upah_per_hari' => $validated['upah_per_hari'] ?? null,
                'lama_bekerja' => $validated['lama_bekerja'] ?? null,
                'tk_lokal' => $validated['tk_lokal'] ?? null,
                'tk_luar' => $validated['tk_luar'] ?? null,
                'tk_non_konstruksi' => $validated['tk_non_konstruksi'] ?? null,
                'kendala' => $validated['kendala'] ?? [],
                'cctv' => $validated['cctv'] ?? null,
            ]);

            // INSERT KOMPONEN
            $this->insertKategori($progres, $request->konstruksi, "Konstruksi");
            $this->insertKategori($progres, $request->bantuan_b, "Bantuan Kapal/Mesin/API");
            $this->insertKategori($progres, $request->bantuan_c, "Bantuan Sarana Rantai Dingin");
            $this->insertKategori($progres, $request->spbu, "SPBU Nelayan");

            // INSERT KENDALA
            if ($request->kendala) {
                foreach ($request->kendala as $k) {

                    $progres->kendalaRel()->create([
                        'kendala_id' => $k
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres pembangunan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    private function insertKategori($progres, $list, $kategoriNama)
    {
        if (!$list) return;

        $kategori = KategoriKomponen::where('nama_kategori', $kategoriNama)->first();

        if (!$kategori) {
            throw new \Exception("Kategori '$kategoriNama' tidak ditemukan.");
        }

        foreach ($list as $item) {
            if (empty($item['komponen'])) continue;

            $progres->progresKomponen()->create([
                'kategori_id' => $kategori->id,
                'komponen' => $item['komponen'],
                'target' => $item['target'] ?? null,
                'progress' => $item['progress'] ?? null,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }
    }
}
