<?php

namespace App\Http\Controllers;

use App\Models\DetailKomponen;
use App\Models\Kendala;
use App\Models\Knmp as ModelsKnmp;
use App\Models\ProfileKnmp;
use App\Models\ProfilKnmp;
use App\Models\ProgresPembangunanKnmp;
use App\Models\ProgresTambahan;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    /* =====================================================
       FIX ERROR INDEX (PARAMETER OPSIONAL)
       ===================================================== */
    public function index($knmpId = null)
    {
        if (!$knmpId) {
            return redirect()->route('knmp.list')
                ->with('error', 'Silakan pilih KNMP terlebih dahulu.');
        }

        $knmp = ModelsKnmp::findOrFail($knmpId);
        return view('survey.forms.index', compact('knmp'));
    }

    /* =====================================================
       FIX ROUTE ERROR: /forms memanggil formsIndex()
       ===================================================== */
    public function formsIndex()
    {
        // ambil knmp pertama untuk dibuka
        $firstKnmp = ModelsKnmp::orderBy('id')->first();

        if ($firstKnmp) {
            return $this->index($firstKnmp->id); // panggil fungsi index Anda
        }

        // jika tidak ada data KNMP sama sekali
        return redirect()->route('knmp.list')
            ->with('error', 'Belum ada data KNMP. Silakan input KNMP terlebih dahulu.');
    }

    /* =====================================================
       STORE PROFIL KNMP
       ===================================================== */
    public function store_profile_knmp(Request $request)
    {
        $validatedData = $request->validate([
            'knmp_id'                       => 'required|integer|min:1',
            'jumlah_penduduk'               => 'required|integer|min:0',
            'jumlah_nelayan'                => 'required|integer|min:0',
            'pendapatan_rata_rata'          => 'required|numeric|min:0',
            'volume_produksi'               => 'required|numeric|min:0',
            'nilai_produksi'                => 'required|numeric|min:0',

            'komoditas_1'                   => 'nullable|string|max:255',
            'komoditas_2'                   => 'nullable|string|max:255',
            'harga_komoditas_1'             => 'nullable|numeric|min:0',
            'harga_komoditas_2'             => 'nullable|numeric|min:0',

            'infrastruktur_pendukung'       => 'nullable|array',
            'infrastruktur_pendukung.*'     => 'string|max:50',

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

            $infra = $request->input('infrastruktur_pendukung', []);

            $profilData = [
                'knmp_id'                      => $validatedData['knmp_id'],
                'jml_penduduk_des'             => $validatedData['jumlah_penduduk'],
                'jml_nelayan'                  => $validatedData['jumlah_nelayan'],
                'pendapatan_rata_rata_nelayan' => $validatedData['pendapatan_rata_rata'],
                'volume_produksi_ton'          => $validatedData['volume_produksi'],
                'nilai_produksi'               => $validatedData['nilai_produksi'],

                'komoditas_utama_1'            => $validatedData['komoditas_1'] ?? null,
                'komoditas_utama_2'            => $validatedData['komoditas_2'] ?? null,
                'harga_rata_komoditas_1'       => $validatedData['harga_komoditas_1'] ?? null,
                'harga_rata_komoditas_2'       => $validatedData['harga_komoditas_2'] ?? null,

                'infra_jalan_akses'            => in_array('jalan_akses', $infra),
                'infra_listrik'                => in_array('listrik', $infra),
                'infra_air_bersih'             => in_array('air_bersih', $infra),
                'infra_internet'               => in_array('internet', $infra),
                'infra_ipal'                   => in_array('ipal', $infra),
                'infra_dermaga_tambat'         => in_array('dermaga_tambat', $infra),
                'infra_tpi'                    => in_array('tpi', $infra),
                'infra_cold_storage'           => in_array('cold_storage', $infra),
                'infra_pabrik_es'              => in_array('pabrik_es', $infra),
                'infra_kantor_koperasi'        => in_array('kantor_koperasi', $infra),
                'infra_bengkel_nelayan'        => in_array('bengkel_nelayan', $infra),
                'infra_waserda'                => in_array('waserda', $infra),

                'calon_koperasi'               => $validatedData['calon_koperasi'] ?? null,
                'nama_ketua'                   => $validatedData['nama_ketua'] ?? null,
                'sk_kopdeskel'                 => $validatedData['sk_kopdeskel'] ?? null,
                'nomor_induk_kopdeskel'        => $validatedData['nomor_induk'] ?? null,
                'jumlah_anggota_laki'          => $validatedData['jumlah_anggota_laki'] ?? 0,
                'jumlah_anggota_perempuan'     => $validatedData['jumlah_anggota_perempuan'] ?? 0,
                'koordinat_lokasi'             => $validatedData['koordinat_lokasi'] ?? null,
            ];

            ProfilKnmp::updateOrCreate(
                ['knmp_id' => $validatedData['knmp_id']],
                $profilData
            );

            DB::commit();
            return redirect()->back()->with('success', 'Data Profil KNMP berhasil disimpan dan diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* =====================================================
       STORE PROGRES PEMBANGUNAN
       ===================================================== */
    public function store_progres_pembangunan_knmp(Request $request, $knmp_id)
    {
        $request->validate([
            'total_anggaran' => 'nullable|numeric',
            'anggaran_konstruksi' => 'nullable|numeric',
            'anggaran_sarpras' => 'nullable|numeric',

            'konstruksi' => 'nullable|array',
            'konstruksi.*.komponen' => 'nullable|string',
            'konstruksi.*.target' => 'nullable|numeric',
            'konstruksi.*.progress' => 'nullable|numeric',
            'konstruksi.*.keterangan' => 'nullable|string',

            'bantuan_b' => 'nullable|array',
            'bantuan_b.*.komponen' => 'nullable|string',
            'bantuan_b.*.target' => 'nullable|numeric',
            'bantuan_b.*.progress' => 'nullable|numeric',
            'bantuan_b.*.keterangan' => 'nullable|string',

            'bantuan_c' => 'nullable|array',
            'bantuan_c.*.komponen' => 'nullable|string',
            'bantuan_c.*.target' => 'nullable|numeric',
            'bantuan_c.*.progress' => 'nullable|numeric',
            'bantuan_c.*.keterangan' => 'nullable|string',

            'spbu' => 'nullable|array',
            'spbu.*.komponen' => 'nullable|string',
            'spbu.*.target' => 'nullable|numeric',
            'spbu.*.progress' => 'nullable|numeric',
            'spbu.*.keterangan' => 'nullable|string',

            'tk_konstruksi_l' => 'nullable|integer',
            'tk_konstruksi_p' => 'nullable|integer',
            'upah_per_hari' => 'nullable|numeric',
            'lama_bekerja' => 'nullable|integer',
            'tk_lokal' => 'nullable|integer',
            'tk_luar' => 'nullable|integer',
            'tk_non_konstruksi' => 'nullable|string',

            'kendala' => 'nullable|array',
            'kendala.*' => 'nullable',

            'cctv' => 'nullable|in:Ya,Tidak',
        ]);

        DB::beginTransaction();

        try {

            /** =============================
             *  1) SIMPAN TABEL UTAMA
             *  ============================= */
            $progres = ProgresPembangunanKnmp::create([
                'knmp_id' => $knmp_id,
                'total_anggaran' => $request->total_anggaran,
                'anggaran_konstruksi' => $request->anggaran_konstruksi,
                'anggaran_sarpras' => $request->anggaran_sarpras,
                'tk_konstruksi_l' => $request->tk_konstruksi_l,
                'tk_konstruksi_p' => $request->tk_konstruksi_p,
                'upah_per_hari' => $request->upah_per_hari,
                'lama_bekerja' => $request->lama_bekerja,
                'tk_lokal' => $request->tk_lokal,
                'tk_luar' => $request->tk_luar,
                'tk_non_konstruksi' => $request->tk_non_konstruksi,
                'cctv' => $request->cctv,
            ]);


            /** ==================================================
             *  AMBIL kategori_id UNTUK setiap kategori komponen
             *  (WAJIB karena progres_komponen TIDAK punya kolom kategori string)
             *  ================================================== */

            $kategori = [
                'Konstruksi' => \App\Models\KategoriKomponen::firstOrCreate(['nama_kategori' => 'Konstruksi'])->id,
                'Bantuan Kapal/Mesin/API' => \App\Models\KategoriKomponen::firstOrCreate(['nama_kategori' => 'Bantuan Kapal/Mesin/API'])->id,
                'Bantuan Sarana Rantai Dingin' => \App\Models\KategoriKomponen::firstOrCreate(['nama_kategori' => 'Bantuan Sarana Rantai Dingin'])->id,
                'SPBU Nelayan' => \App\Models\KategoriKomponen::firstOrCreate(['nama_kategori' => 'SPBU Nelayan'])->id,
            ];


            /** ==================================================
             *  2) SAVE KOMPONEN
             *  ================================================== */
            $saveKomponen = function ($arr, $kategoriNama) use ($progres, $kategori) {
                $arr = $arr ?? [];

                foreach ($arr as $item) {
                    if (empty($item['komponen']) && empty($item['target'])) continue;

                    $progres->progresKomponen()->create([
                        'kategori_id' => $kategori[$kategoriNama],   // <<=== FIX PENTING!
                        'komponen' => $item['komponen'] ?? null,
                        'target' => $item['target'] ?? null,
                        'progress' => $item['progress'] ?? null,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
            };

            $saveKomponen($request->konstruksi, "Konstruksi");
            $saveKomponen($request->bantuan_b, "Bantuan Kapal/Mesin/API");
            $saveKomponen($request->bantuan_c, "Bantuan Sarana Rantai Dingin");
            $saveKomponen($request->spbu, "SPBU Nelayan");


            /** ==================================================
             *  3) SAVE KENDALA
             *  ================================================== */
            $kendalaInput = $request->kendala ?? [];

            foreach ($kendalaInput as $k) {

                // kalau angka → berarti pilih dari daftar master
                if (is_numeric($k)) {
                    $progres->kendalaRel()->create(['kendala_id' => (int) $k]);
                }

                // kalau string → buat baru di master
                elseif (!empty($k)) {
                    $km = \App\Models\KendalaMaster::firstOrCreate(
                        ['nama_kendala' => $k]
                    );

                    $progres->kendalaRel()->create(['kendala_id' => $km->id]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres pembangunan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }


    /* =====================================================
       STORE TANGGAPAN MASYARAKAT
       ===================================================== */
    public function store_tanggapan_masyarakat(Request $request, $knmpId)
    {
        $validated = $request->validate([
            'kesesuaian_kebutuhan' => 'required',
            'item_tidak_sesuai' => 'nullable|string',
            'tingkat_kesenangan' => 'required|string',
            'alasan_tidak_senang' => 'nullable|string',
            'harapan_masyarakat' => 'nullable|string',
            'masukan_saran_perbaikan' => 'nullable|string',
        ]);

        // Konversi Ya/Tidak
        $validated['kesesuaian_kebutuhan'] =
            ($request->kesesuaian_kebutuhan == '1') ? 1 : 0;

        if ($validated['kesesuaian_kebutuhan'] == 1) {
            $validated['item_tidak_sesuai'] = null;
        }

        if ($request->tingkat_kesenangan != 'Tidak Senang') {
            $validated['alasan_tidak_senang'] = null;
        }

        // PAKAI PARAMETER ROUTE
        $validated['knmp_id'] = $knmpId;

        TanggapanMasyarakat::create($validated);

        return back()->with('success', 'Data tanggapan berhasil disimpan.');
    }


    /* =====================================================
       STORE TINGKAT KEBAHAGIAAN
       ===================================================== */
    public function store_tingkat_kebahagiaan(Request $request)
    {
        $pilihan = ['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju'];

        $sections = [
            'kepuasan_hidup_personal' => [1, 2, 3, 4, 5, 6, 7, 8],
            'kepuasan_hidup_sosial'   => [9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            'perasaan'                => [19, 20, 21, 22, 23, 24],
            'makna_hidup'             => [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36],
        ];

        $skorNilai = [
            'Sangat Tidak Setuju' => 1,
            'Tidak Setuju'        => 2,
            'Netral'              => 3,
            'Setuju'              => 4,
            'Sangat Setuju'       => 5,
        ];

        $validationRules = [
            'knmp_id' => 'required|integer|min:1',
        ];

        foreach ($sections as $prefix => $numbers) {
            foreach ($numbers as $no) {
                $fieldName = $prefix . '_' . $no;
                $validationRules[$fieldName] = 'required|string|in:' . implode(',', $pilihan);
            }
        }

        $validatedData = $request->validate($validationRules);
        $knmpId        = $validatedData['knmp_id'];

        try {
            DB::beginTransaction();

            TingkatKebahagiaanNelayan::where('knmp_id', $knmpId)->delete();

            $dataToInsert = [];

            foreach ($sections as $kategori => $numbers) {
                foreach ($numbers as $no) {
                    $field   = $kategori . '_' . $no;
                    $jawaban = $validatedData[$field];

                    $dataToInsert[] = [
                        'knmp_id'      => $knmpId,
                        'nomor_soal'   => $no,
                        'kategori'     => $kategori,
                        'jawaban_teks' => $jawaban,
                        'skor_nilai'   => $skorNilai[$jawaban],
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            TingkatKebahagiaanNelayan::insert($dataToInsert);

            DB::commit();

            return redirect()->back()->with('success', 'Kuesioner kebahagiaan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}
