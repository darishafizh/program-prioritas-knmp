<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\ProfileKnmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileKnmpController extends Controller
{
    /**
     * Custom validation messages in Indonesian
     */
    private function validationMessages()
    {
        return [
            'knmp_id.required' => 'Data KNMP tidak valid.',
            'knmp_id.integer' => 'Data KNMP tidak valid.',
            'knmp_id.min' => 'Data KNMP tidak valid.',
            
            'jumlah_penduduk.required' => 'Jumlah Penduduk Desa wajib diisi.',
            'jumlah_penduduk.integer' => 'Jumlah Penduduk Desa harus berupa angka.',
            'jumlah_penduduk.min' => 'Jumlah Penduduk Desa tidak boleh negatif.',
            
            'jumlah_nelayan.required' => 'Jumlah Nelayan wajib diisi.',
            'jumlah_nelayan.integer' => 'Jumlah Nelayan harus berupa angka.',
            'jumlah_nelayan.min' => 'Jumlah Nelayan tidak boleh negatif.',
            
            'pendapatan_rata_rata.required' => 'Pendapatan Rata-rata Nelayan wajib diisi.',
            'pendapatan_rata_rata.numeric' => 'Pendapatan Rata-rata Nelayan harus berupa angka.',
            'pendapatan_rata_rata.min' => 'Pendapatan Rata-rata Nelayan tidak boleh negatif.',
            
            'volume_produksi.required' => 'Volume Produksi wajib diisi.',
            'volume_produksi.numeric' => 'Volume Produksi harus berupa angka.',
            'volume_produksi.min' => 'Volume Produksi tidak boleh negatif.',
            
            'nilai_produksi.required' => 'Nilai Produksi wajib diisi.',
            'nilai_produksi.numeric' => 'Nilai Produksi harus berupa angka.',
            'nilai_produksi.min' => 'Nilai Produksi tidak boleh negatif.',
            
            'komoditas_1.string' => 'Komoditas Utama 1 harus berupa teks.',
            'komoditas_1.max' => 'Komoditas Utama 1 maksimal 255 karakter.',
            
            'komoditas_2.string' => 'Komoditas Utama 2 harus berupa teks.',
            'komoditas_2.max' => 'Komoditas Utama 2 maksimal 255 karakter.',
            
            'harga_komoditas_1.numeric' => 'Harga Komoditas 1 harus berupa angka.',
            'harga_komoditas_1.min' => 'Harga Komoditas 1 tidak boleh negatif.',
            
            'harga_komoditas_2.numeric' => 'Harga Komoditas 2 harus berupa angka.',
            'harga_komoditas_2.min' => 'Harga Komoditas 2 tidak boleh negatif.',
            
            'calon_koperasi.string' => 'Calon Koperasi harus berupa teks.',
            'calon_koperasi.max' => 'Calon Koperasi maksimal 255 karakter.',
            
            'nama_ketua.string' => 'Nama Ketua harus berupa teks.',
            'nama_ketua.max' => 'Nama Ketua maksimal 255 karakter.',
            
            'sk_kopdeskel.string' => 'SK Kopdeskel harus berupa teks.',
            'sk_kopdeskel.max' => 'SK Kopdeskel maksimal 255 karakter.',
            
            'nomor_induk.string' => 'Nomor Induk Kopdeskel harus berupa teks.',
            'nomor_induk.max' => 'Nomor Induk Kopdeskel maksimal 255 karakter.',
            
            'jumlah_anggota_laki.integer' => 'Jumlah Anggota Laki-laki harus berupa angka.',
            'jumlah_anggota_laki.min' => 'Jumlah Anggota Laki-laki tidak boleh negatif.',
            
            'jumlah_anggota_perempuan.integer' => 'Jumlah Anggota Perempuan harus berupa angka.',
            'jumlah_anggota_perempuan.min' => 'Jumlah Anggota Perempuan tidak boleh negatif.',
            
            'koordinat_lokasi.string' => 'Koordinat Lokasi harus berupa teks.',
            'koordinat_lokasi.max' => 'Koordinat Lokasi maksimal 255 karakter.',
        ];
    }

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
        ], $this->validationMessages());

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
            return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi atau hubungi administrator.');
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
        ], $this->validationMessages());

        DB::beginTransaction();
        try {
            $profile = ProfileKnmp::where('knmp_id', $knmp->id)->first();

            if (!$profile) {
                return back()->with('error', 'Data Profil KNMP tidak ditemukan. Silakan refresh halaman.');
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
            return back()->with('error', 'Gagal memperbarui data. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
