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

class WorkController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function index(){
        $items = Work::with(['proje','users'])->get();
        foreach($items as $item){
            $item->user_count= 0;
            if(count($item->users)>2){
                $item->user_count = count($item->users)-2;
            }
        }
        $result = [
            'works' => $items,
        ];
        return view('panel.work.index',$result);
    }
    public function edit($id){
        $projects = Proje::all();
        $users = User::where('role_id',0)->get();
        $work = Work::where('id',$id)->with(['proje','isSahipligi.user','dosya.user'])->first();
        $result =[
            'users' => $users,
            'work' => $work,
            'projects' => $projects,
        ];
        return view('panel.work.edit',$result);
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
        $projects = Proje::whereNot('durum',0)->get();
        $departmanlar = Departmant::where('durum',1)->get();
        $ekipler = Ekip::where('durum',1)->get();
        $kullanicilar = User::where('role_id',0)->get();
        $result = [
            'departmants'=>$departmanlar,
            'ekipler' => $ekipler,
            'users' => $kullanicilar,
            'projects'=>$projects
        ];
        return view('panel.work.add',$result);
    }
    public function store(Request $request){
        dd($request->all());
        $item = new Work();
        $item->baslik = $request->input('baslik');
        $item->proje_id = $request->input('baslik');
        $item->baslangic_tarihi = $request->input('baslangic_tarihi');
        $item->bitis_tarihi = $request->input('bitis_tarihi');
        $item->oncelik = $request->input('oncelik');
        $item->save();

    }
    public function update(Request $request){
        $id =$request->id;
        $item = Work::where('id',$id)->first();
        $item->proje_id = $request->proje_id;
        $item->oncelik = $request->oncelik;
        $item->durum = $request->durum;
        $item->save();
        if(isset($request->katilimcilar['departman'])){
            $departmans = $request->katilimcilar['departman'];
            $this->departmanDiziDon($item->id,$departmans);
        }
        ///todo
        if($request->katilimci && !IsSahipligi::where([['work_id',$id],['user_id',$request->katilimci]])->first()){
            $item = new IsSahipligi();
            $item->work_id= $id;
            $item->user_id= $request->katilimci;
            $item->save();
        }

        //dosya kaydetme
            if($request->file('dosya')){
                $dosya =$request->file('dosya');
                $path = $this->storeFile($id,$dosya);
                    $item = new Files();
                    $item->name=$request->dosyaAdi;
                    $item->path=$path;
                    $item->user_id = Auth::id();
                    $item->project_id = $request->project_id;
                    $item->work_id = $id;
                    $item->save();
                    //Takvime Ekleme
                    $text = $item->name . ' isimli dosya eklendi.';
                    $this->isEtkinligiEkle($id,$text);
                    //İşteki kullanıcılara Bildirim Gönderme
                    $bildirimtext = Auth::user()->name. ' isimli kullanıcı tarafından ' . $text;
                    $users = Work::where('id',$id)->with('isSahipligi')->first();
                    foreach ($users->isSahipligi as $user){
                        $this->bildirimEkle($bildirimtext,$user->user->id
                        );
                    }

            }
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
