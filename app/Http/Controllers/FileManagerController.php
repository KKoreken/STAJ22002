<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileManagerController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getFiles(){
        $items= Photo::all();
        $result = ['items'=>$items];
        return view('panel.filemanager.index',$result);
    }
    public function addFile(){
        return view('panel.filemanager.add');
    }
    public function storeFile($dosya,$path){
        $url =Storage::putFile($path,$dosya);
        return $url;

    }
    public function addFilePost(Request $request){
        $image = $request->file('foto');
        $url = $image->store('image');
        $item = new Photo();
        $item->url = $url;
        $item->text = $request->text;
        $result=$item->save();
        $this->checkResult($result);
        return redirect()->route('getFiles');
    }
    public function deleteFile($id){
        $photo  = Photo::find($id);
        if(Storage::delete($photo->url)){
            $result = Photo::destroy($id);
            $this->checkResult($result);
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
        return redirect()->route('getFiles');
    }

    public function checkResult($result){
        if ($result){
            session()->flash('success', 'İşlem Başarılı!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
    }
}
