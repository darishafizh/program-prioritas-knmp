<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('dashboard.profile', compact('profile'));
    }

    public function edit()
    {
        $profile = Profile::first();
        return view('dashboard.profile_edit', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kampung' => 'nullable|string|max:255',
            'lingkungan_kawasan' => 'nullable|string',
            'aktivitas_usaha_nelayan' => 'nullable|string',
            'sarana_prasarana' => 'nullable|string',
            'status_kepemilikan_tanah' => 'nullable|string',
            'nama_kopdeskel' => 'nullable|string|max:255',
            'dasar_hukum_kopdeskel' => 'nullable|string',
            'ketua_kopdeskel' => 'nullable|string|max:255',
            'status_e_kusuka' => 'nullable|string|max:255',
            'jenis_usaha_sebelum_knmp' => 'nullable|string',
        ]);

        // Filter out empty/null fields to preserve existing data
        $dataToUpdate = array_filter($validated, function($value) {
            return $value !== null && $value !== '';
        });

        $profile = Profile::first();
        if ($profile) {
            $profile->update($dataToUpdate);
        } else {
            Profile::create($validated);
        }

        return redirect()->route('profile.index')->with('success', 'Profile berhasil disimpan.');
    }
}
