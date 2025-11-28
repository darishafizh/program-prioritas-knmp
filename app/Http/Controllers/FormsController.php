<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormsController extends Controller
{
    function index()
    {
        return view('forms.index');
    }
}
