<?php

namespace App\Http\Controllers;

use App\Models\ProfileKnmp;
use Illuminate\Http\Request;
use App\Models\ProfilKnmp;

class ProfilKnmpController extends Controller
{
    public function index()
    {
        $profilKnmp = ProfileKnmp::all();
        return view('forms.profil-knmp.index', compact('profilKnmp'));
    }

    public function create()
    {
        return view('forms.profil-knmp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_penduduk' => 'nullable|integer',
            'jumlah_nelayan' => 'nullable|integer',
            'pendapatan_rata_rata' => 'nullable|numeric',
            'alokasi_konstruksi' => 'nullable|numeric',
            'alokasi_upah_tenaga_kerja' => 'nullable|numeric',
            'tenaga_kerja_laki' => 'nullable|integer',
            'tenaga_kerja_perempuan' => 'nullable|integer',
            'tenaga_kerja_lokal' => 'nullable|integer',
            'tenaga_kerja_luar' => 'nullable|integer',
            'volume_produksi' => 'nullable|numeric',
            'nilai_produksi' => 'nullable|numeric',
            'calon_koperasi' => 'nullable|string',
            'nama_ketua' => 'nullable|string',
            'sk_kopdeskel' => 'nullable|string',
            'nomor_induk' => 'nullable|string',
            'jumlah_anggota_laki' => 'nullable|integer',
            'jumlah_anggota_perempuan' => 'nullable|integer',
            'koordinat_lokasi' => 'nullable|string',
        ]);

        ProfileKnmp::create($request->all());

        return redirect()->route('forms.profil-knmp.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(ProfileKnmp $profilKnmp)
    {
        return view('forms.profil-knmp.edit', compact('profilKnmp'));
    }

    public function update(Request $request, ProfileKnmp $profilKnmp)
    {
        $request->validate([
            'jumlah_penduduk' => 'nullable|integer',
            'jumlah_nelayan' => 'nullable|integer',
            'pendapatan_rata_rata' => 'nullable|numeric',
            'alokasi_konstruksi' => 'nullable|numeric',
            'alokasi_upah_tenaga_kerja' => 'nullable|numeric',
            'tenaga_kerja_laki' => 'nullable|integer',
            'tenaga_kerja_perempuan' => 'nullable|integer',
            'tenaga_kerja_lokal' => 'nullable|integer',
            'tenaga_kerja_luar' => 'nullable|integer',
            'volume_produksi' => 'nullable|numeric',
            'nilai_produksi' => 'nullable|numeric',
            'calon_koperasi' => 'nullable|string',
            'nama_ketua' => 'nullable|string',
            'sk_kopdeskel' => 'nullable|string',
            'nomor_induk' => 'nullable|string',
            'jumlah_anggota_laki' => 'nullable|integer',
            'jumlah_anggota_perempuan' => 'nullable|integer',
            'koordinat_lokasi' => 'nullable|string',
        ]);

        $profilKnmp->update($request->all());

        return redirect()->route('forms.profil-knmp.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(ProfileKnmp $profilKnmp)
    {
        $profilKnmp->delete();
        return redirect()->route('forms.profil-knmp.index')->with('success', 'Data berhasil dihapus.');
    }
}
