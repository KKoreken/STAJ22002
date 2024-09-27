<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileManagerController;
use App\Models\Answer;
use App\Models\Bildirim;
use App\Models\Categories;
use App\Models\Departmant;
use App\Models\Ekip;
use App\Models\Form;
use App\Models\Interest;
use App\Models\IsEtkinlikleri;
use App\Models\Files;
use App\Models\IsSahipligi;
use App\Models\ProjectCategories;
use App\Models\Soru;
use App\Models\SoruForm;
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

class FormController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function index(){
        $items = Form::with('sorular')->get();
        foreach ($items as $item) {
            $item->soru_count =  $item->sorular->count();
        }
        $result = [
            'items' => $items,
        ];
        return view('panel.forms.index',$result);
    }
    public function edit($id){
        $item = Form::where('id',$id)->with('sorular.soru')->first();
        $sorular = Soru::where('status','Aktif')->get();

        $result = [
            'item'=>$item,
            'sorular' => $sorular
        ];
        return view('panel.forms.edit',$result);
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
        $sorular = Soru::where('status','Aktif')->get();

        $result = [
            'sorular'=>$sorular,
        ];
        return view('panel.forms.add',$result);
    }
    public function store(Request $request){
        $item = new Form();
        $item->title = $request->input('baslik');
        $item->save();
        $sorular = $request->soru;
        foreach ($sorular as $soru){
            $soruform = new SoruForm();
            $soruform->form_id = $item->id;
            $soruform->soru_id = $soru;
            $sayac = SoruForm::where('form_id',$item->id)->count()+1;
            $soruform->siralama = $sayac;
            $soruform->save();
        }
        return redirect()->route('soru-formlari');
    }
    public function update(Request $request){
        $sorular= $request->soru;
        $id = $request->input('id');
        foreach ($sorular as $soru){
            $formsoru = SoruForm::where('form_id',$id)
                ->where('soru_id',$soru)
                ->first();
            if(!$formsoru){
                $soruform = new SoruForm();
                $soruform->form_id = $id;
                $sayac = SoruForm::where('form_id',$id)->count()+1;
                $soruform->soru_id = $soru;
                $soruform->siralama = $sayac;
                $soruform->save();
            }
        }
        $item = Form::find($id)->first();
        $item->title = $request->input('baslik');
        $item->status = $request->input('status');
        $item->save();

        return redirect()->back();
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
    public function delete($id){
        $sorular = SoruForm::where('form_id',$id)->get();
        foreach ($sorular as $soru){
            $soru->delete();
        }
        Form::find($id)->delete();
        return redirect()->back();

    }
    public function deletefromform($id)
    {
        SoruForm::find($id)->delete();
        return redirect()->back();
    }
    public function getAnswers($id)
    {
        $items= Answer::where('form_id', $id)
            ->with('form')
            ->groupBy('token')  // token sütununa göre grupla
            ->pluck('token');   // sadece token isimlerini döndür
        $form = Form::find($id);
        $result= [
            'items' => $items,
            'form' => $form,
        ];
        return view('panel.answers.index',$result);
    }
    public function getAnswersDetails($token)
    {
        $items= Answer::where('token', $token)
            ->with('soru')
            ->get();
        $result= [
            'items' => $items,
        ];
        return view('panel.answers.details',$result);
    }


}
