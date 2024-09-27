<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sube;

class YeniSubeController extends Controller
{
    public function getSubeler($ilce_id)
    {
        $subeler = Sube::where('ilce_id', $ilce_id)->get();
        return response()->json($subeler);
    }
    public function getSubelerByIlId($il_id){
        $subeler = Sube::where('il_id',$il_id)->get();
        return response()->json($subeler);
    }
}
