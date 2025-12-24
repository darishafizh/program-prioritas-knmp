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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Knmp;
use Barryvdh\DomPDF\Facade\Pdf;

class FormsController extends Controller
{
    // Menampilkan form survey
    public function index($knmpId, Request $request)
    {
        $knmp = ModelsKnmp::with(['province', 'regency', 'district', 'village'])
            ->findOrFail($knmpId);

        // ✅ AMBIL SEMUA RESPONDEN BERDASARKAN KNMP
        $respondenList = InformasiResponden::where('knmp_id', $knmp->id)
            ->orderBy('nama_responden')
            ->get();

        $provinces = KnmpProvinces::where('id', $knmp->province_id)->get();
        $regencies = KnmpRegencies::where('id', $knmp->regency_id)->get();
        $districts = KnmpDistricts::where('id', $knmp->district_id)->get();
        $villages = KnmpVillages::where('id', $knmp->village_id)->get();

        // ✅ AMBIL BUKTI UPLOADS BERDASARKAN KNMP
        $buktiUploads = BuktiUpload::where('knmp_id', $knmp->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ AMBIL PROGRES KNMP BERDASARKAN KNMP
        $progresKnmp = ProgresKnmp::with('details')->where('knmp_id', $knmp->id)->first();
        
        // ✅ HITUNG RATA-RATA PROGRES DARI DETAIL
        $rataRataProgres = 0;
        if ($progresKnmp) {
            $detailProgres = ProgresKnmpDetail::where('progres_id', $progresKnmp->id)->get();
            if ($detailProgres->count() > 0) {
                $rataRataProgres = round($detailProgres->avg('persen') ?? 0, 1);
            }
        }

        // ✅ AMBIL DATA UNTUK EDIT (EXISTING DATA)
        $profileKnmp = ProfileKnmp::where('knmp_id', $knmp->id)->first();
        $tanggapanMasyarakat = TanggapanMasyarakat::where('knmp_id', $knmp->id)->first();

        // ✅ AMBIL RESPONDEN ID DARI QUERY STRING (DARI EDIT RESPONDEN PAGE)
        $selectedRespondenId = $request->query('responden');
        
        // ✅ JIKA ADA RESPONDEN YANG DIPILIH, AMBIL DATA RESPONDEN ITU
        $selectedResponden = null;
        $selectedRespondenData = [];
        if ($selectedRespondenId) {
            $selectedResponden = InformasiResponden::findOrFail($selectedRespondenId);
            
            // Ambil semua data responden dari berbagai tabel
            $selectedRespondenData = [
                'tingkat_kebahagiaan' => TingkatKebahagiaanNelayan::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'tanggapan_masyarakat' => TanggapanMasyarakat::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'informasi_responden' => InformasiResponden::where('id', $selectedRespondenId)->first(),
                'informasi_usaha' => InformasiUsaha::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'informasi_pemasaran' => InformasiPemasaran::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'pendapatan_rumah_tangga' => InformasiPendapatanRumahTangga::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'sosial_kelembagaan' => SosialKelembagaan::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
            ];
            
            // ✅ FLASH DATA KE SESSION AGAR old() HELPER BISA MENGAKSES
            $flashData = [];
            
            // Flash responden ID
            if ($selectedResponden) {
                $flashData['responden_id'] = $selectedResponden->id;
            }
            
            // Flash tanggapan masyarakat data
            if ($selectedRespondenData['tanggapan_masyarakat']) {
                $tm = $selectedRespondenData['tanggapan_masyarakat'];
                $flashData['kesesuaian_kebutuhan'] = $tm->kesesuaian_kebutuhan;
                $flashData['item_tidak_sesuai'] = $tm->item_tidak_sesuai;
                $flashData['tingkat_kesenangan'] = $tm->tingkat_kesenangan;
                $flashData['alasan_tidak_senang'] = $tm->alasan_tidak_senang;
                $flashData['harapan_masyarakat'] = $tm->harapan_masyarakat;
                $flashData['masukan_saran_perbaikan'] = $tm->masukan_saran_perbaikan;
            }
            
            // Flash tingkat kebahagiaan data
            if ($selectedRespondenData['tingkat_kebahagiaan']) {
                $tkn = $selectedRespondenData['tingkat_kebahagiaan'];
                // Flash semua field dinamis (soal_1_jawaban, soal_2_jawaban, etc)
                foreach (range(1, 36) as $i) {
                    $fieldName = 'soal_' . $i . '_jawaban';
                    if (property_exists($tkn, $fieldName)) {
                        $flashData[$fieldName] = $tkn->$fieldName;
                    }
                }
            }
            
            if (!empty($flashData)) {
                session()->flash('_old_input', $flashData);
            }
        }

        // ✅ KIRIM LIST RESPONDEN & BUKTI UPLOADS KE VIEW
        return view('survey.forms.index', compact(
            'knmp',
            'respondenList',
            'provinces',
            'regencies',
            'districts',
            'villages',
            'buktiUploads',
            'progresKnmp',
            'rataRataProgres',
            'profileKnmp',
            'tanggapanMasyarakat',
            'selectedRespondenId',
            'selectedResponden',
            'selectedRespondenData'
        ));
    }


    // ----------------------------
    // A. Profile KNMP (multi-entry versi baru)
    // ----------------------------
    public function store_profile_knmp(Request $request)
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

            // Ganti updateOrCreate menjadi create()
            ProfileKnmp::create($profilData);

            DB::commit();
            return back()->with('success', 'Profil KNMP berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // A. Profile KNMP - Update
    // ----------------------------
    public function update_profile_knmp(Request $request, Knmp $knmp)
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

    // ----------------------------
    // B. Progres KNMP (MODEL PROFIL KNMP)
    // ----------------------------
    public function store_progres_knmp(Request $request, Knmp $knmp)
    {
        // ===============================
        // VALIDASI (ERROR BAG KHUSUS)
        // ===============================
        $validated = $request->validate([

            'anggaran_total' => 'required|numeric|min:0',
            'anggaran_konstruksi' => 'required|numeric|min:0',
            'anggaran_sarpras' => 'required|numeric|min:0',

            'tk_laki' => 'required|integer|min:0',
            'tk_perempuan' => 'required|integer|min:0',
            'tk_upah' => 'required|numeric|min:0',
            'tk_durasi' => 'required|numeric|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            // TK NON KONSTRUKSI
            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            // DETAIL PROGRES
            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|numeric|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',

        ], [], [], 'progresKnmp'); // ⬅️ PENTING: error bag khusus

        DB::beginTransaction();

        try {
            // ===============================
            // HITUNG OTOMATIS (MODEL PROFIL)
            // ===============================
            $tkTotal = $validated['tk_laki'] + $validated['tk_perempuan'];

            // ===============================
            // INSERT HEADER PROGRES
            // ===============================
            $progres = ProgresKnmp::create([
                'knmp_id' => $knmp->id,

                'anggaran_total' => $validated['anggaran_total'],
                'anggaran_konstruksi' => $validated['anggaran_konstruksi'],
                'anggaran_sarpras' => $validated['anggaran_sarpras'],

                'tk_total' => $tkTotal,
                'tk_laki' => $validated['tk_laki'],
                'tk_perempuan' => $validated['tk_perempuan'],
                'tk_upah' => $validated['tk_upah'],
                'tk_durasi' => $validated['tk_durasi'],
                'tk_lokal' => $validated['tk_lokal'],
                'tk_luar' => $validated['tk_luar'],

                'tk_non_konstruksi_jumlah' => $validated['tk_non_konstruksi_jumlah'] ?? null,
                'tk_non_konstruksi_ket' => $validated['tk_non_konstruksi_ket'] ?? null,

                'kendala' => $request->kendala ?? null,
                'cctv' => $request->cctv ?? null,
            ]);

            // ===============================
            // INSERT DETAIL PROGRES
            // ===============================
            foreach ($validated['progress'] as $kode => $items) {
                foreach ($items as $row) {

                    // ⛔ SKIP BARIS BENAR-BENAR KOSONG
                    if (
                        empty($row['target']) &&
                        empty($row['persen']) &&
                        empty($row['keterangan'])
                    ) {
                        continue;
                    }

                    ProgresKnmpDetail::create([
                        'progres_id' => $progres->id,
                        'kode' => $kode,
                        'komponen' => $row['komponen'],
                        'target' => $row['target'],
                        'persen' => $row['persen'],
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres Pembangunan KNMP berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // B. Progres KNMP - Update
    // ----------------------------
    public function update_progres_knmp(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'anggaran_total' => 'required|numeric|min:0',
            'anggaran_konstruksi' => 'required|numeric|min:0',
            'anggaran_sarpras' => 'required|numeric|min:0',

            'tk_laki' => 'required|integer|min:0',
            'tk_perempuan' => 'required|integer|min:0',
            'tk_upah' => 'required|numeric|min:0',
            'tk_durasi' => 'required|numeric|min:0',
            'tk_lokal' => 'required|integer|min:0',
            'tk_luar' => 'required|integer|min:0',

            'tk_non_konstruksi_jumlah' => 'nullable|integer|min:0',
            'tk_non_konstruksi_ket' => 'nullable|string|max:255',

            'progress' => 'required|array',
            'progress.*.*.komponen' => 'required|string|max:255',
            'progress.*.*.target' => 'nullable|numeric|min:0',
            'progress.*.*.persen' => 'nullable|numeric|min:0|max:100',
            'progress.*.*.keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $progres = ProgresKnmp::where('knmp_id', $knmp->id)->first();
            
            if (!$progres) {
                return back()->with('error', 'Data Progres KNMP tidak ditemukan');
            }

            $tkTotal = $validated['tk_laki'] + $validated['tk_perempuan'];

            $progres->update([
                'anggaran_total' => $validated['anggaran_total'],
                'anggaran_konstruksi' => $validated['anggaran_konstruksi'],
                'anggaran_sarpras' => $validated['anggaran_sarpras'],

                'tk_total' => $tkTotal,
                'tk_laki' => $validated['tk_laki'],
                'tk_perempuan' => $validated['tk_perempuan'],
                'tk_upah' => $validated['tk_upah'],
                'tk_durasi' => $validated['tk_durasi'],
                'tk_lokal' => $validated['tk_lokal'],
                'tk_luar' => $validated['tk_luar'],

                'tk_non_konstruksi_jumlah' => $validated['tk_non_konstruksi_jumlah'] ?? null,
                'tk_non_konstruksi_ket' => $validated['tk_non_konstruksi_ket'] ?? null,

                'kendala' => $request->kendala ?? null,
                'cctv' => $request->cctv ?? null,
            ]);

            // Delete existing details
            ProgresKnmpDetail::where('progres_id', $progres->id)->delete();

            // Insert updated details
            foreach ($validated['progress'] as $kode => $items) {
                foreach ($items as $row) {

                    if (
                        empty($row['target']) &&
                        empty($row['persen']) &&
                        empty($row['keterangan'])
                    ) {
                        continue;
                    }

                    ProgresKnmpDetail::create([
                        'progres_id' => $progres->id,
                        'kode' => $kode,
                        'komponen' => $row['komponen'],
                        'target' => $row['target'],
                        'persen' => $row['persen'],
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Progres Pembangunan KNMP berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    // ----------------------------
    public function store_tanggapan_masyarakat(Request $request, Knmp $knmp)
    {
        // ===============================
        // VALIDASI
        // ===============================
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

        $validated = $request->validate($rules);

        // ===============================
        // SIMPAN DATA
        // ===============================
        DB::transaction(function () use ($validated, $knmp) {

            TanggapanMasyarakat::create([
                'knmp_id' => $knmp->id,
                'responden_id' => $validated['responden_id'],

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

        return back()->with('success', 'Tanggapan Masyarakat berhasil disimpan');
    }

    // C. Tanggapan Masyarakat - Update
    // ----------------------------
    public function update_tanggapan_masyarakat(Request $request, Knmp $knmp)
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

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $knmp, $request) {
            $tanggapan = TanggapanMasyarakat::where('knmp_id', $knmp->id)
                ->where('responden_id', $validated['responden_id'])
                ->first();

            if (!$tanggapan) {
                return back()->with('error', 'Data Tanggapan tidak ditemukan');
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
    }

    // ----------------------------
    // D. Tingkat Kebahagiaan Nelayan (multi-entry)
    // ----------------------------
    public function store_tingkat_kebahagiaan(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
        ]);

        $knmp_id = (int) $request->knmp_id;
        $responden_id = (int) $request->responden_id;

        $skorMap = [
            'Sangat Tidak Setuju' => 1,
            'Tidak Setuju' => 2,
            'Netral' => 3,
            'Setuju' => 4,
            'Sangat Setuju' => 5,
        ];

        DB::beginTransaction();

        try {
            foreach ($request->all() as $key => $value) {

                // hanya radio soal
                if (
                    !preg_match(
                        '/^(kepuasan_hidup_personal|kepuasan_hidup_sosial|perasaan|makna_hidup)_(\d+)$/',
                        $key,
                        $m
                    )
                ) {
                    continue;
                }

                // validasi jawaban
                if (!isset($skorMap[$value])) {
                    continue;
                }

                TingkatKebahagiaanNelayan::create([
                    'knmp_id' => $knmp_id,
                    'responden_id' => $responden_id,
                    'nomor_soal' => (int) $m[2],
                    'kategori' => $m[1],
                    'jawaban_teks' => $value,
                    'skor_nilai' => $skorMap[$value],
                ]);
            }

            DB::commit();

            return back()->with(
                'success',
                'Tingkat Kebahagiaan Nelayan berhasil disimpan.'
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->withInput()->with(
                'error',
                'Gagal menyimpan data: ' . $e->getMessage()
            );
        }
    }


    // ----------------------------
    // E. Informasi Responden (multi-entry)
    // ----------------------------
    public function store_informasi_responden(Request $request, $knmpId)
    {
        $validated = $request->validate([
            'nama_responden' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'nomor_kusuka' => 'required|string|max:30',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'suku_bangsa' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'wpp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp_responden' => 'required|string|max:20',
            'jumlah_anggota_rumah' => 'required|integer|min:0',
            'jumlah_anggota_perempuan_rumah' => 'required|integer|min:0',
            'jumlah_anggota_bekerja' => 'required|integer|min:0',
            'jumlah_anggota_perempuan_bekerja' => 'required|integer|min:0',
            'jumlah_abk' => 'required|integer|min:0',
            'pengalaman_usaha' => 'required|integer|min:0',
            'province_id' => 'required|integer',
            'regency_id' => 'required|integer',
            'district_id' => 'required|integer',
            'village_id' => 'required|integer',
            'tanggal_wawancara' => 'required|date',
            'nama_enumerator' => 'required|string|max:255',
            'jenis_kelamin_enumerator' => 'required|in:Laki-laki,Perempuan',
            'no_hp_enumerator' => 'required|string|max:20',
        ]);

        $validated['knmp_id'] = $knmpId;

        DB::beginTransaction();
        try {
            InformasiResponden::create($validated);
            DB::commit();
            return back()->with('success', 'Informasi Responden berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ----------------------------
    // F. Informasi Usaha & Ikan (multi-entry, per responden)
    // ----------------------------
    public function store_informasi_usaha(Request $request)
    {
        // ===============================
        // VALIDASI
        // ===============================
        $validator = Validator::make($request->all(), [
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',

            'nama_kapal' => 'required|string',
            'tahun_pembuatan' => 'required|numeric',
            'jenis_alat_tangkap' => 'required|string',

            'ikan_utama' => 'required|array|min:1',
            'ikan_utama.*.jenis' => 'required|string',
            'ikan_utama.*.kg_trip' => 'required|numeric',
            'ikan_utama.*.persen' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // ===============================
            // INSERT INFORMASI USAHA (SELALU BARU)
            // ===============================
            $usaha = InformasiUsaha::create([
                'knmp_id' => $request->knmp_id,
                'responden_id' => $request->responden_id,

                'nama_kapal' => $request->nama_kapal,
                'tahun_pembuatan' => $request->tahun_pembuatan,
                'ukuran_gt' => $request->ukuran_gt,
                'dimensi_perahu' => $request->dimensi_perahu,
                'jenis_bahan_baku' => $request->jenis_bahan_baku,
                'jenis_mesin' => $request->jenis_mesin,
                'alat_penyimpanan' => $request->alat_penyimpanan,
                'jenis_alat_tangkap' => $request->jenis_alat_tangkap,

                'hari_per_trip' => $request->hari_per_trip,
                'waktu_melaut_jam' => $request->waktu_melaut_jam,
                'jarak_penangkapan_mil' => $request->jarak_penangkapan_mil,
                'waktu_tempuh_jam' => $request->waktu_tempuh_jam,
                'jml_trip_per_bulan' => $request->jml_trip_per_bulan,
                'jml_bulan_melaut' => $request->jml_bulan_melaut,
                'produksi_kg_per_trip' => $request->produksi_kg_per_trip,
                'penjualan_rp_per_trip' => $request->penjualan_rp_per_trip,
                'biaya_solar_rp' => $request->biaya_solar_rp,
                'volume_solar_liter' => $request->volume_solar_liter,
                'biaya_bensin_rp' => $request->biaya_bensin_rp,
                'volume_bensin_liter' => $request->volume_bensin_liter,
                'biaya_es_balok_rp' => $request->biaya_es_balok_rp,
                'volume_es_balok' => $request->volume_es_balok,
                'biaya_es_kantong_rp' => $request->biaya_es_kantong_rp,
                'volume_es_kantong' => $request->volume_es_kantong,
                'total_biaya_operasional' => $request->total_biaya_operasional,
            ]);

            // ===============================
            // INSERT IKAN (DETAIL)
            // ===============================
            foreach ($request->ikan_utama as $row) {
                InformasiUsahaIkan::create([
                    'informasi_usaha_id' => $usaha->id,
                    'responden_id' => $request->responden_id,
                    'jenis' => $row['jenis'],
                    'kg_trip' => $row['kg_trip'],
                    'persen' => $row['persen'],
                ]);
            }

            DB::commit();

            return back()->with('success', 'Informasi Usaha berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // ----------------------------
    // G. Informasi Pemasaran Perikanan (multi-entry)
    // ----------------------------
    public function store_pemasaran_perikanan(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
            'kendala_pemasaran' => 'required|string',
            'cara_penanganan_ikan' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            // 1️⃣ INSERT BARU (TIDAK ADA UPDATE)
            $pemasaran = InformasiPemasaran::create([
                'knmp_id' => $request->knmp_id,
                'responden_id' => $request->responden_id,
                'kendala_pemasaran_text' => $request->kendala_pemasaran,
                'cara_penanganan_ikan' => $request->cara_penanganan_ikan,
            ]);

            // 2️⃣ DETAIL IKAN
            DetailPemasaranIkan::create([
                'pemasaran_id' => $pemasaran->id,
                'responden_id' => $request->responden_id,
                'eceran_kg' => $request->pemasaran_eceran_kg ?? 0,
                'koperasi_kg' => $request->pemasaran_koperasi_kg ?? 0,
                'tengkulak_kg' => $request->pemasaran_tengkulak_kg ?? 0,
                'pengepul_kg' => $request->pemasaran_pengepul_kg ?? 0,
                'pedagang_besar_kg' => $request->pemasaran_pedagang_besar_kg ?? 0,
                'lainnya_kg' => $request->pemasaran_lainnya_kg ?? 0,
                'lainnya_keterangan' => $request->pemasaran_lainnya_ket,
            ]);

            DB::commit();
            return back()->with('success', 'Informasi Pemasaran berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    // ----------------------------
    // H. Informasi Pendapatan Rumah Tangga (1 baris per KNMP)
    // ----------------------------
    public function store_pendapatan_rt(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',

            'pendapatan_perikanan' => 'required|numeric|min:0',
            'pendapatan_non_perikanan' => 'nullable|numeric|min:0',
            'pendapatan_total' => 'required|numeric|min:0',

            'kontribusi_nelayan_persen' => 'required|string',
            'jumlah_sumber_penghasilan' => 'required|string',
            'ketergantungan_perikanan' => 'required|string',
            'stabilitas_pendapatan' => 'required|string',
            'keterlibatan_perempuan' => 'required|string',
            'kontribusi_perempuan_persen' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            InformasiPendapatanRumahTangga::create([
                'knmp_id' => $request->knmp_id,
                'responden_id' => $request->responden_id,

                'pendapatan_perikanan' => $request->pendapatan_perikanan,
                'pendapatan_non_perikanan' => $request->pendapatan_non_perikanan ?? 0,
                'pendapatan_total' => $request->pendapatan_total,

                'kontribusi_nelayan_persen' => $request->kontribusi_nelayan_persen,
                'jumlah_sumber_penghasilan' => $request->jumlah_sumber_penghasilan,
                'ketergantungan_perikanan' => $request->ketergantungan_perikanan,
                'stabilitas_pendapatan' => $request->stabilitas_pendapatan,
                'keterlibatan_perempuan' => $request->keterlibatan_perempuan,
                'kontribusi_perempuan_persen' => $request->kontribusi_perempuan_persen,
            ]);

            DB::commit();
            return back()->with('success', 'Pendapatan Rumah Tangga berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function store_sosial_kelembagaan(Request $request, $knmp)
    {
        // VALIDASI RINGAN (TIDAK MENIMPA, TIDAK MEMAKSA)
        if (!$request->responden_id) {
            return back()->with('error', 'Responden wajib dipilih');
        }

        SosialKelembagaan::create([
            'knmp_id' => $knmp,
            'responden_id' => $request->responden_id,

            'anggota_kelompok' => $request->anggota_kelompok ?? null,
            'manfaat_kelompok' => $request->manfaat_kelompok ?? null,
            'anggota_koperasi' => $request->anggota_koperasi ?? null,
            'tertarik_koperasi' => $request->tertarik_koperasi ?? null,
            'manfaat_koperasi' => $request->manfaat_koperasi ?? null,

            'koperasi_rapat_tahunan' => $request->koperasi_rapat_tahunan ?? null,
            'koperasi_partisipasi_aktif' => $request->koperasi_partisipasi_aktif ?? null,
            'koperasi_pengurus_kompeten' => $request->koperasi_pengurus_kompeten ?? null,
            'koperasi_transparan' => $request->koperasi_transparan ?? null,
            'koperasi_keuangan_sehat' => $request->koperasi_keuangan_sehat ?? null,
            'koperasi_jaringan_pasar' => $request->koperasi_jaringan_pasar ?? null,
            'koperasi_kepercayaan_usaha' => $request->koperasi_kepercayaan_usaha ?? null,
        ]);

        return back()->with('success', 'Data Sosial & Kelembagaan berhasil disimpan');
    }


    // ======================================
    // UPLOAD BUKTI FILE
    // ======================================
    public function store_bukti_upload(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'file'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $file = $request->file('file');

        $path = $file->store('bukti_uploads', 'public');

        BuktiUpload::create([
            'knmp_id'     => $request->knmp_id,
            'nama_file'   => $file->getClientOriginalName(),
            'path_file'   => $path,
            'tipe_file'   => $file->getClientMimeType(),
            'ukuran_file' => $file->getSize(),
        ]);

        return back()->with('success', 'File berhasil diupload');
    }

    public function delete_bukti_upload(Request $request)
    {
        $request->validate([
            'file_ids'   => 'required|array',
            'file_ids.*' => 'integer|exists:bukti_uploads,id',
        ]);

        DB::transaction(function () use ($request) {
            $files = BuktiUpload::whereIn('id', $request->file_ids)->get();

            foreach ($files as $file) {
                Storage::disk('public')->delete($file->path_file);
                $file->delete();
            }
        });

        return back()->with('success', 'File berhasil dihapus');
    }

    public function delete_bukti_single($id)
    {
        $file = BuktiUpload::findOrFail($id);

        DB::transaction(function () use ($file) {
            Storage::disk('public')->delete($file->path_file);
            $file->delete();
        });

        return back()->with('success', 'File berhasil dihapus');
    }

    public function evidence(Knmp $knmp)
    {
        $buktiUploads = BuktiUpload::where('knmp_id', $knmp->id)
            ->latest()
            ->get();    return view(
        'survey.forms.form_layouts.evidence',
        compact('knmp', 'buktiUploads')
    );
    }

    // ======================================
    // GENERATE PDF LIST KUESIONER RESPONDEN
    // ======================================
    public function generateRespondenQuestionnairesPdf(Knmp $knmp, InformasiResponden $responden)
    {
        // Validasi responden milik KNMP
        if ($responden->knmp_id != $knmp->id) {
            abort(404);
        }

        // Data pertanyaan Tingkat Kebahagiaan
        $tingkatKebahagiaan_pertanyaan = [
            'kepuasan_hidup_personal' => [
                1 => 'Saya puas dengan kondisi hidup saya saat ini',
                2 => 'Saya merasa hidup saya bermakna dan berharga',
                3 => 'Saya merasa bahagia dengan pencapaian saya',
                4 => 'Saya puas dengan hubungan keluarga saya',
            ],
            'kepuasan_hidup_sosial' => [
                1 => 'Saya memiliki hubungan yang baik dengan tetangga',
                2 => 'Saya merasa diterima di masyarakat',
                3 => 'Saya aktif dalam kegiatan sosial masyarakat',
                4 => 'Saya puas dengan dukungan sosial dari komunitas',
            ],
            'perasaan' => [
                1 => 'Saya merasa optimis tentang masa depan',
                2 => 'Saya jarang mengalami stres dalam kehidupan sehari-hari',
                3 => 'Saya merasa sehat secara fisik dan mental',
                4 => 'Saya merasa aman dan terlindungi',
            ],
            'makna_hidup' => [
                1 => 'Pekerjaan saya memberikan makna hidup',
                2 => 'Saya memiliki tujuan hidup yang jelas',
                3 => 'Saya merasa kontribusi saya berarti bagi keluarga dan masyarakat',
                4 => 'Saya merasa kehidupan nelayan ini layak untuk diteruskan',
            ],
        ];

        // 1. PROSES PEMBANGUNAN KNMP (PROFIL KNMP + PROGRES)
        $profileKnmp = ProfileKnmp::where('knmp_id', $knmp->id)->first();
        
        $progresKnmp = ProgresKnmp::where('knmp_id', $knmp->id)
            ->with('details')
            ->get();

        // 2. TANGGAPAN MASYARAKAT
        $tanggapanMasyarakat = TanggapanMasyarakat::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 3. TINGKAT KEBAHAGIAAN NELAYAN
        $tingkatKebahagiaan = TingkatKebahagiaanNelayan::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->get()
            ->groupBy('kategori');

        // 4. INFORMASI USAHA (EXISTING)
        $informasiUsaha = InformasiUsaha::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->with('ikan')
            ->get();

        // 5. INFORMASI PEMASARAN
        $informasiPemasaran = InformasiPemasaran::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->with('detail_pemasaran')
            ->first();

        // 6. PENDAPATAN RUMAH TANGGA
        $pendapatanRt = InformasiPendapatanRumahTangga::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 7. SOSIAL & KELEMBAGAAN
        $sosialKelembagaan = SosialKelembagaan::where('knmp_id', $knmp->id)
            ->where('responden_id', $responden->id)
            ->first();

        // 8. BUKTI PENDUKUNG
        $buktiPendukung = BuktiUpload::where('knmp_id', $knmp->id)
            ->get();

        $html = view('survey.pdf.questionnaire-responden', [
            'knmp' => $knmp,
            'responden' => $responden,
            'profileKnmp' => $profileKnmp,
            'progresKnmp' => $progresKnmp,
            'tanggapanMasyarakat' => $tanggapanMasyarakat,
            'tingkatKebahagiaan' => $tingkatKebahagiaan,
            'tingkatKebahagiaan_pertanyaan' => $tingkatKebahagiaan_pertanyaan,
            'informasiUsaha' => $informasiUsaha,
            'informasiPemasaran' => $informasiPemasaran,
            'pendapatanRt' => $pendapatanRt,
            'sosialKelembagaan' => $sosialKelembagaan,
            'buktiPendukung' => $buktiPendukung,
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Kuesioner_' . str_replace(' ', '_', $responden->nama_responden) . '_' . date('d-m-Y_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function questionnairesListPdf(Knmp $knmp)
    {
        // Ambil semua responden dengan data yang relevan
        $responden = InformasiResponden::where('knmp_id', $knmp->id)
            ->with(['knmp'])
            ->orderBy('tanggal_wawancara', 'desc')
            ->get()
            ->map(function ($item) use ($knmp) {
                // Cek apakah responden ini sudah mengisi kuesioner
                $totalRecords = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->count();

                // Ambil tanggal terakhir pengisian
                $lastUpdated = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->latest('updated_at')
                    ->first();

                return [
                    'id' => $item->id,
                    'nama_responden' => $item->nama_responden,
                    'nik' => $item->nik,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tanggal_wawancara' => $item->tanggal_wawancara,
                    'nama_enumerator' => $item->nama_enumerator,
                    'total_answers' => $totalRecords,
                    'last_updated' => $lastUpdated ? $lastUpdated->updated_at : null,
                    'is_complete' => $totalRecords > 0,
                ];
            });

        return view('survey.questionnaires-list-pdf', compact('knmp', 'responden'));
    }

    // =============================
    // EDIT RESPONDEN LIST
    // =============================
    public function editRespondenList(Knmp $knmp)
    {
        // Ambil semua responden dengan data yang relevan
        $responden = InformasiResponden::where('knmp_id', $knmp->id)
            ->with(['knmp'])
            ->orderBy('tanggal_wawancara', 'desc')
            ->get()
            ->map(function ($item) use ($knmp) {
                // Cek apakah responden ini sudah mengisi data
                $totalRecords = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->count();

                // Ambil tanggal terakhir pengisian
                $lastUpdated = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->latest('updated_at')
                    ->first();

                return [
                    'id' => $item->id,
                    'nama_responden' => $item->nama_responden,
                    'nik' => $item->nik,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tanggal_wawancara' => $item->tanggal_wawancara,
                    'nama_enumerator' => $item->nama_enumerator,
                    'total_answers' => $totalRecords,
                    'last_updated' => $lastUpdated ? $lastUpdated->updated_at : null,
                    'is_complete' => $totalRecords > 0,
                ];
            });

        return view('survey.forms.edit-responden', compact('knmp', 'responden'));
    }
}
