<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\SoruForm;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AnketController extends Controller
{
    public function getAnket($id){
        return view('user.token',compact('id'));
    }
    public function  createToken(Request $request){
        $formid = $request->formid;
        $email = $request->email;
        $check = Token::where('email',$email)
            ->where('status',1)
            ->where('form_id',$formid)
            ->first();
        if(!$check){
            $token = $this->randomToken();
            $item = new Token();
            $item->token = $token;
            $item->form_id = $formid;
            $item->email = $email;
            $item->save();
        }
        $content = url('/Anket-Token/'.$token);
        $mail = Mail::send('mailtemplates.token', [
            'content' => $content,
        ], function ($message) use ($email) {
            $message
                ->to($email)
                ->subject('Ankete giris linki');
        });
        return redirect()->back();
    }

    public function randomToken(){
        $token = Str::random(32);
        $check = Token::where('token', $token)->first();
        if($check){
            $this->randomToken();
        }
        return $token;
    }
    public function verifyToken($token){
        $item = Token::where('token', $token)->first();
        if ($item){
            $result['token'] = $token;
            $result ['form']= Form::with('sorular.soru')->where('id',$item->form_id)->first();
            return view('user.anket',$result);
        }
    }
    public function sendAnswers(Request $request){
        $cevaplar = $request->input('cevap'); // Cevap dizisini alıyoruz
        $token = $request->input('token'); // Token değerini alıyoruz
        $formid = $request->input('formid'); // Form ID değerini alıyoruz

        foreach ($cevaplar as $key => $value) {
            $item = new Answer();
            $item->form_id  = $formid; // Form ID
            $item->soru_id = $key; // Cevap dizisindeki key, soru ID'yi temsil ediyor
            $item->cevap = $value; // Cevap dizisindeki value, cevabı temsil ediyor
            $item->token = $token; // Token
            $item->save(); // Kaydetme işlemi
        }

    }
}
