<?php

namespace App\Http\Controllers;

use App\Models\DetailKomponen;
use App\Models\Kendala;
use App\Models\Knmp as ModelsKnmp;
use App\Models\ProfileKnmp;
use App\Models\ProgresTambahan;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    public function index($knmpId)
    {
        $knmp = ModelsKnmp::findOrFail($knmpId);
        return view('survey.forms.index', compact('knmp'));
    }

    public function store_profile_knmp(Request $request)
    {
        $validatedData = $request->validate([
            // --- PROFILE KNMP (Disinkronkan dengan Input HTML Baru) ---
            'knmp_id'                       => 'required|integer|min:0',
            'jumlah_penduduk'               => 'required|integer|min:0',
            'jumlah_nelayan'                => 'required|integer|min:0',
            'pendapatan_rata_rata'          => 'required|numeric|min:0',
            'volume_produksi'               => 'required|numeric|min:0',
            'nilai_produksi'                => 'required|numeric|min:0',

            // Komoditas dan Harga
            'komoditas_1'                   => 'nullable|string|max:255',
            'komoditas_2'                   => 'nullable|string|max:255',
            'harga_komoditas_1'             => 'nullable|numeric|min:0', // Baru
            'harga_komoditas_2'             => 'nullable|numeric|min:0', // Baru

            // Infrastruktur
            'infrastruktur_pendukung'       => 'nullable|array',
            'infrastruktur_pendukung.*'     => 'string|max:50',

            // Data Koperasi & Anggota
            'calon_koperasi'                => 'nullable|string|max:255',
            'nama_ketua'                    => 'nullable|string|max:255',
            'sk_kopdeskel'                  => 'nullable|string|max:255',
            'nomor_induk'                   => 'nullable|string|max:255',
            'jumlah_anggota_laki'           => 'nullable|integer|min:0',
            'jumlah_anggota_perempuan'      => 'nullable|integer|min:0',
            'koordinat_lokasi'              => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $infrastrukturYangAda = $request->input('infrastruktur_pendukung', []);

            $profilData = [
                // Data Utama Profil KNMP
                'knmp_id'                      => $validatedData['knmp_id'],
                'jml_penduduk_des'             => $validatedData['jumlah_penduduk'],
                'jml_nelayan'                  => $validatedData['jumlah_nelayan'],
                'pendapatan_rata_rata_nelayan' => $validatedData['pendapatan_rata_rata'],
                'volume_produksi_ton'          => $validatedData['volume_produksi'],
                'nilai_produksi'               => $validatedData['nilai_produksi'],

                // Data Komoditas Utama & Harga
                'komoditas_utama_1'            => $validatedData['komoditas_1'],
                'komoditas_utama_2'            => $validatedData['komoditas_2'],
                'harga_rata_komoditas_1'       => $validatedData['harga_komoditas_1'],
                'harga_rata_komoditas_2'       => $validatedData['harga_komoditas_2'],

                // Data Infrastruktur (Memetakan Checkbox ke Kolom Boolean)
                'infra_jalan_akses'            => in_array('jalan_akses', $infrastrukturYangAda),
                'infra_listrik'                => in_array('listrik', $infrastrukturYangAda),
                'infra_air_bersih'             => in_array('air_bersih', $infrastrukturYangAda),
                'infra_internet'               => in_array('internet', $infrastrukturYangAda),
                'infra_ipal'                   => in_array('ipal', $infrastrukturYangAda),
                'infra_dermaga_tambat'         => in_array('dermaga_tambat', $infrastrukturYangAda),
                'infra_tpi'                    => in_array('tpi', $infrastrukturYangAda),
                'infra_cold_storage'           => in_array('cold_storage', $infrastrukturYangAda),
                'infra_pabrik_es'              => in_array('pabrik_es', $infrastrukturYangAda),
                'infra_kantor_koperasi'        => in_array('kantor_koperasi', $infrastrukturYangAda),
                'infra_bengkel_nelayan'        => in_array('bengkel_nelayan', $infrastrukturYangAda),
                'infra_waserda'                => in_array('waserda', $infrastrukturYangAda),

                // Data Koperasi dan Lokasi
                'calon_koperasi'               => $validatedData['calon_koperasi'],
                'nama_ketua'                   => $validatedData['nama_ketua'],
                'sk_kopdeskel'                 => $validatedData['sk_kopdeskel'],
                'nomor_induk_kopdeskel'        => $validatedData['nomor_induk'],
                'jumlah_anggota_laki'          => $validatedData['jumlah_anggota_laki'],
                'jumlah_anggota_perempuan'     => $validatedData['jumlah_anggota_perempuan'],
                'koordinat_lokasi'             => $validatedData['koordinat_lokasi'],
            ];

            $knmpId = $validatedData['knmp_id'];

            $profil = ProfileKnmp::updateOrCreate(
                ['id' => ($knmpId > 0) ? $knmpId : null],
                $profilData
            );

            DB::commit();

            return redirect()->back()->with('success', 'Data Profil KNMP berhasil disimpan dan diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data Profile KNMP. Error: ' . $e->getMessage());
        }
    }

    public function store_tanggapan_masyarakat(Request $request)
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

        $kesesuaianBoolean = false;

        if (isset($validatedData['sesuai_kebutuhan'])) {
            $kesesuaianBoolean = ($validatedData['sesuai_kebutuhan'] === 'Ya, sesuai');
        }

        $dataToStore = [
            'kesesuaian_kebutuhan'    => $kesesuaianBoolean,
            'item_tidak_sesuai'       => $validatedData['tidak_sesuai_item'],
            'tingkat_kesenangan'      => $validatedData['senang'],
            'alasan_tidak_senang'     => $validatedData['alasan_tidak_senang'],
            'harapan_masyarakat'      => $validatedData['harapan_masyarakat'],
            'masukan_saran_perbaikan' => $validatedData['masukan_saran'],
        ];

        TanggapanMasyarakat::updateOrCreate(
            ['knmp_id' => $validatedData['knmp_id']],
            $dataToStore
        );

        return redirect()->back()->with('success', 'Tanggapan masyarakat berhasil disimpan/diperbarui.');
    }

    public function store_tingkat_kebahagiaan(Request $request)
    {
        // 1. Definisikan Pilihan dan Struktur Soal
        $pilihan = ['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju'];

        $sections = [
            'kepuasan_hidup_personal' => [1, 2, 3, 4, 5, 6, 7, 8],
            'kepuasan_hidup_sosial' => [9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            'perasaan' => [19, 20, 21, 22, 23, 24],
            'makna_hidup' => [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36],
        ];

        // Skala Skor Likert (1=Paling Negatif, 5=Paling Positif)
        $skorNilai = [
            'Sangat Tidak Setuju' => 1,
            'Tidak Setuju' => 2,
            'Netral' => 3,
            'Setuju' => 4,
            'Sangat Setuju' => 5
        ];

        // 2. Persiapkan Aturan Validasi
        $validationRules = [
            'knmp_id' => 'required|integer|exists:profile_knmp,id', // Asumsi Foreign Key ada di profile_knmp
        ];
        foreach ($sections as $prefix => $numbers) {
            foreach ($numbers as $no) {
                // Field name yang dihasilkan: prefix_no (e.g., kepuasan_hidup_personal_1)
                $fieldName = $prefix . '_' . $no;
                $validationRules[$fieldName] = 'required|string|in:' . implode(',', $pilihan);
            }
        }

        // 3. Lakukan Validasi
        $validatedData = $request->validate($validationRules);
        $knmpId = $validatedData['knmp_id'];

        try {
            DB::beginTransaction();

            // Hapus jawaban lama untuk memastikan data terbaru (update)
            TingkatKebahagiaanNelayan::where('knmp_id', $knmpId)->delete();

            $dataToInsert = [];

            // 4. Loop untuk Memproses dan Menyiapkan Data
            foreach ($sections as $kategori => $numbers) {
                foreach ($numbers as $no) {
                    $fieldName = $kategori . '_' . $no;
                    $jawabanTeks = $validatedData[$fieldName];

                    $dataToInsert[] = [
                        'knmp_id' => $knmpId,
                        'nomor_soal' => $no,
                        'kategori' => $kategori,
                        'jawaban_teks' => $jawabanTeks,
                        'skor_nilai' => $skorNilai[$jawabanTeks],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // 5. Simpan semua data sekaligus (Mass Insertion)
            TingkatKebahagiaanNelayan::insert($dataToInsert);

            DB::commit();

            return redirect()->back()->with('success', 'Kuesioner kebahagiaan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Pastikan semua pertanyaan telah dijawab.');
        }
    }
}
