<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ilce;

class IlceController extends Controller
{
    public function getIlceler($il_id)
    {
        $ilceler = Ilce::where('il_id', $il_id)->get();
        return response()->json($ilceler);
    }
}
