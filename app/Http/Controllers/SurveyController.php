<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;
use App\Models\BuktiUpload;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpDistricts;
use App\Models\KnmpVillages;
use App\Imports\KnmpImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = ModelsKnmp::with([
            'province',
            'regency',
            'district',
            'village',
            'buktiUploads' => function ($query) {
                $query->orderBy('created_at', 'desc')->take(10);
            }
        ]);

        // If user is a village user, only show their assigned KNMP
        if ($user->isVillageUser()) {
            $query->where('id', $user->knmp_id);
        }

        $knmps = $query->orderBy('id', 'asc')->get();

        // Get provinces for dropdown (Admin only)
        $provinces = KnmpProvinces::orderBy('name', 'asc')->get();

        // Calculate KPI Stats for the 6 Cards
        $knmpIds = $knmps->pluck('id')->toArray();
        $totalKnmp = count($knmps);

        // Ketersediaan Infrastruktur
        $infraColumns = [
            'infra_jalan_akses', 'infra_listrik', 'infra_air_bersih', 'infra_internet',
            'infra_ipal', 'infra_dermaga_tambat', 'infra_tpi', 'infra_cold_storage',
            'infra_pabrik_es', 'infra_kantor_koperasi', 'infra_bengkel_nelayan', 'infra_waserda'
        ];
        $profiles = \App\Models\ProfileKnmp::whereIn('knmp_id', $knmpIds)->select($infraColumns)->get();
        $totalPercentage = 0;
        $countProfiles = $profiles->count();
        foreach ($profiles as $profile) {
            $filledCount = 0;
            foreach ($infraColumns as $col) {
                if ($profile->$col) {
                    $filledCount++;
                }
            }
            $totalPercentage += ($filledCount / 12) * 100;
        }
        $ketersediaanInfrastruktur = $countProfiles > 0 ? round($totalPercentage / $countProfiles, 2) : 0;

        // Indeks Kesesuaian Kebutuhan
        $totalTanggapan = \App\Models\TanggapanMasyarakat::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $sesuaiKebutuhan = \App\Models\TanggapanMasyarakat::where('kesesuaian_kebutuhan', 1)->whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $indeksKesesuaianKebutuhan = $totalTanggapan > 0 ? round(($sesuaiKebutuhan / $totalTanggapan) * 100, 2) : 0;

        // Pendapatan RT Nelayan
        $pendapatanRtNelayan = \App\Models\InformasiPendapatanRumahTangga::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->avg('pendapatan_total') ?? 0;

        // Indeks Kesejahteraan Nelayan
        $rataRataKebahagiaan = \App\Models\TingkatKebahagiaanNelayan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->avg('skor_nilai') ?? 0;
        $indeksKesejahteraan = round($rataRataKebahagiaan, 2);

        // Tingkat Kelembagaan Nelayan
        $totalSosial = \App\Models\SosialKelembagaan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->count();
        $anggotaKelompokKoperasi = \App\Models\SosialKelembagaan::whereHas('responden', function ($q) use ($knmpIds) {
            $q->whereIn('knmp_id', $knmpIds);
        })->where(function ($q) {
            $q->where('anggota_kelompok', '>=', 3)->orWhere('anggota_koperasi', '>=', 3);
        })->count();
        $tingkatKelembagaan = $totalSosial > 0 ? round(($anggotaKelompokKoperasi / $totalSosial) * 100, 2) : 0;

        return view('survey.index', compact(
            'knmps', 'provinces', 'totalKnmp', 'ketersediaanInfrastruktur',
            'indeksKesesuaianKebutuhan', 'pendapatanRtNelayan', 'indeksKesejahteraan', 'tingkatKelembagaan'
        ));
    }

    /**
     * Store a new KNMP (Admin only)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'province_id' => 'required|exists:knmp_provinces,id',
            'regency_id' => 'required|exists:knmp_regencies,id',
            'district_id' => 'required|exists:knmp_districts,id',
            'village_id' => 'required|exists:knmp_villages,id',
        ]);

        ModelsKnmp::create([
            'nama' => $request->nama,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
        ]);

        return redirect()->route('survey.index')->with('success', 'KNMP berhasil ditambahkan!');
    }

    /**
     * Import KNMP from Excel (Admin only)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new KnmpImport, $request->file('file'));
            return redirect()->route('survey.index')->with('success', 'Data KNMP berhasil diimport dari Excel!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for KNMP import
     */
    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\KnmpTemplateExport, 'template_import_knmp.xlsx');
    }

    /**
     * Delete a KNMP (Admin only)
     */
    public function destroy($id)
    {
        $knmp = ModelsKnmp::findOrFail($id);
        $knmp->delete();

        return redirect()->route('survey.index')->with('success', 'KNMP berhasil dihapus!');
    }

    /**
     * Get regencies by province (AJAX)
     */
    public function getRegencies($provinceId)
    {
        $regencies = KnmpRegencies::where('knmp_province_id', $provinceId)->orderBy('name', 'asc')->get();
        return response()->json($regencies);
    }

    /**
     * Get districts by regency (AJAX)
     */
    public function getDistricts($regencyId)
    {
        $districts = KnmpDistricts::where('knmp_regency_id', $regencyId)->orderBy('name', 'asc')->get();
        return response()->json($districts);
    }

    /**
     * Get villages by district (AJAX)
     */
    public function getVillages($districtId)
    {
        $villages = KnmpVillages::where('knmp_district_id', $districtId)->orderBy('name', 'asc')->get();
        return response()->json($villages);
    }
}
