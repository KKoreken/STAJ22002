<?php

namespace App\Http\Controllers;
use App\helpers;
use App\Models\Blog;
use App\Models\PostLabel;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrtakController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function son2post()
    {
        $sonposts = Blog::with('category')
            ->latest() // created_at sütununa göre en yeni öğeleri getirir
            ->take(2) // son iki öğeyi getirir
            ->get();
        return $sonposts;
    }
    public function siraGuncelle(Request $request){
        $sira = $request->input('sira');
        $tabloadi = $request->input('tabloadi');
        foreach ($sira as $index => $id) {
            DB::table($tabloadi)->where('id', $id)->update(['siralama' => $index + 1]);
        }
        return response()->json(['success' => 'Sıralama Düzenleme İşlemi Başarılı!']);

    }
    public function son10proje()
    {
        $sonprojeler = Project::with('lang')
            ->latest() // created_at sütununa göre en yeni öğeleri getirir
            ->take(10) // son iki öğeyi getirir
            ->get();
        foreach ($sonprojeler as $projeler) {
            Carbon::setLocale('tr');
            $projeler->created_at = Carbon::parse($projeler->created_at);
            $projeler->created_at = $projeler->created_at->translatedFormat('j F Y');

        }
        return $sonprojeler;
    }
    function urlOlustur($string)
    {
        // Türkçe karakterleri İngilizce karşılıklarıyla değiştir
        $turkish = ['ı', 'İ', 'ş', 'Ş', 'ç', 'Ç', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö'];
        $english = ['i', 'I', 's', 'S', 'c', 'C', 'g', 'G', 'u', 'U', 'o', 'O'];
        $string = str_replace($turkish, $english, $string);

        // Boşlukları alt çizgi ile değiştir
        $string = str_replace(' ', '_', $string);

        // Diğer istenmeyen karakterleri kaldır
        $string = preg_replace('/[^A-Za-z0-9\-_]/', '', $string);

        return $string;
    }
    public function checkResult($result){
        if ($result){
            session()->flash('success', 'İşlem Başarılı!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
    }
    public function tarihAyarla($tarih){
        Carbon::setLocale('tr');
        $date = Carbon::parse($tarih);
        $date = $date->translatedFormat('j F Y H:i');
        return $date;
    }
    public function hakkimdaYazi(){
        return DB::table('hakkimda')->first();
    }
}
