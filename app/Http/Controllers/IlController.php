<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Il;
use App\Models\Sube;

class IlController extends Controller
{
    public function index()
    {
        $iller = Il::all();
        $subeler = Sube::all();
        return view('subewelcome', compact('iller', 'subeler'));
    }
}
