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
                    ->where('responden_id', $selectedRespondenId)->get(),
                'tanggapan_masyarakat' => TanggapanMasyarakat::where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'informasi_responden' => InformasiResponden::where('id', $selectedRespondenId)->first(),
                'informasi_usaha' => InformasiUsaha::with('ikan')->where('knmp_id', $knmp->id)
                    ->where('responden_id', $selectedRespondenId)->first(),
                'informasi_pemasaran' => InformasiPemasaran::with('detail_pemasaran')->where('knmp_id', $knmp->id)
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
                $flashData['responden_id_select'] = $selectedResponden->id;
            }

            // Flash informasi responden data
            if ($selectedRespondenData['informasi_responden']) {
                $ir = $selectedRespondenData['informasi_responden'];
                $flashData['nama_responden'] = $ir->nama_responden;
                $flashData['nik'] = $ir->nik;
                $flashData['nomor_kusuka'] = $ir->nomor_kusuka;
                $flashData['tempat_lahir'] = $ir->tempat_lahir;
                $flashData['tanggal_lahir'] = $ir->tanggal_lahir;
                $flashData['umur'] = $ir->umur;
                $flashData['jenis_kelamin'] = $ir->jenis_kelamin;
                $flashData['suku_bangsa'] = $ir->suku_bangsa;
                $flashData['pendidikan_terakhir'] = $ir->pendidikan_terakhir;
                $flashData['wpp'] = $ir->wpp;
                $flashData['alamat'] = $ir->alamat;
                $flashData['no_hp_responden'] = $ir->no_hp_responden;
                $flashData['jumlah_anggota_rumah'] = $ir->jumlah_anggota_rumah;
                $flashData['jumlah_anggota_perempuan_rumah'] = $ir->jumlah_anggota_perempuan_rumah;
                $flashData['jumlah_anggota_bekerja'] = $ir->jumlah_anggota_bekerja;
                $flashData['jumlah_anggota_perempuan_bekerja'] = $ir->jumlah_anggota_perempuan_bekerja;
                $flashData['jumlah_abk'] = $ir->jumlah_abk;
                $flashData['pengalaman_usaha'] = $ir->pengalaman_usaha;
                $flashData['tanggal_wawancara'] = $ir->tanggal_wawancara;
                $flashData['nama_enumerator'] = $ir->nama_enumerator;
                $flashData['jenis_kelamin_enumerator'] = $ir->jenis_kelamin_enumerator;
                $flashData['no_hp_enumerator'] = $ir->no_hp_enumerator;
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
            if ($selectedRespondenData['tingkat_kebahagiaan'] && $selectedRespondenData['tingkat_kebahagiaan']->count() > 0) {
                foreach ($selectedRespondenData['tingkat_kebahagiaan'] as $tkn) {
                    // Field name in view is {kategori}_{nomor_soal} e.g., kepuasan_hidup_personal_1
                    $fieldName = $tkn->kategori . '_' . $tkn->nomor_soal;
                    $flashData[$fieldName] = $tkn->jawaban_teks;
                }
            }

            // Flash informasi usaha data
            if ($selectedRespondenData['informasi_usaha']) {
                $iu = $selectedRespondenData['informasi_usaha'];
                $flashData['nama_kapal'] = $iu->nama_kapal;
                $flashData['tahun_pembuatan'] = $iu->tahun_pembuatan;
                $flashData['ukuran_gt'] = $iu->ukuran_gt;
                $flashData['dimensi_perahu'] = $iu->dimensi_perahu;
                $flashData['jenis_bahan_baku'] = $iu->jenis_bahan_baku;
                $flashData['jenis_mesin'] = $iu->jenis_mesin;
                $flashData['alat_penyimpanan'] = $iu->alat_penyimpanan;
                $flashData['jenis_alat_tangkap'] = $iu->jenis_alat_tangkap;
                $flashData['hari_per_trip'] = $iu->hari_per_trip;
                $flashData['waktu_melaut_jam'] = $iu->waktu_melaut_jam;
                $flashData['jarak_penangkapan_mil'] = $iu->jarak_penangkapan_mil;
                $flashData['waktu_tempuh_jam'] = $iu->waktu_tempuh_jam;
                $flashData['jml_trip_per_bulan'] = $iu->jml_trip_per_bulan;
                $flashData['jml_bulan_melaut'] = $iu->jml_bulan_melaut;
                $flashData['produksi_kg_per_trip'] = $iu->produksi_kg_per_trip;
                $flashData['penjualan_rp_per_trip'] = $iu->penjualan_rp_per_trip;
                $flashData['biaya_solar_rp'] = $iu->biaya_solar_rp;
                $flashData['volume_solar_liter'] = $iu->volume_solar_liter;
                $flashData['biaya_bensin_rp'] = $iu->biaya_bensin_rp;
                $flashData['volume_bensin_liter'] = $iu->volume_bensin_liter;
                $flashData['biaya_es_balok_rp'] = $iu->biaya_es_balok_rp;
                $flashData['volume_es_balok'] = $iu->volume_es_balok;
                $flashData['biaya_es_kantong_rp'] = $iu->biaya_es_kantong_rp;
                $flashData['volume_es_kantong'] = $iu->volume_es_kantong;
                $flashData['total_biaya_operasional'] = $iu->total_biaya_operasional;

                // Flash data ikan utama
                if ($iu->ikan) {
                    foreach ($iu->ikan as $index => $ikan) {
                        $no = $index + 1;
                        $flashData["ikan_utama.{$no}.jenis"] = $ikan->jenis;
                        $flashData["ikan_utama.{$no}.kg_trip"] = $ikan->kg_trip;
                        $flashData["ikan_utama.{$no}.persen"] = $ikan->persen;
                    }
                }
            }

            // Flash informasi pemasaran data
            if ($selectedRespondenData['informasi_pemasaran']) {
                $ip = $selectedRespondenData['informasi_pemasaran'];
                $flashData['kendala_pemasaran'] = $ip->kendala_pemasaran_text ?? null;
                $flashData['cara_penanganan_ikan'] = $ip->cara_penanganan_ikan ?? null;

                // Flash detail pemasaran kg
                if ($ip->detail_pemasaran) {
                    $dp = $ip->detail_pemasaran;
                    $flashData['pemasaran_eceran_kg'] = $dp->eceran_kg ?? null;
                    $flashData['pemasaran_koperasi_kg'] = $dp->koperasi_kg ?? null;
                    $flashData['pemasaran_tengkulak_kg'] = $dp->tengkulak_kg ?? null;
                    $flashData['pemasaran_pengepul_kg'] = $dp->pengepul_kg ?? null;
                    $flashData['pemasaran_pedagang_besar_kg'] = $dp->pedagang_besar_kg ?? null;
                    $flashData['pemasaran_lainnya_kg'] = $dp->lainnya_kg ?? null;
                    $flashData['pemasaran_lainnya_ket'] = $dp->lainnya_keterangan ?? null;
                }
            }

            // Flash pendapatan rumah tangga data
            if ($selectedRespondenData['pendapatan_rumah_tangga']) {
                $prt = $selectedRespondenData['pendapatan_rumah_tangga'];
                $flashData['pendapatan_perikanan'] = $prt->pendapatan_perikanan ?? null;
                $flashData['pendapatan_non_perikanan'] = $prt->pendapatan_non_perikanan ?? null;
                $flashData['pendapatan_total'] = $prt->pendapatan_total ?? null;
                $flashData['kontribusi_nelayan_persen'] = $prt->kontribusi_nelayan_persen ?? null;
                $flashData['jumlah_sumber_penghasilan'] = $prt->jumlah_sumber_penghasilan ?? null;
                $flashData['ketergantungan_perikanan'] = $prt->ketergantungan_perikanan ?? null;
                $flashData['stabilitas_pendapatan'] = $prt->stabilitas_pendapatan ?? null;
                $flashData['keterlibatan_perempuan'] = $prt->keterlibatan_perempuan ?? null;
                $flashData['kontribusi_perempuan_persen'] = $prt->kontribusi_perempuan_persen ?? null;
            }

            // Flash sosial kelembagaan data
            if ($selectedRespondenData['sosial_kelembagaan']) {
                $sk = $selectedRespondenData['sosial_kelembagaan'];
                $flashData['anggota_kelompok'] = $sk->anggota_kelompok ?? null;
                $flashData['manfaat_kelompok'] = $sk->manfaat_kelompok ?? null;
                $flashData['anggota_koperasi'] = $sk->anggota_koperasi ?? null;
                $flashData['tertarik_koperasi'] = $sk->tertarik_koperasi ?? null;
                $flashData['manfaat_koperasi'] = $sk->manfaat_koperasi ?? null;
                $flashData['koperasi_rapat_tahunan'] = $sk->koperasi_rapat_tahunan ?? null;
                $flashData['koperasi_partisipasi_aktif'] = $sk->koperasi_partisipasi_aktif ?? null;
                $flashData['koperasi_pengurus_kompeten'] = $sk->koperasi_pengurus_kompeten ?? null;
                $flashData['koperasi_transparan'] = $sk->koperasi_transparan ?? null;
                $flashData['koperasi_keuangan_sehat'] = $sk->koperasi_keuangan_sehat ?? null;
                $flashData['koperasi_jaringan_pasar'] = $sk->koperasi_jaringan_pasar ?? null;
                $flashData['koperasi_kepercayaan_usaha'] = $sk->koperasi_kepercayaan_usaha ?? null;
            }

            if (!empty($flashData)) {
                session()->flash('_old_input', $flashData);
            }
        }

        // ✅ HITUNG DATA UNTUK BADGE SETIAP SECTION
        $sectionCounts = [
            'A' => ProfileKnmp::where('knmp_id', $knmp->id)->count(), // Profil KNMP (1 per KNMP)
            'B' => ProgresKnmp::where('knmp_id', $knmp->id)->count(), // Progres KNMP (1 per KNMP)
            'C' => InformasiResponden::where('knmp_id', $knmp->id)->count(), // Informasi Responden (banyak)
            'D' => TanggapanMasyarakat::where('knmp_id', $knmp->id)->count(), // Tanggapan Masyarakat (per responden)
            'E' => TingkatKebahagiaanNelayan::where('knmp_id', $knmp->id)->distinct('responden_id')->count('responden_id'), // Tingkat Kebahagiaan (per responden)
            'F' => InformasiUsaha::where('knmp_id', $knmp->id)->count(), // Informasi Usaha (per responden)
            'G' => InformasiPemasaran::where('knmp_id', $knmp->id)->count(), // Pemasaran (per responden)
            'H' => InformasiPendapatanRumahTangga::where('knmp_id', $knmp->id)->count(), // Pendapatan RT (per responden)
            'I' => SosialKelembagaan::where('knmp_id', $knmp->id)->count(), // Sosial Kelembagaan (per responden)
            'J' => BuktiUpload::where('knmp_id', $knmp->id)->count(), // Bukti Upload (banyak per KNMP)
        ];

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
            'selectedRespondenData',
            'sectionCounts'
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
        // 1. Definisikan Rule Validasi Dasar
        $rules = [
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
        ];

        // 2. Definisikan Kategori dan Nomor Soal
        $categories = [
            'kepuasan_hidup_personal' => range(1, 8),   // Soal 1-8
            'kepuasan_hidup_sosial' => range(9, 18),  // Soal 9-18
            'perasaan' => range(19, 24), // Soal 19-24
            'makna_hidup' => range(25, 36), // Soal 25-36
        ];

        // 3. Tambahkan Rule Validasi untuk Setiap Soal
        foreach ($categories as $prefix => $numbers) {
            foreach ($numbers as $num) {
                // Pastikan setiap soal wajib diisi
                $rules["{$prefix}_{$num}"] = 'required|string';
            }
        }

        // 4. Jalankan Validasi
        // Gunakan custom attributes agar pesan error lebih mudah dibaca
        $customAttributes = [];
        foreach ($categories as $prefix => $numbers) {
            foreach ($numbers as $num) {
                $customAttributes["{$prefix}_{$num}"] = "Soal No. {$num}";
            }
        }

        $request->validate($rules, [], $customAttributes);

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
        // Validator
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

        SosialKelembagaan::create([
            'knmp_id' => $knmp,
            'responden_id' => $validated['responden_id'],

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
        ]);

        return back()->with('success', 'Data Sosial & Kelembagaan berhasil disimpan');
    }




    // ======================================
    // GENERATE PDF LIST KUESIONER RESPONDEN
    // ======================================

}
