<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\ProfileKnmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileKnmpController extends Controller
{
    /**
     * Store a new Profile KNMP
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'knmp_id' => 'required|integer|min:1',
            'jumlah_penduduk' => 'required|integer|min:0',
            'jumlah_nelayan' => 'required|integer|min:0',
            'pendapatan_rata_rata' => 'required|numeric|min:0',
            'volume_produksi' => 'required|numeric|min:0',
            'nilai_produksi' => 'required|numeric|min:0',
            'komoditas_1' => 'nullable|string|max:255',
            'komoditas_2' => 'nullable|string|max:255',
            'harga_komoditas_1' => 'nullable|numeric|min:0',
            'harga_komoditas_2' => 'nullable|numeric|min:0',
            'infrastruktur_pendukung' => 'nullable|array',
            'infrastruktur_pendukung.*' => 'string|max:50',
            'calon_koperasi' => 'nullable|string|max:255',
            'nama_ketua' => 'nullable|string|max:255',
            'sk_kopdeskel' => 'nullable|string|max:255',
            'nomor_induk' => 'nullable|string|max:255',
            'jumlah_anggota_laki' => 'nullable|integer|min:0',
            'jumlah_anggota_perempuan' => 'nullable|integer|min:0',
            'koordinat_lokasi' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $infra = $request->input('infrastruktur_pendukung', []);

            $profilData = [
                'knmp_id' => $validated['knmp_id'],
                'jml_penduduk_des' => $validated['jumlah_penduduk'],
                'jml_nelayan' => $validated['jumlah_nelayan'],
                'pendapatan_rata_rata_nelayan' => $validated['pendapatan_rata_rata'],
                'volume_produksi_ton' => $validated['volume_produksi'],
                'nilai_produksi' => $validated['nilai_produksi'],
                'komoditas_utama_1' => $validated['komoditas_1'] ?? null,
                'komoditas_utama_2' => $validated['komoditas_2'] ?? null,
                'harga_rata_komoditas_1' => $validated['harga_komoditas_1'] ?? null,
                'harga_rata_komoditas_2' => $validated['harga_komoditas_2'] ?? null,
                'infra_jalan_akses' => in_array('jalan_akses', $infra),
                'infra_listrik' => in_array('listrik', $infra),
                'infra_air_bersih' => in_array('air_bersih', $infra),
                'infra_internet' => in_array('internet', $infra),
                'infra_ipal' => in_array('ipal', $infra),
                'infra_dermaga_tambat' => in_array('dermaga_tambat', $infra),
                'infra_tpi' => in_array('tpi', $infra),
                'infra_cold_storage' => in_array('cold_storage', $infra),
                'infra_pabrik_es' => in_array('pabrik_es', $infra),
                'infra_kantor_koperasi' => in_array('kantor_koperasi', $infra),
                'infra_bengkel_nelayan' => in_array('bengkel_nelayan', $infra),
                'infra_waserda' => in_array('waserda', $infra),
                'calon_koperasi' => $validated['calon_koperasi'] ?? null,
                'nama_ketua' => $validated['nama_ketua'] ?? null,
                'sk_kopdeskel' => $validated['sk_kopdeskel'] ?? null,
                'nomor_induk_kopdeskel' => $validated['nomor_induk'] ?? null,
                'jumlah_anggota_laki' => $validated['jumlah_anggota_laki'] ?? 0,
                'jumlah_anggota_perempuan' => $validated['jumlah_anggota_perempuan'] ?? 0,
                'koordinat_lokasi' => $validated['koordinat_lokasi'] ?? null,
            ];

            ProfileKnmp::create($profilData);

            DB::commit();
            return back()->with('success', 'Profil KNMP berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update existing Profile KNMP
     */
    public function update(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'jumlah_penduduk' => 'required|integer|min:0',
            'jumlah_nelayan' => 'required|integer|min:0',
            'pendapatan_rata_rata' => 'required|numeric|min:0',
            'volume_produksi' => 'required|numeric|min:0',
            'nilai_produksi' => 'required|numeric|min:0',
            'komoditas_1' => 'nullable|string|max:255',
            'komoditas_2' => 'nullable|string|max:255',
            'harga_komoditas_1' => 'nullable|numeric|min:0',
            'harga_komoditas_2' => 'nullable|numeric|min:0',
            'infrastruktur_pendukung' => 'nullable|array',
            'infrastruktur_pendukung.*' => 'string|max:50',
            'calon_koperasi' => 'nullable|string|max:255',
            'nama_ketua' => 'nullable|string|max:255',
            'sk_kopdeskel' => 'nullable|string|max:255',
            'nomor_induk' => 'nullable|string|max:255',
            'jumlah_anggota_laki' => 'nullable|integer|min:0',
            'jumlah_anggota_perempuan' => 'nullable|integer|min:0',
            'koordinat_lokasi' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $profile = ProfileKnmp::where('knmp_id', $knmp->id)->first();

            if (!$profile) {
                return back()->with('error', 'Data Profil KNMP tidak ditemukan');
            }

            $infra = $request->input('infrastruktur_pendukung', []);

            $profilData = [
                'jml_penduduk_des' => $validated['jumlah_penduduk'],
                'jml_nelayan' => $validated['jumlah_nelayan'],
                'pendapatan_rata_rata_nelayan' => $validated['pendapatan_rata_rata'],
                'volume_produksi_ton' => $validated['volume_produksi'],
                'nilai_produksi' => $validated['nilai_produksi'],
                'komoditas_utama_1' => $validated['komoditas_1'] ?? null,
                'komoditas_utama_2' => $validated['komoditas_2'] ?? null,
                'harga_rata_komoditas_1' => $validated['harga_komoditas_1'] ?? null,
                'harga_rata_komoditas_2' => $validated['harga_komoditas_2'] ?? null,
                'infra_jalan_akses' => in_array('jalan_akses', $infra),
                'infra_listrik' => in_array('listrik', $infra),
                'infra_air_bersih' => in_array('air_bersih', $infra),
                'infra_internet' => in_array('internet', $infra),
                'infra_ipal' => in_array('ipal', $infra),
                'infra_dermaga_tambat' => in_array('dermaga_tambat', $infra),
                'infra_tpi' => in_array('tpi', $infra),
                'infra_cold_storage' => in_array('cold_storage', $infra),
                'infra_pabrik_es' => in_array('pabrik_es', $infra),
                'infra_kantor_koperasi' => in_array('kantor_koperasi', $infra),
                'infra_bengkel_nelayan' => in_array('bengkel_nelayan', $infra),
                'infra_waserda' => in_array('waserda', $infra),
                'calon_koperasi' => $validated['calon_koperasi'] ?? null,
                'nama_ketua' => $validated['nama_ketua'] ?? null,
                'sk_kopdeskel' => $validated['sk_kopdeskel'] ?? null,
                'nomor_induk_kopdeskel' => $validated['nomor_induk'] ?? null,
                'jumlah_anggota_laki' => $validated['jumlah_anggota_laki'] ?? 0,
                'jumlah_anggota_perempuan' => $validated['jumlah_anggota_perempuan'] ?? 0,
                'koordinat_lokasi' => $validated['koordinat_lokasi'] ?? null,
            ];

            $profile->update($profilData);

            DB::commit();
            return back()->with('success', 'Profil KNMP berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
