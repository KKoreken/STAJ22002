<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileManagerController;
use App\Models\Bildirim;
use App\Models\Categories;
use App\Models\Departmant;
use App\Models\Ekip;
use App\Models\Interest;
use App\Models\IsEtkinlikleri;
use App\Models\Files;
use App\Models\IsSahipligi;
use App\Models\ProjectCategories;
use App\Models\Soru;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Proje;

class SoruController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function index(){
        $items = Soru::all();
        $result = [
            'item' => $items,
        ];
        return view('panel.sorus.index',$result);
    }
    public function edit($id){
        $soru = Soru::find($id);
        $result =[
            'item' => $soru,

        ];
        return view('panel.sorus.edit',$result);
    }
    public function details($id)
    {
        $work = Work::where('id',$id)->with(['proje','isSahipligi.user','dosya.user'])->first();
        $logs = IsEtkinlikleri::where('work_id',$id)->with(['user'])->get();
            foreach ($logs as $log){
                $log->end_time = Carbon::parse($log->created_at)->addHours(2);
            }
        $result = [
            'work'=> $work,
            'logs'=>$logs
        ];

        return view('panel.work.details',$result);
    }
    public function storeFile($work_id, $file)
    {
        $path = 'works/' . $work_id;
        $fm = new FileManagerController();
        $result = $fm->storeFile($file, $path);
        return $result;
    }
    public function add(){
        return view('panel.sorus.add');
    }
    public function store(Request $request){
        $item = new Soru;
        if($request->input('option')){
            $options = json_encode(array_filter($request->input('option'), function($value) {
                return !is_null($value);
            }));
            $item->options = $options;
        }



        $item->title = $request->baslik;
        $item->required = $request->required;
        $item->type = $request->type;
        $item->siralama = Soru::count()+1;

        $result = $item->save();


        return redirect()->route('form-sorulari');

    }

    public function delete($id){
        Soru::find($id)->delete();
        return redirect()->back();
    }


    public function  formSorulariGetir(){
        session(['sidebar' => 15]);

        $vFolder = 'panel.';
        $subFolder = 'tanimlar.';
        $lastFolder = 'questions.';
        $data = Soru::with('category')->get();
        $result = [
            'items'=>$data,
            'categories' => SoruKategori::where('status','Aktif')->orderBy('siralama','asc')->get()
        ];
        return view($vFolder.$subFolder.$lastFolder.'index',$result);
    }

//todo
        public function update(Request $request){
            $item = Soru::find($request->id);
            if($request->input('option')){
                $options = json_encode(array_filter($request->input('option'), function($value) {
                    return !is_null($value);
                }));
                $item->options = $options;
            }



            $item->title = $request->baslik;
            $item->required = $request->required;
            $item->type = $request->type;
            $item->siralama = Soru::count()+1;

            $result = $item->save();


            return redirect()->route('form-sorulari');
        return redirect()->route('panel-isler');
    }
    public function isEtkinligiEkle($workid,$text){
        $item = new IsEtkinlikleri();
        $item->work_id = $workid;
        $item->user_id = Auth::id();
        $item->text= $text;
        $item->save();
    }
    public function departmanDiziDon($is_id,$departmanlar){
        foreach ($departmanlar as $d){
            $this->departmanaIsAta($is_id,$d);
        }
    }
    public function departmanaIsAta($is_id,$departman_id){
        $users = User::where('departman_id',$departman_id)->get();
        foreach ($users as $user){
            $item = new IsSahipligi();
            $item->work_id= $is_id;
            $item->user_id= $user;
            $item->save();
        }
    }
    public function ekibeIsAta($is_id,$ekip_id){}
    public function kullaniciyaIsAta($is_id,$user_){}
    public function bildirimEkle($text,$id){
        $item = new Bildirim();
        $item->user_id = $id;
        $item->text = $text;
        $item->save();
    }

}
