<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TargetRealisasiController extends Controller
{
    // ==============================
    // LIST DATA
    // ==============================
    public function index(Request $request)
    {
        $items = collect($request->session()->get('target_realisasi', []));
        return view('forms.target-realisasi.index', compact('items'));
    }

    // ==============================
    // CREATE
    // ==============================
    public function create()
    {
        return view('forms.target-realisasi.form');
    }

    // ==============================
    // STORE (SAVE)
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_knmp'        => 'required|string|max:255',
            'ppk'              => 'required|string|max:255',
            'kontraktor'       => 'required|string|max:255',
            'target_fisik'     => 'required|numeric',
            'realisasi_fisik'  => 'required|numeric',
        ]);

        $items = $request->session()->get('target_realisasi', []);
        $newId = empty($items) ? 1 : max(array_column($items, 'id')) + 1;

        $items[] = [
            'id'              => $newId,
            'nama_knmp'       => $request->nama_knmp,
            'ppk'             => $request->ppk,
            'kontraktor'      => $request->kontraktor,
            'target_fisik'    => $request->target_fisik,
            'realisasi_fisik' => $request->realisasi_fisik,
        ];

        $request->session()->put('target_realisasi', $items);

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // ==============================
    // EDIT
    // ==============================
    public function edit(Request $request, $id)
    {
        $items = collect($request->session()->get('target_realisasi', []));
        $item = $items->firstWhere('id', $id);

        if (!$item) {
            return redirect()->route('forms.target_realisasi.index')
                ->with('error', 'Data tidak ditemukan');
        }

        return view('forms.target-realisasi.form', compact('item'));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_knmp'        => 'required|string|max:255',
            'ppk'              => 'required|string|max:255',
            'kontraktor'       => 'required|string|max:255',
            'target_fisik'     => 'required|numeric',
            'realisasi_fisik'  => 'required|numeric',
        ]);

        $items = collect($request->session()->get('target_realisasi', []));

        $updated = $items->map(function ($item) use ($request, $id) {
            if ($item['id'] == $id) {
                $item['nama_knmp']       = $request->nama_knmp;
                $item['ppk']             = $request->ppk;
                $item['kontraktor']      = $request->kontraktor;
                $item['target_fisik']    = $request->target_fisik;
                $item['realisasi_fisik'] = $request->realisasi_fisik;
            }
            return $item;
        });

        $request->session()->put('target_realisasi', $updated->all());

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy(Request $request, $id)
    {
        $items = collect($request->session()->get('target_realisasi', []))
            ->reject(fn($i) => $i['id'] == $id)
            ->values()
            ->all();

        $request->session()->put('target_realisasi', $items);

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
