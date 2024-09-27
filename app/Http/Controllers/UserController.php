<?php

namespace App\Http\Controllers;


use App\Models\IsSahipligi;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function index(){
        $users = User::where('role_id','0')->with(['departman','ekipUyeleri.ekip','isSahiplikleri.work'])->get();
        foreach($users as $user){
            $user->tum_isler = (count($user->isSahiplikleri));
            $sayac = 0;
            foreach($user->isSahiplikleri as $is){
                if($is->work->durum =='1'){
                    $sayac +=1;
                }
            }
            $user->aktif_isler = $sayac;
        }
        $result = [
            'users' => $users,
        ];
        return view('panel.kullanici.index',$result);
    }

    public function details($id){
        $user = User::where('id',$id)->with(['departman','ekipUyeleri.ekip','isSahiplikleri.work.proje'])->first();
        $result = [
            'user' => $user,
            'analiz1'=>$this->isDurumlariAnaliz($id)
        ];
        return view('panel.kullanici.details',$result);
    }
    public function isDurumlariAnaliz($user_id){
        $isler = IsSahipligi::where('user_id',$user_id)->with('work')->get();
        $completed_count = 0;
        $active_count = 0;
        foreach($isler as $is){
            if($is->work->durum =='1'){
                $active_count += 1;
            }
            if($is->work->durum =='2'){
                $completed_count += 1;
            }

        }
        $result = [$active_count,$completed_count];
        return $result;
    }
    public function add(){
        return view('panel.kullanici.add');
    }
    public function edit(){
        return view('panel.kullanici.edit');
    }
}
