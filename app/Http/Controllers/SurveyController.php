<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;
use App\Models\BuktiUpload;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpDistricts;
use App\Models\KnmpVillages;
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

        return view('survey.index', compact('knmps', 'provinces'));
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
        $regencies = KnmpRegencies::where('province_id', $provinceId)->orderBy('name', 'asc')->get();
        return response()->json($regencies);
    }

    /**
     * Get districts by regency (AJAX)
     */
    public function getDistricts($regencyId)
    {
        $districts = KnmpDistricts::where('regency_id', $regencyId)->orderBy('name', 'asc')->get();
        return response()->json($districts);
    }

    /**
     * Get villages by district (AJAX)
     */
    public function getVillages($districtId)
    {
        $villages = KnmpVillages::where('district_id', $districtId)->orderBy('name', 'asc')->get();
        return response()->json($villages);
    }
}
