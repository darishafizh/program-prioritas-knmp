<?php

namespace App\Http\Controllers;

use App\Models\BuktiUpload;
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
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
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

    // A. Profile KNMP
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

            ProfileKnmp::updateOrCreate(
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

    // B. Progres Tambahan
    public function store_progres_knmp(Request $request)
    {
        $progres = ProgresKnmp::create([
            'knmp_id'  => $request->knmp_id ?? null,

            'anggaran_total'      => $request->anggaran_total,
            'anggaran_konstruksi' => $request->anggaran_konstruksi,
            'anggaran_sarpras'    => $request->anggaran_sarpras,

            'tk_total'  => $request->tk_total,
            'tk_laki'   => $request->tk_laki,
            'tk_perempuan' => $request->tk_perempuan,
            'tk_upah'   => $request->tk_upah,
            'tk_durasi' => $request->tk_durasi,
            'tk_lokal'  => $request->tk_lokal,
            'tk_luar'   => $request->tk_luar,

            'tk_non_konstruksi_jumlah' => $request->tk_non_konstruksi_jumlah,
            'tk_non_konstruksi_ket'    => $request->tk_non_konstruksi_ket,

            'kendala' => $request->kendala ?? [],
            'cctv'    => $request->cctv,
        ]);

        // 2. Simpan detail komponen
        if ($request->progress) {
            foreach ($request->progress as $kode => $items) {
                foreach ($items as $index => $row) {
                    ProgresKnmpDetail::create([
                        'progres_id' => $progres->id,
                        'kode'       => $kode,
                        'komponen'   => $row['komponen'] ?? null,
                        'target'     => $row['target'] ?? null,
                        'persen'     => $row['persen'] ?? null,
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Data progres KNMP berhasil disimpan.');
    }

    // C. Tanggapan Masyarakat
    public function store_tanggapan_masyarakat(Request $request, $knmpId)
    {
        try {
            $validated = $request->validate([
                'knmp_id'              => 'required|integer|min:1',
                'kesesuaian_kebutuhan' => 'required',
                'item_tidak_sesuai' => 'nullable|string',
                'tingkat_kesenangan' => 'required|string',
                'alasan_tidak_senang' => 'nullable|string',
                'harapan_masyarakat' => 'nullable|string',
                'masukan_saran_perbaikan' => 'nullable|string',
            ]);

            $validated['kesesuaian_kebutuhan'] =
                ($request->kesesuaian_kebutuhan == 'Ya' || $request->kesesuaian_kebutuhan == 1) ? 1 : 0;

            if ($validated['kesesuaian_kebutuhan'] == 1) {
                $validated['item_tidak_sesuai'] = null;
            }

            if ($request->tingkat_kesenangan != 'Tidak Senang') {
                $validated['alasan_tidak_senang'] = null;
            }

            $validated['knmp_id'] = $knmpId;

            TanggapanMasyarakat::create($validated);

            return back()->with('success', 'Data tanggapan berhasil disimpan.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    // D. Tingkat Kebahagiaan Nelayan
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

    // E. Informasi Responden
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

    // F. Informasi Usaha Perikanan
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

    // G. Informasi Pemasaran Perikanan
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

    // H. Informasi Pendapatan Rumah Tangga
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

    // I. Sosial & Kelembagaan
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

    // J. Upload Bukti File
    public function store_bukti_upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        $path = $file->store('bukti', 'public');

        $upload = BuktiUpload::create([
            'knmp_id'    => $request->knmp_id ?? null,
            'nama_file'  => $file->getClientOriginalName(),
            'path_file'  => $path,
            'tipe_file'  => $file->getClientMimeType(),
            'ukuran_file' => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
            'file_id' => $upload->id,
            'path'    => $path
        ]);
    }
}
