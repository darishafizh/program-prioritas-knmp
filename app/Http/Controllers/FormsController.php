<?php

namespace App\Http\Controllers;

use App\Models\DetailKomponen;
use App\Models\DetailPemasaranIkan;
use App\Models\DetailPenjualanIkan;
use App\Models\District;
use App\Models\InformasiPemasaran;
use App\Models\InformasiPendapatanRumahTangga;
use App\Models\InformasiResponden;
use App\Models\InformasiUsaha;
use App\Models\InformasiUsahaIkan;
use App\Models\Kendala;
use App\Models\Knmp as ModelsKnmp;
use App\Models\KnmpDistricts;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpVillages;
use App\Models\ProfileKnmp;
use App\Models\ProgresTambahan;
use App\Models\Province;
use App\Models\Regency;
use App\Models\SosialKelembagaan;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use App\Models\Village;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    public function index($knmpId)
    {
        $knmp = ModelsKnmp::with([
            'province',
            'regency',
            'district',
            'village'
        ])->findOrFail($knmpId);

        $provinces = KnmpProvinces::where('id', $knmp->province_id)->get();
        $regencies = KnmpRegencies::where('id', $knmp->regency_id)->get();
        $districts = KnmpDistricts::where('id', $knmp->district_id)->get();
        $villages = KnmpVillages::where('id', $knmp->village_id)->get();

        return view('survey.forms.index', compact('knmp', 'provinces', 'regencies', 'districts', 'villages'));
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
            'tidak_sesuai_item'    => 'required_if:sesuai_kebutuhan,Tidak sesuai|nullable|string',
            'senang'               => 'required|string|in:Senang,Biasa saja,Tidak Senang',
            'alasan_tidak_senang'  => 'required_if:senang,Tidak Senang|nullable|string',
            'harapan_masyarakat'   => 'required|string',
            'masukan_saran'        => 'required|string',
        ]);

        try {
            $kesesuaianBoolean = ($validatedData['sesuai_kebutuhan'] === 'Ya, sesuai');

            $dataToStore = [
                'kesesuaian_kebutuhan'    => $kesesuaianBoolean,
                'item_tidak_sesuai'       => $validatedData['tidak_sesuai_item'] ?? null,
                'tingkat_kesenangan'      => $validatedData['senang'],
                'alasan_tidak_senang'     => $validatedData['alasan_tidak_senang'] ?? null,
                'harapan_masyarakat'      => $validatedData['harapan_masyarakat'] ?? null,
                'masukan_saran_perbaikan' => $validatedData['masukan_saran'] ?? null,
            ];

            TanggapanMasyarakat::updateOrCreate(
                ['knmp_id' => $validatedData['knmp_id']],
                $dataToStore
            );

            return redirect()->back()->with('success', 'Tanggapan masyarakat berhasil disimpan/diperbarui.');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function store_tingkat_kebahagiaan(Request $request)
    {
        // Validasi dasar
        $validated = $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
        ]);

        $knmp_id = $request->knmp_id;

        // Mapping nilai jawaban ke skor
        $skorMap = [
            'Sangat Tidak Setuju' => 1,
            'Tidak Setuju'        => 2,
            'Netral'              => 3,
            'Setuju'              => 4,
            'Sangat Setuju'       => 5,
        ];

        // Loop semua input radio
        foreach ($request->all() as $key => $value) {

            // Abaikan field bukan jawaban
            if (!str_contains($key, '_')) {
                continue;
            }

            // Format key: kategori_no → contoh: kepuasan_hidup_personal_3
            if (preg_match('/^(.*)_(\d+)$/', $key, $matches)) {

                $kategori = $matches[1];     // kepuasan_hidup_personal
                $nomorSoal = (int) $matches[2]; // 3
                $jawabanTeks = $value;

                // Tentukan skor
                $skor = $skorMap[$jawabanTeks] ?? null;

                // Simpan ke database
                TingkatKebahagiaanNelayan::updateOrCreate(
                    [
                        'knmp_id'     => $knmp_id,
                        'nomor_soal'  => $nomorSoal,
                    ],
                    [
                        'kategori'     => $kategori,
                        'jawaban_teks' => $jawabanTeks,
                        'skor_nilai'   => $skor,
                    ]
                );
            }
        }

        return back()->with('success', 'Data tingkat kebahagiaan berhasil disimpan.');
    }

    public function store_informasi_responden(Request $request, $knmpId)
    {
        $validated = $request->validate([
            'nama_responden' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'nomor_kusuka' => 'nullable|string|max:30',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer|min:0',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'suku_bangsa' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'wpp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp_responden' => 'nullable|string|max:20',

            'jumlah_anggota_rumah' => 'nullable|integer|min:0',
            'jumlah_anggota_perempuan_rumah' => 'nullable|integer|min:0',
            'jumlah_anggota_bekerja' => 'nullable|integer|min:0',
            'jumlah_anggota_perempuan_bekerja' => 'nullable|integer|min:0',

            'jumlah_abk' => 'nullable|integer|min:0',
            'pengalaman_usaha' => 'nullable|integer|min:0',

            'province_id' => 'nullable|integer',
            'regency_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'village_id' => 'nullable|integer',

            'tanggal_wawancara' => 'nullable|date',
            'nama_enumerator' => 'nullable|string|max:255',
            'jenis_kelamin_enumerator' => 'nullable|in:Laki-laki,Perempuan',
            'no_hp_enumerator' => 'nullable|string|max:20',
        ]);

        $validated['knmp_id'] = $knmpId;

        InformasiResponden::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Informasi responden berhasil disimpan');
    }

    public function store_informasi_usaha(Request $request)
    {
        try {
            $request->validate([
                'knmp_id' => 'required|integer|exists:knmp,id',
                'ikan_utama' => 'array',
            ]);

            // A & B langsung ambil semua tanpa filter
            $data = $request->except(['_token', 'ikan_utama']);

            // Simpan A & B
            $usaha = InformasiUsaha::updateOrCreate(
                ['knmp_id' => $request->knmp_id],
                $data
            );

            // Simpan C (ikan utama)
            $usaha->ikan()->delete(); // reset

            if ($request->has('ikan_utama')) {
                foreach ($request->ikan_utama as $row) {
                    if (!empty($row['jenis'])) {
                        InformasiUsahaIkan::create([
                            'informasi_usaha_id' => $usaha->id,
                            'jenis' => $row['jenis'] ?? null,
                            'kg_trip' => $row['kg_trip'] ?? null,
                            'persen' => $row['persen'] ?? null,
                        ]);
                    }
                }
            }

            return back()->with('success', 'Data informasi usaha berhasil disimpan.');
        } catch (\Exception $e) {
            throw $e; // agar error tampil langsung di browser
        }
    }

    public function store_pemasaran_perikanan(Request $request)
    {
        $validatedData = $request->validate([
            'knmp_id' => 'required|integer|min:0',

            'pemasaran_eceran_kg' => 'nullable|numeric|min:0',
            'pemasaran_koperasi_kg' => 'nullable|numeric|min:0',
            'pemasaran_tengkulak_kg' => 'nullable|numeric|min:0',
            'pemasaran_pengepul_kg' => 'nullable|numeric|min:0',
            'pemasaran_pedagang_besar_kg' => 'nullable|numeric|min:0',
            'pemasaran_lainnya_kg' => 'nullable|numeric|min:0',
            'pemasaran_lainnya_ket' => 'nullable|string|max:255',

            'kendala_pemasaran' => 'nullable|string',
            'cara_penanganan_ikan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $informasiPemasaran = InformasiPemasaran::updateOrCreate(
                ['knmp_id' => $validatedData['knmp_id']],
                [
                    'kendala_pemasaran_text' => $validatedData['kendala_pemasaran'] ?? null,
                    'cara_penanganan_ikan'   => $validatedData['cara_penanganan_ikan'] ?? null,
                ]
            );

            DetailPemasaranIkan::updateOrCreate(
                ['pemasaran_id' => $informasiPemasaran->id],
                [
                    'eceran_kg' => $validatedData['pemasaran_eceran_kg'] ?? 0,
                    'koperasi_kg' => $validatedData['pemasaran_koperasi_kg'] ?? 0,
                    'tengkulak_kg' => $validatedData['pemasaran_tengkulak_kg'] ?? 0,
                    'pengepul_kg' => $validatedData['pemasaran_pengepul_kg'] ?? 0,
                    'pedagang_besar_kg' => $validatedData['pemasaran_pedagang_besar_kg'] ?? 0,
                    'lainnya_kg' => $validatedData['pemasaran_lainnya_kg'] ?? 0,
                    'lainnya_keterangan' => $validatedData['pemasaran_lainnya_ket'] ?? null,
                ]
            );

            DB::commit();

            return back()->with('success', 'Informasi pemasaran berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // agar error tampil jelas saat debug
        }
    }

    public function store_pendapatan_rt(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'knmp_id' => 'required|exists:knmp,id',

            'pendapatan_perikanan' => 'nullable|numeric|min:0',
            'pendapatan_non_perikanan' => 'nullable|numeric|min:0',
            'pendapatan_total' => 'nullable|numeric|min:0',

            'kontribusi_nelayan_persen' => 'nullable|string|max:255',
            'jumlah_sumber_penghasilan' => 'nullable|string|max:255',
            'ketergantungan_perikanan' => 'nullable|string|max:255',
            'stabilitas_pendapatan' => 'nullable|string|max:255',
            'keterlibatan_perempuan' => 'nullable|string|max:255',
            'kontribusi_perempuan_persen' => 'nullable|string|max:255',
        ]);

        $validated['pendapatan_total'] = $request->pendapatan_total;

        $data = InformasiPendapatanRumahTangga::updateOrCreate(
            ['knmp_id' => $validated['knmp_id']],
            $validated
        );

        return redirect()->back()->with('success', 'Informasi pendapatan rumah tangga berhasil disimpan.');
    }

    public function store_sosial_kelembagaan(Request $request)
    {
        $validated = $request->validate([
            'knmp_id' => 'required|exists:knmp,id',

            'anggota_kelompok' => 'nullable|string',
            'manfaat_kelompok' => 'nullable|string',
            'anggota_koperasi' => 'nullable|string',
            'tertarik_koperasi' => 'nullable|string',
            'manfaat_koperasi' => 'nullable|string',

            'koperasi_rapat_tahunan' => 'nullable|string',
            'koperasi_partisipasi_aktif' => 'nullable|string',
            'koperasi_pengurus_kompeten' => 'nullable|string',
            'koperasi_transparan' => 'nullable|string',
            'koperasi_keuangan_sehat' => 'nullable|string',
            'koperasi_jaringan_pasar' => 'nullable|string',
            'koperasi_kepercayaan_usaha' => 'nullable|string',
        ]);

        $data = SosialKelembagaan::updateOrCreate(
            ['knmp_id' => $validated['knmp_id']],
            $validated
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Data sosial & kelembagaan berhasil disimpan.',
            'data' => $data
        ]);
    }
}
