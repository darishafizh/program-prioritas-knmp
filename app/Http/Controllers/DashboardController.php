<?php

namespace App\Http\Controllers;

use App\Models\TitikKoordinasi;

class DashboardController extends Controller
{
    public function index()
    {
        $desa_knmp = TitikKoordinasi::select('nama', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($d) {
                return [
                    'nama' => $d->nama,
                    'latitude' => (float) $d->latitude,
                    'longitude' => (float) $d->longitude,
                ];
            })->values();

        return view('dashboard.index', compact('desa_knmp'));
    }
}
