<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use App\Models\BuktiUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EvidenceController extends Controller
{
    /**
     * Display the evidence page.
     *
     * @param  \App\Models\Knmp  $knmp
     * @return \Illuminate\View\View
     */
    public function evidence(Knmp $knmp)
    {
        $buktiUploads = BuktiUpload::where('knmp_id', $knmp->id)
            ->latest()
            ->get();

        return view(
            'survey.evidence',
            compact('knmp', 'buktiUploads')
        );
    }

    /**
     * Store a newly uploaded evidence file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_bukti_upload(Request $request)
    {
        $request->validate([
            'knmp_id' => 'required|exists:knmp,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $file = $request->file('file');

        $path = $file->store('bukti_uploads', 'public');

        BuktiUpload::create([
            'knmp_id' => $request->knmp_id,
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $path,
            'tipe_file' => $file->getClientMimeType(),
            'ukuran_file' => $file->getSize(),
        ]);

        return back()->with('success', 'File berhasil diupload');
    }

    /**
     * Remove specified evidence files (bulk delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_bukti_upload(Request $request)
    {
        $request->validate([
            'file_ids' => 'required|array',
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

    /**
     * Remove a single evidence file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_bukti_single($id)
    {
        $file = BuktiUpload::findOrFail($id);

        DB::transaction(function () use ($file) {
            Storage::disk('public')->delete($file->path_file);
            $file->delete();
        });

        return back()->with('success', 'File berhasil dihapus');
    }
}
