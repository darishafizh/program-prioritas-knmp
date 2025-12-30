<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;
use App\Models\BuktiUpload;

class SurveyController extends Controller
{
    function index()
    {
        $knmps = ModelsKnmp::with([
            'province',
            'regency',
            'district',
            'village',
            'buktiUploads' => function($query) {
                $query->orderBy('created_at', 'desc')->take(10);
            }
        ])->orderBy('id', 'asc')->get();
        return view('survey.index', compact('knmps'));
    }

    public function store()
    {
        //
    }
}
