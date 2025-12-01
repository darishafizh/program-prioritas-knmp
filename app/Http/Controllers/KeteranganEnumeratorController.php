<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeteranganEnumeratorController extends Controller
{
    /**
     * Menampilkan daftar enumerator
     */
    public function index(Request $request)
    {
        // Ambil data dari session, jika belum ada pakai collection kosong
        $enumerators = collect($request->session()->get('enumerators', []))
            ->map(fn($item) => is_object($item) ? $item : (object) $item);

        return view('forms.keterangan-enumerator.index', compact('enumerators'));
    }

    /**
     * Tampilkan form tambah enumerator
     */
    public function create()
    {
        return view('forms.keterangan-enumerator.create');
    }

    /**
     * Simpan data enumerator baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_enumerator' => 'required|string|max:255',
            'tanggal_wawancara' => 'nullable|date',
            'tanggal_editing' => 'nullable|date',
            'nama_pemvalidasi' => 'nullable|string|max:255',
        ]);

        // Ambil data session saat ini
        $enumerators = collect($request->session()->get('enumerators', []));

        // Buat ID baru (auto increment)
        $newId = $enumerators->isEmpty() ? 1 : max($enumerators->pluck('id')->toArray()) + 1;

        // Tambahkan enumerator baru sebagai object
        $enumerators->push((object)[
            'id' => $newId,
            'nama_enumerator' => $request->nama_enumerator,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'tanggal_editing' => $request->tanggal_editing,
            'nama_pemvalidasi' => $request->nama_pemvalidasi,
        ]);

        // Simpan kembali ke session
        $request->session()->put('enumerators', $enumerators->all());

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit enumerator
     */
    public function edit(Request $request, $id)
    {
        $enumerators = collect($request->session()->get('enumerators', []))
            ->map(fn($item) => is_object($item) ? $item : (object) $item);

        $enumerator = $enumerators->firstWhere('id', $id);

        if (!$enumerator) {
            return redirect()->route('forms.keterangan-enumerator.index')
                ->with('error', 'Data tidak ditemukan');
        }

        return view('forms.keterangan-enumerator.edit', compact('enumerator'));
    }

    /**
     * Update data enumerator
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_enumerator' => 'required|string|max:255',
            'tanggal_wawancara' => 'nullable|date',
            'tanggal_editing' => 'nullable|date',
            'nama_pemvalidasi' => 'nullable|string|max:255',
        ]);

        $enumerators = collect($request->session()->get('enumerators', []))
            ->map(fn($item) => is_object($item) ? $item : (object) $item);

        $enumerators = $enumerators->map(function ($item) use ($request, $id) {
            if ($item->id == $id) {
                $item->nama_enumerator = $request->nama_enumerator;
                $item->tanggal_wawancara = $request->tanggal_wawancara;
                $item->tanggal_editing = $request->tanggal_editing;
                $item->nama_pemvalidasi = $request->nama_pemvalidasi;
            }
            return $item;
        });

        // Simpan kembali ke session
        $request->session()->put('enumerators', $enumerators->all());

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Hapus enumerator
     */
    public function destroy(Request $request, $id)
    {
        $enumerators = collect($request->session()->get('enumerators', []))
            ->map(fn($item) => is_object($item) ? $item : (object) $item)
            ->reject(fn($item) => $item->id == $id)
            ->values();

        $request->session()->put('enumerators', $enumerators->all());

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
