<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;
use App\Models\BuktiUpload;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    function index()
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

        return view('survey.index', compact('knmps'));
    }

    public function store()
    {
        //
    }
}
