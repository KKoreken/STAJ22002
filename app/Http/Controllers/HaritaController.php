<?php

namespace App\Http\Controllers;

use App\Models\Ilce;
use Illuminate\Http\Request;
use App\Models\Il;
use App\Models\Sube;

class HaritaController extends Controller
{
    public function ilEkle(){
        return view('harita.sehirekle');
    }
    public function ilEklePost(Request $request){
        $item = new Il();
        $item->id = $request->plaka;
        $item->baslik = $request->sehiradi;
        $item->save();
        return redirect('/harita');

    }
    public function ilceEkle(){
        $il = Il::all();
        return view('harita.ilceekle',compact('il'));

    }
    public function ilceEklePost(Request $request){
        $item = new Ilce();
        $item->baslik = $request->ilceadi;
        $item->il_id = $request->plaka;
        $item->save();
        return redirect('/harita');
    }
    public function subeEkle(){
        $il = Il::all();
        return view('harita.subeekle',compact('il'));
    }
    public function subeEklePost(Request $request){
        $item = new Sube();
        $item->baslik =$request->subeadi;
        $item->telefon_no ='0123 456 7890';
        $item->adres ='dernek adres bilgisi';
        $item->longitude =$request->longitude;
        $item->latitude =$request->langtide;
        $item->ilce_id =$request->ilce_id;
        $item->il_id =$request->il_id;
        $item->save();
        return redirect('/harita');
    }
}
