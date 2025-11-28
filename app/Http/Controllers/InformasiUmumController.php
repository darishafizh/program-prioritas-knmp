<?php

namespace App\Http\Controllers;

use App\Models\InformasiUmum;
use Illuminate\Http\Request;

class InformasiUmumController extends Controller
{
    public function create()
    {
        return view('dashboard.informasi_umum');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_responden' => 'required|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'status_responden' => 'nullable|string|max:255',
            'jenis_program' => 'nullable|string|max:255',
        ]);

        InformasiUmum::create($validated);

        return redirect()->route('informasi_umum.create')->with('success', 'Data Informasi Umum berhasil disimpan.');
    }
}
