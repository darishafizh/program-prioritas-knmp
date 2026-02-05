<?php

namespace App\Http\Controllers;

use App\Models\BuktiUpload;
use App\Models\InformasiPemasaran;
use App\Models\InformasiPendapatanRumahTangga;
use App\Models\InformasiResponden;
use App\Models\InformasiUsaha;
use App\Models\Knmp as ModelsKnmp;
use App\Models\KnmpDistricts;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpVillages;
use App\Models\ProfileKnmp;
use App\Models\ProgresKnmp;
use App\Models\ProgresKnmpDetail;
use App\Models\SosialKelembagaan;
use App\Models\TanggapanMasyarakat;
use App\Models\TingkatKebahagiaanNelayan;
use Illuminate\Http\Request;
use App\Models\Knmp;

class FormsController extends Controller
{
    /**
     * Display the survey form
     */
    public function index($knmpId, Request $request)
    {
        $knmp = ModelsKnmp::with(['province', 'regency', 'district', 'village'])
            ->findOrFail($knmpId);

        // Get all respondents for this KNMP
        $respondenList = InformasiResponden::where('knmp_id', $knmp->id)
            ->orderBy('id', 'asc')
            ->get();

        $provinces = KnmpProvinces::where('id', $knmp->province_id)->get();
        $regencies = KnmpRegencies::where('id', $knmp->regency_id)->get();
        $districts = KnmpDistricts::where('id', $knmp->district_id)->get();
        $villages = KnmpVillages::where('id', $knmp->village_id)->get();

        // Get evidence uploads for this KNMP
        $buktiUploads = BuktiUpload::where('knmp_id', $knmp->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get progress KNMP
        $progresKnmp = ProgresKnmp::with('details')->where('knmp_id', $knmp->id)->first();

        // Calculate average progress
        $rataRataProgres = 0;
        if ($progresKnmp) {
            $detailProgres = ProgresKnmpDetail::where('progres_id', $progresKnmp->id)->get();
            if ($detailProgres->count() > 0) {
                $rataRataProgres = round($detailProgres->avg('persen') ?? 0, 1);
            }
        }

        // Get existing data for edit
        $profileKnmp = ProfileKnmp::where('knmp_id', $knmp->id)->first();
        $tanggapanMasyarakat = TanggapanMasyarakat::where('knmp_id', $knmp->id)->first();

        // Get selected responden ID from query string
        $selectedRespondenId = $request->query('responden');

        // If responden is selected, get their data
        $selectedResponden = null;
        $selectedRespondenData = [];
        if ($selectedRespondenId) {
            $selectedResponden = InformasiResponden::findOrFail($selectedRespondenId);

            // Get all respondent data from various tables
            $selectedRespondenData = $this->getRespondentData($knmp->id, $selectedRespondenId);

            // Flash data to session for old() helper
            $this->flashRespondentToSession($selectedResponden, $selectedRespondenData);
        }

        // Calculate section counts for badges
        $sectionCounts = $this->getSectionCounts($knmp->id);

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

    private function getRespondentData($knmpId, $respondentId)
    {
        return [
            'tingkat_kebahagiaan' => TingkatKebahagiaanNelayan::where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->get(),
            'tanggapan_masyarakat' => TanggapanMasyarakat::where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->first(),
            'informasi_responden' => InformasiResponden::where('id', $respondentId)->first(),
            'informasi_usaha' => InformasiUsaha::with('ikan')->where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->first(),
            'informasi_pemasaran' => InformasiPemasaran::with('detail_pemasaran')->where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->first(),
            'pendapatan_rumah_tangga' => InformasiPendapatanRumahTangga::where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->first(),
            'sosial_kelembagaan' => SosialKelembagaan::where('knmp_id', $knmpId)
                ->where('responden_id', $respondentId)->first(),
        ];
    }

    private function flashRespondentToSession($selectedResponden, $selectedRespondenData)
    {
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

            // Flash ikan utama data
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

    private function getSectionCounts($knmpId)
    {
        return [
            'A' => ProfileKnmp::where('knmp_id', $knmpId)->count(),
            'B' => ProgresKnmp::where('knmp_id', $knmpId)->count(),
            'C' => InformasiResponden::where('knmp_id', $knmpId)->count(),
            'D' => TanggapanMasyarakat::where('knmp_id', $knmpId)->count(),
            'E' => TingkatKebahagiaanNelayan::where('knmp_id', $knmpId)->distinct('responden_id')->count('responden_id'),
            'F' => InformasiUsaha::where('knmp_id', $knmpId)->count(),
            'G' => InformasiPemasaran::where('knmp_id', $knmpId)->count(),
            'H' => InformasiPendapatanRumahTangga::where('knmp_id', $knmpId)->count(),
            'I' => SosialKelembagaan::where('knmp_id', $knmpId)->count(),
            'J' => BuktiUpload::where('knmp_id', $knmpId)->count(),
        ];
    }
}
