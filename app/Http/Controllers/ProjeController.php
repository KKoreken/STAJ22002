<?php

namespace App\Http\Controllers;
use App\helpers;
use App\Models\Bildirim;
use App\Models\Departmant;
use App\Models\Ekip;
use App\Models\EkipUyeleri;
use App\Models\Files;
use App\Models\IsSahipligi;
use App\Models\Proje;
use App\Models\ProjeEtkinlikleri;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\WorkController;

class ProjeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(){
        $this->workC = new WorkController();
    }

    public function index(){
        $projeler = Proje::withCount('works')
            ->with(['works' => function ($query) {
                $query->withCount('isSahipligi');
            }])->get();

        // Her proje için is_sahipligi_count hesapla
        foreach ($projeler as $proje) {
            $totalIsSahipligiCount = 0;
            foreach ($proje->works as $work) {
                $totalIsSahipligiCount += $work->is_sahipligi_count;
            }
            $proje->is_sahipligi_count = $totalIsSahipligiCount;
        }
        $result = [
            'item' => $projeler
        ];
        return view('panel.proje.index',$result);
    }
    public function edit($id)
    {        $proje = Proje::where('id', $id)
        ->with(['works.users','works.isSahipligi','dosya'])
        ->first();
        foreach ($proje->works as $work) {
            $work->user_count = $work->users->count()-2;
        }
        $result = [
            'proje' => $proje,
            'analiz1'=> $this->isDurumlariAnaliz($id)
        ];
        return view('panel.proje.edit',$result);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $proje = Proje::where('id', $id)->update([
            'durum'=>$request->durum,
            'baslik'=>$request->baslik,
        ]);
        //dosya kaydetme
        if($request->file('dosya')){
            $dosya =$request->file('dosya');
            $path = $this->storeFile($id,$dosya);
            $item = new Files();
            $item->name=$request->dosyaAdi;
            $item->path=$path;
            $item->user_id = Auth::id();
            $item->project_id = $id;
            $item->save();
            //Takvime Ekleme
            $text = $item->name . ' isimli dosya eklendi.';
            $this->projeEtkinligiEkle($id,$text);
            //İşteki kullanıcılara Bildirim Gönderme
            $bildirimtext = Auth::user()->name. ' isimli kullanıcı tarafından ' . $text;
            $proje = Proje::where('id',$id)->with('works.isSahipligi.user')->first();
            foreach ($proje->works as $is){
                foreach ($is->isSahipligi as $user){
                    $this->bildirimEkle($bildirimtext,$user->user->id);
                }
            }
        }
        return redirect()->route('panel-project-details', ['id' => $id]);
    }
    public function isDurumlariAnaliz($id){
        $result = [
            Work::where([['proje_id', $id], ['durum', 0]])->count(),
            Work::where([['proje_id', $id], ['durum', 1]])->count(),
            Work::where([['proje_id', $id], ['durum', 2]])->count()
        ];
        return $result;
    }
    public function details($id){
        $proje = Proje::where('id', $id)
            ->with(['works.users','works.isSahipligi','dosya'])
            ->first();
        $result = [
            'proje' => $proje,
            'analiz1'=> $this->isDurumlariAnaliz($id)
        ];

        return view('panel.proje.details',$result);
    }
    public function add(){
        $departmanlar = Departmant::where('durum',1)->get();
        $ekipler = Ekip::where('durum',1)->get();
        $kullanicilar = User::where('role_id',0)->get();
        $result = [
            'departmanlar'=>$departmanlar,
            'ekipler'=>$ekipler ,
            'kullanicilar'=>$kullanicilar ,
        ];
        return view ('panel.proje.add',$result);
    }
    public function store(Request $request){

        $item = new Proje();
        $item->baslik = $request->proje_adi;
        $item->save();
        foreach ($request->jobs as $is){
            $work = new Work();
            $work->baslik=$is['is_adi'];
            $work->proje_id =$item->id;
            $work->baslangic_tarihi=$is['baslangic_tarihi'];
            $work->bitis_tarihi=$is['bitis_tarihi'];
            $work->oncelik=$is['oncelik'];
            $work->save();
            if(isset($is['katilimcilar']['departman'])){
                foreach ($is['katilimcilar']['departman'] as $departman){
                    $users = User::where('departman_id',$departman)->get();
                    $this->projeIsiniKullaniciyaAta($users,$work->id);
                }
            }
            if (isset($is['katilimcilar']['ekip'])){
                foreach ($is['katilimcilar']['ekip'] as $ekip){
                    $this->projeIsiniEkibeAta($work->id,$ekip);
                }
            }
            if (isset($is['katilimcilar']['kullanici'])){
                foreach ($is['katilimcilar']['kullanici'] as $kullanici){
                    $this->tekilKisiyeAta($work->id,$kullanici);
                }
            }

        }
        return redirect()->route('panel-projects');
    }
    public function projeIsiniKullaniciyaAta($users,$work_id){
        foreach ($users as $user){
            if(!$this->isSahiplikKontrol($user,$work_id)){
                $item = new IsSahipligi();
                $item->user_id = $user->id;
                $item->work_id = $work_id;
                $item->save();
            }

        }
    }
    public function isSahiplikKontrol($user_id,$work_id){
        return IsSahipligi::where([['user_id',$user_id],['work_id',$work_id]])->first();
    }
    public function projeIsiniEkibeAta($work_id,$ekip_id){
        $users = EkipUyeleri::where('ekip_id',$ekip_id)->get();
        foreach ($users as $user){
            if(!$this->isSahiplikKontrol($user,$work_id)){
                $item = new IsSahipligi();
                $item->user_id = $user->user_id;
                $item->work_id = $work_id;
                $item->save();
            }
        }
    }
    public function tekilKisiyeAta($work_id,$user_id){
        if(!$this->isSahiplikKontrol($user_id,$work_id)){
            $item = new IsSahipligi();
            $item->user_id = $user_id;
            $item->work_id = $work_id;
            $item->save();
        }
    }
    public function storeFile($procts_id, $file)
    {
        $path = 'works/' . $procts_id;
        $fm = new FileManagerController();
        $result = $fm->storeFile($file, $path);
        return $result;
    }
    public function projeEtkinligiEkle($project_id,$text){
        $item = new ProjeEtkinlikleri();
        $item->project_id = $project_id;
        $item->user_id = Auth::id();
        $item->text= $text;
        $item->save();
    }
    public function bildirimEkle($text,$id){
        $item = new Bildirim();
        $item->user_id = $id;
        $item->text = $text;
        $item->save();
    }
}
