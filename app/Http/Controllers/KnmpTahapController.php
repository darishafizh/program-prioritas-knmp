<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\PenyediaJasaKonstruksi;
use App\Models\RiwayatTahap;
use App\Models\TahapUsulan;
use App\Models\TahapSurvey;
use App\Models\TahapDed;
use App\Models\TahapLelang;
use App\Models\TahapSerahTerima;
use App\Models\TahapKonstruksi;
use App\Models\TimelinePengerjaan;
use App\Models\ProgresHarian;
use App\Services\KnmpStageService;
use App\Imports\UsulanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KnmpTahapController extends Controller
{
    protected KnmpStageService $stageService;

    public function __construct(KnmpStageService $stageService)
    {
        $this->stageService = $stageService;
    }

    // =========================================================
    //  DAFTAR KNMP PER TAHAP
    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap Usulan.
     */
    public function usulanIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'usulan')->get();
        return view('knmp.tahap.usulan_index', compact('knmps'));
    }

    /**
     * Detail data tahap usulan untuk satu KNMP.
     */
    public function usulanShow(Knmp $knmp)
    {
        $data = TahapUsulan::where('knmp_id', $knmp->id)->first();
        return view('knmp.tahap.usulan_show', compact('knmp', 'data'));
    }

    /**
     * Simpan / update data tahap usulan.
     */
    public function usulanStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        TahapUsulan::updateOrCreate(
            ['knmp_id' => $knmp->id],
            $validated
        );

        return redirect()->back()->with('success', 'Data tahap usulan berhasil disimpan.');
    }

    /**
     * Import data usulan dari Excel.
     */
    public function usulanImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new UsulanImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data usulan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap Survey.
     */
    public function surveyTahapIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'survey')->get();
        return view('knmp.tahap.survey_index', compact('knmps'));
    }

    /**
     * Detail data tahap survey untuk satu KNMP.
     */
    public function surveyTahapShow(Knmp $knmp)
    {
        $data = TahapSurvey::where('knmp_id', $knmp->id)->first();
        return view('knmp.tahap.survey_show', compact('knmp', 'data'));
    }

    /**
     * Simpan / update data tahap survey.
     */
    public function surveyTahapStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tanggal' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        TahapSurvey::updateOrCreate(
            ['knmp_id' => $knmp->id],
            $validated
        );

        return redirect()->back()->with('success', 'Data tahap survey berhasil disimpan.');
    }

    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap DED.
     */
    public function dedIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'ded')->get();
        return view('knmp.tahap.ded_index', compact('knmps'));
    }

    /**
     * Detail data tahap DED untuk satu KNMP.
     */
    public function dedShow(Knmp $knmp)
    {
        $data = TahapDed::where('knmp_id', $knmp->id)->first();
        return view('knmp.tahap.ded_show', compact('knmp', 'data'));
    }

    /**
     * Simpan / update data tahap DED.
     */
    public function dedStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'nomor_dokumen'     => 'required|string|max:255',
            'tanggal_pengesahan'=> 'nullable|date',
            'file_url'          => 'nullable|string',
            'catatan'           => 'nullable|string',
        ]);

        TahapDed::updateOrCreate(
            ['knmp_id' => $knmp->id],
            $validated
        );

        return redirect()->back()->with('success', 'Data tahap DED berhasil disimpan.');
    }

    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap Lelang.
     */
    public function lelangIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'lelang')->get();
        return view('knmp.tahap.lelang_index', compact('knmps'));
    }

    /**
     * Detail data tahap Lelang untuk satu KNMP.
     */
    public function lelangShow(Knmp $knmp)
    {
        $data = TahapLelang::where('knmp_id', $knmp->id)->first();
        $penyediaList = PenyediaJasaKonstruksi::orderBy('nama')->get();
        return view('knmp.tahap.lelang_show', compact('knmp', 'data', 'penyediaList'));
    }

    /**
     * Simpan / update data tahap Lelang.
     */
    public function lelangStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tanggal_penetapan' => 'nullable|date',
            'catatan'           => 'nullable|string',
        ]);

        TahapLelang::updateOrCreate(
            ['knmp_id' => $knmp->id],
            $validated
        );

        return redirect()->back()->with('success', 'Data tahap lelang berhasil disimpan.');
    }

    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap Konstruksi.
     */
    public function konstruksiIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'konstruksi')
            ->withCount(['timeline', 'progresHarian'])
            ->get();
        return view('knmp.tahap.konstruksi_index', compact('knmps'));
    }

    /**
     * Detail data tahap Konstruksi — berisi timeline, progres harian, tahap konstruksi.
     */
    public function konstruksiShow(Knmp $knmp)
    {
        $timeline      = TimelinePengerjaan::where('knmp_id', $knmp->id)->orderBy('periode_minggu')->get();
        $progresHarian = ProgresHarian::where('knmp_id', $knmp->id)->orderByDesc('tanggal')->get();
        $tahapKonstruksi = TahapKonstruksi::where('knmp_id', $knmp->id)->with('penyediaJasa')->get();

        return view('knmp.tahap.konstruksi_show', compact(
            'knmp', 'timeline', 'progresHarian', 'tahapKonstruksi'
        ));
    }

    /**
     * Simpan timeline mingguan (Kurva S).
     */
    public function timelineStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tanggal_mulai'            => 'required|date',
            'tanggal_selesai_rencana'  => 'required|date|after_or_equal:tanggal_mulai',
            'periode_minggu'           => 'required|integer|min:1',
            'bobot_rencana_kumulatif'  => 'nullable|numeric|min:0|max:100',
            'bobot_realisasi_kumulatif'=> 'nullable|numeric|min:0|max:100',
            'status'                   => 'nullable|in:on_track,terlambat,selesai',
        ]);

        TimelinePengerjaan::create(array_merge($validated, ['knmp_id' => $knmp->id]));

        return redirect()->back()->with('success', 'Data timeline berhasil disimpan.');
    }

    /**
     * Simpan progres harian.
     */
    public function progresHarianStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'progres' => 'nullable|numeric|min:0|max:100',
        ]);

        ProgresHarian::create(array_merge($validated, ['knmp_id' => $knmp->id]));

        return redirect()->back()->with('success', 'Progres harian berhasil disimpan.');
    }

    /**
     * Simpan data tahap konstruksi (penyedia jasa, bobot, dll).
     */
    public function tahapKonstruksiStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'jasa_konstruksi_id'        => 'nullable|exists:penyedia_jasa_konstruksi,id',
            'periode_mingguan'          => 'nullable|integer|min:1',
            'bobot_rencana_kumulatif'   => 'nullable|numeric|min:0|max:100',
            'bobot_realisasi_kumulatif' => 'nullable|numeric|min:0|max:100',
        ]);

        TahapKonstruksi::create(array_merge($validated, ['knmp_id' => $knmp->id]));

        return redirect()->back()->with('success', 'Data tahap konstruksi berhasil disimpan.');
    }

    // =========================================================

    /**
     * Halaman daftar KNMP pada tahap Serah Terima.
     */
    public function serahTerimaIndex()
    {
        $knmps = Knmp::where('tahap_saat_ini', 'serah_terima')->get();
        return view('knmp.tahap.serah_terima_index', compact('knmps'));
    }

    /**
     * Detail data tahap Serah Terima.
     */
    public function serahTerimaShow(Knmp $knmp)
    {
        $data = TahapSerahTerima::where('knmp_id', $knmp->id)->first();
        $lelang = TahapLelang::where('knmp_id', $knmp->id)->first();
        return view('knmp.tahap.serah_terima_show', compact('knmp', 'data', 'lelang'));
    }

    /**
     * Simpan / update data tahap Serah Terima.
     */
    public function serahTerimaStore(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'nomor_kontrak' => 'required|string|max:255',
            'tanggal_serah' => 'nullable|date',
            'catatan'       => 'nullable|string',
        ]);

        TahapSerahTerima::updateOrCreate(
            ['knmp_id' => $knmp->id],
            $validated
        );

        return redirect()->back()->with('success', 'Data serah terima berhasil disimpan.');
    }

    // =========================================================
    //  RIWAYAT TAHAP
    // =========================================================

    /**
     * Halaman riwayat perpindahan tahap seluruh KNMP.
     */
    public function riwayatIndex(Request $request)
    {
        $query = RiwayatTahap::with('knmp')->orderByDesc('created_at');

        $riwayat = $query->paginate(25);
        return view('knmp.tahap.riwayat_index', compact('riwayat'));
    }

    // =========================================================
    //  PERPINDAHAN TAHAP (Single & Batch)
    // =========================================================

    /**
     * Pindahkan satu KNMP ke tahap baru.
     */
    public function moveStage(Request $request, Knmp $knmp)
    {
        $validated = $request->validate([
            'tahap_baru' => 'required|in:' . implode(',', KnmpStageService::STAGES),
            'keterangan' => 'nullable|string',
        ]);

        $this->stageService->moveToStage($knmp, $validated['tahap_baru'], $validated['keterangan'] ?? null);

        return redirect()->back()->with('success', 'Tahap KNMP berhasil dipindahkan ke ' . strtoupper($validated['tahap_baru']) . '.');
    }

    /**
     * Pindahkan beberapa KNMP sekaligus (batch).
     */
    public function batchMoveStage(Request $request)
    {
        $validated = $request->validate([
            'knmp_ids'   => 'required|array|min:1',
            'knmp_ids.*' => 'exists:knmp,id',
            'tahap_baru' => 'required|in:' . implode(',', KnmpStageService::STAGES),
            'keterangan' => 'nullable|string',
        ]);

        $this->stageService->batchMoveToStage(
            $validated['knmp_ids'],
            $validated['tahap_baru'],
            $validated['keterangan'] ?? null
        );

        return redirect()->back()->with('success', 'Batch perpindahan tahap berhasil.');
    }
    /**
     * Hapus KNMP.
     */
    public function destroy(Knmp $knmp)
    {
        $knmp->delete();
        return redirect()->back()->with('success', 'KNMP berhasil dihapus.');
    }
    /**
     * Hapus beberapa KNMP sekaligus (batch).
     */
    public function batchDestroy(Request $request)
    {
        $validated = $request->validate([
            'knmp_ids'   => 'required|array|min:1',
            'knmp_ids.*' => 'exists:knmp,id',
        ]);

        Knmp::whereIn('id', $validated['knmp_ids'])->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus ' . count($validated['knmp_ids']) . ' data KNMP.');
    }
}
