<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $knmp = Knmp::all();
        return view('laporan.index', compact('knmp'));
    }
}
