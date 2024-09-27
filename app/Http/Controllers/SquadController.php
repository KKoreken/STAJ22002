<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DepartmantController;
use App\Models\User;
use App\Models\Ekip;
use App\Models\EkipUyeleri;

class SquadController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
        $this->depC = new DepartmantController();

    }

    public function index(){
        $ekipler = Ekip::where('durum', 1)->withCount('uyesayilari')->get();
        $result = [
            'squads' => $ekipler
        ];

        return view('panel.ekip.index',$result);
    }

    public function details($id){
        $ekip = Ekip::with(['uyeler.user', 'uyeler.user.isSahiplikleri.work'])->where('id', $id)->first();

        if ($ekip) {
            $uyeler = $ekip->uyeler->map(function ($uye) {
                $user = $uye->user;
                $totalIsSayisi = count($user->isSahiplikleri);
                $aktif = 0;
                foreach ($user->isSahiplikleri as $is) {
                    if($is->work->durum == '1'){
                        $aktif += 1;
                    }
                }
                return [
                    'user' => $user,
                    'totalIsSayisi' => $totalIsSayisi,
                    'aktifIsSayisi' => $aktif,
                ];
            });
        }
        $result = [
            'uyeler' => $uyeler
        ];
        return view('panel.ekip.details',$result);
    }
    public function getSquads(){
        return Ekip::where('durum',1)->get();
    }
    public function add(){
        $result = [
            'users' =>User::where('role_id','0')->get(),
            'departmans' => $this->depC->getDepartmants(),
        ];
        return view('panel.ekip.add',$result);
    }
    public function edit(){
        return view('panel.ekip.edit');
    }
    public function delete($id){}
    public function store(Request $request){
        $ekip = Ekip::where([['baslik',$request->ekip_adi],['departman_id',$request->input('departman')]])->first();
        if (!$ekip){
            $item = new Ekip();
            $item->baslik = $request->input('ekip_adi');
            $item->departman_id = $request->input('departman');
            $item->save();
            $this->addSquadMember($item->id,$request->input('users'));
        }
         return $this->index();
    }
    public function addSquadMember($squad_id,$users){
        foreach ($users as $user){
            $statusMember  = EkipUyeleri::where([['ekip_id',$squad_id],['user_id',$user['user']]])->first();
            if(!$statusMember){
                $item = new EkipUyeleri();
                $item->user_id = $user['user'];
                $item->ekip_id = $squad_id;
                $item->save();
            }
        }

    }
    public function getSquadMembers($squad_id){
        return  EkipUyeleri::where(['ekip_id',$squad_id])->first();
    }
    public function update(Request $request){}
}
