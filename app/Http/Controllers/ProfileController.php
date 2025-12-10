<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Menampilkan data profil (halaman dashboard).
     */
    public function index()
    {
        $profile = Profile::first();
        return view('dashboard.profile', compact('profile'));
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        $profile = Profile::first();
        return view('dashboard.profile_edit', compact('profile'));
    }

    /**
     * Menyimpan atau mengupdate data profil.
     */
    public function store(Request $request)
    {
        // Validasi input
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

        try {

            // Filter: hanya update field yang ada isinya
            $dataToUpdate = array_filter($validated, function ($value) {
                return $value !== null && $value !== '';
            });

            // Ambil data pertama di tabel (karena hanya ada 1 profil)
            $profile = Profile::first();

            if ($profile) {
                // Update data lama (hanya field yang diisi)
                $profile->update($dataToUpdate);
            } else {
                // Jika belum ada, simpan data baru lengkap
                Profile::create($validated);
            }

            return redirect()
                ->route('profile.index')
                ->with('success', 'Profile berhasil disimpan.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
