<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;

class SurveyController extends Controller
{
    function index()
    {
        $knmps = ModelsKnmp::orderBy('id', 'asc')->get();
        return view('survey.index', compact('knmps'));
    }
}
