<?php

namespace App\Http\Controllers;

use App\Models\Knmp as ModelsKnmp;

class FormsController extends Controller
{
    public function index($knmpId)
    {
        $knmp = ModelsKnmp::findOrFail($knmpId);
        return view('survey.forms.index', compact('knmp'));
    }
}
