<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Interest;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IndexController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }
    public function smn(){
        return view('smn');
    }
    public function index(){
        $hakkimda = $this->ortak->hakkimdaYazi();
        $result = [
          'hakkimda' => $hakkimda,
          'sonposts'=> $this->ortak->son2post(),
          'interests' => $this->getInterest(),
          'sonprojeler'=>$this->ortak->son10proje()
        ];
        return view('home',$result);
    }
    public function about(){
        $result = [
            'hakkimda'=> $this->ortak->hakkimdaYazi(),
        ];
        return view('about',$result);
    }
    public function interesting(){
        return view('interesting');
    }
    public function portfolio(){
        return view('portfolio');
    }

    public function blog(){
        $items = Blog::with('category')->get();
        foreach ($items as $item){
            $item->created_at = $this->tarihAyarla($item->created_at);
        }
        return view('blog.index',compact('items'));
    }
    public function blogdetay(){
        return view('blog.detail');
    }

    public function getInterest(){
        return Interest::where('aktifMi',1)->get();
    }

    public function tarihAyarla($tarih){
        Carbon::setLocale('tr');
        $date = Carbon::parse($tarih);

        $date = $date->translatedFormat('j F Y H:i');
        return $date;
    }
}
