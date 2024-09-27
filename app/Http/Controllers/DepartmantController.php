<?php

namespace App\Http\Controllers;


use App\Models\DepartmantEkipleri;
use App\Models\Ekip;
use App\Models\EkipUyeleri;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Departmant;

class DepartmantController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function index(){
        $departmants = Departmant::withCount(['ekipler', 'users'])->get();
        return view('panel.departman.index', compact('departmants'));
    }
    public function getDepartmants(){
        return Departmant::all();
    }
    public function getDepartmant($id){
        return Departmant::where('id', $id)->first();
    }
    public function details($id){
        $departmant = Departmant::with(['ekipler','ekipler.ekip'])->where('id', $id)->first();
        foreach ($departmant->ekipler as $ekip){
            $ekip->ekip->uye_sayisi = EkipUyeleri::where('ekip_id', $ekip->ekip_id)->count();
        }
        return view('panel.departman.details', compact('departmant'));
    }

    public function add(){
        $ekipler = Ekip::whereNull('departman_id')
            ->where('durum', 1)  // Sayı olarak kontrol
            ->get();
        $result  = [
            'ekipler' => $ekipler
        ];
        return view('panel.departman.add',$result);
    }
    public function edit($id){
        $departmant = $this->getDepartmant($id);
        return view('panel.departman.edit', compact('departmant'));
    }
    public function store(Request $request){
        $departman = Departmant::where('baslik',$request->baslik)->first();
        if (!$departman){
            $ekipler = array_unique($request->ekipler);
            $item = new Departmant();
            $item->baslik = $request->input('baslik');
            $item->save();
            foreach ($ekipler as $ekip) {
                $this->ekipEkle($item->id, $ekip);
            }
        }
        return redirect()->route('panel-departmanlar');
    }
    public function update(Request $request){}
    public function delete($id){}
    public function ekipEkle($departman_id, $ekip_id){
        $item = new DepartmantEkipleri();
        $item->departman_id = $departman_id;
        $item->ekip_id = $ekip_id;
        $item->save();
        $this->ekipDepartmanGuncelle($departman_id,$ekip_id);
    }
    public function ekipDepartmanGuncelle($departman_id, $ekip_id){
        Ekip::where('id', $ekip_id)->update(['departman_id' => $departman_id]);
    }

}
