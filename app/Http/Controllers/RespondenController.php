<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\InformasiResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRespondenRequest;
use App\Exports\RespondenExport;
use Maatwebsite\Excel\Facades\Excel;

class RespondenController extends Controller
{
    /**
     * Display a listing of the responden for editing.
     *
     * @param  \App\Models\Knmp  $knmp
     * @return \Illuminate\View\View
     */
    public function editRespondenList(Knmp $knmp)
    {
        // Ambil semua responden dengan data yang relevan
        $responden = InformasiResponden::where('knmp_id', $knmp->id)
            ->with(['knmp'])
            ->orderBy('tanggal_wawancara', 'desc')
            ->get()
            ->map(function ($item) use ($knmp) {
                // Cek apakah responden ini sudah mengisi SEMUA form yang wajib
                $hasTanggapan = DB::table('tanggapan_masyarakat')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasTingkatKebahagiaan = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasInformasiUsaha = DB::table('informasi_usaha')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasPemasaran = DB::table('informasi_pemasaran')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasPendapatanRT = DB::table('informasi_pendapatan_rumah_tangga')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                $hasSosialKelembagaan = DB::table('sosial_kelembagaan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->exists();

                // Hitung total form yang terisi (dari 6 form wajib)
                $filledForms = collect([
                    $hasTanggapan,
                    $hasTingkatKebahagiaan,
                    $hasInformasiUsaha,
                    $hasPemasaran,
                    $hasPendapatanRT,
                    $hasSosialKelembagaan
                ])->filter()->count();

                $totalForms = 6;

                // Hitung total jawaban untuk ditampilkan
                $totalRecords = DB::table('tingkat_kebahagiaan_nelayan')
                    ->where('knmp_id', $knmp->id)
                    ->where('responden_id', $item->id)
                    ->count();

                // Ambil tanggal terakhir pengisian dari semua tabel
                $lastUpdatedDates = collect([
                    DB::table('tanggapan_masyarakat')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('tingkat_kebahagiaan_nelayan')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_usaha')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_pemasaran')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('informasi_pendapatan_rumah_tangga')->where('responden_id', $item->id)->max('updated_at'),
                    DB::table('sosial_kelembagaan')->where('responden_id', $item->id)->max('updated_at'),
                ])->filter()->max();

                return [
                    'id' => $item->id,
                    'nama_responden' => $item->nama_responden,
                    'nik' => $item->nik,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tanggal_wawancara' => $item->tanggal_wawancara,
                    'nama_enumerator' => $item->nama_enumerator,
                    'total_answers' => $totalRecords,
                    'filled_forms' => $filledForms,
                    'total_forms' => $totalForms,
                    'last_updated' => $lastUpdatedDates,
                    'is_complete' => $filledForms === $totalForms, // SEMUA form harus terisi
                ];
            });

        return view('survey.forms.edit-responden', compact('knmp', 'responden'));
    }

    /**
     * Store a newly created information responden in storage.
     *
     * @param  \App\Http\Requests\StoreRespondenRequest  $request
     * @param  int  $knmpId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_informasi_responden(StoreRespondenRequest $request, $knmpId)
    {
        $validated = $request->validated();
        $validated['knmp_id'] = $knmpId;

        DB::beginTransaction();
        try {
            InformasiResponden::create($validated);
            DB::commit();
            return back()->with('success', 'Informasi Responden berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data responden. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * Remove the specified responden from storage (bulk delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_responden(Request $request)
    {
        $request->validate([
            'responden_ids' => 'required|array',
            'responden_ids.*' => 'integer|exists:informasi_responden,id',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->responden_ids as $respondenId) {
                // Hapus data terkait responden
                DB::table('tingkat_kebahagiaan_nelayan')->where('responden_id', $respondenId)->delete();
                DB::table('tanggapan_masyarakat')->where('responden_id', $respondenId)->delete();
                DB::table('informasi_usaha_ikan')->where('responden_id', $respondenId)->delete();
                DB::table('informasi_usaha')->where('responden_id', $respondenId)->delete();
                DB::table('detail_pemasaran_ikan')->where('responden_id', $respondenId)->delete();
                DB::table('informasi_pemasaran')->where('responden_id', $respondenId)->delete();
                DB::table('informasi_pendapatan_rumah_tangga')->where('responden_id', $respondenId)->delete();
                DB::table('sosial_kelembagaan')->where('responden_id', $respondenId)->delete();

                // Hapus responden
                InformasiResponden::where('id', $respondenId)->delete();
            }

            DB::commit();
            return back()->with('success', count($request->responden_ids) . ' responden berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus responden. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * Export responden data to Excel.
     *
     * @param  int|null  $knmpId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel($knmpId = null)
    {
        $filename = 'data-responden';
        if ($knmpId) {
            $knmp = Knmp::find($knmpId);
            $filename .= '-' . ($knmp ? str_replace(' ', '-', strtolower($knmp->nama)) : $knmpId);
        }
        $filename .= '-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new RespondenExport($knmpId), $filename);
    }
}

