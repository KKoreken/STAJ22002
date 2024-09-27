<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Work;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Message;
use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Interest;
use Illuminate\Support\Facades\Storage;


class PanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        return view('panel.index');
    }
    public function getInterests(){
        $items  = Interest::all();
        $result = ['items'=>$items];
        return view('panel.ilgialanlari.index',$result);
    }
    public function FormSorulari(){
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
        return view('panel.forms.index',$result);
    }

    public function allTickets(){
        $tickets = Ticket::with(['labels', 'categories','user'])
            ->get();
        return view('panel.tickets.index',compact('tickets'));
    }
    public function detailTicket($id){
        echo $id;
    }
    public function answerTicket($id){
        $ticket = Ticket::where('uuid',$id)->first();
        return view('panel.tickets.answer',compact('ticket'));
    }

    public function answerTicketPost(Request $request){
        $user = Auth::user();
        $message = new Message();
        $message->message = $request->message;
        $message->ticket_id = $request->id;
        $message->user_id = $user->id;
        $result = $message->save();
        if ($result){
            $ticket = Ticket::find($request->id);
            $ticket->status = 'Cevaplandı';
            $ticket->save();
        }
        return $this->ticketHistory($ticket->uuid);
        //$messages = Message::with(['user','ticket'])->;
    }
    public function ticketHistory($id){
        $ticket = Ticket::where('uuid',$id)->first();
        $messages = Message::with(['user'])->where('ticket_id',$ticket->id)
            ->get();
        $creator = Ticket::with(['user'])->where('uuid',$id)->first();
        $result = ['messages'=>$messages,'creator'=>$creator,'firstmessage'=>$ticket->message];
        return view('panel.tickets.history',$result);
    }
    public function editTicket($uuid){
        $ticket = Ticket::where('uuid',$uuid)->first();
        $categories = Categories::all();
        $labels = Label::all();
        $result= ['categories'=>$categories,'labels'=>$labels,'ticket'=>$ticket];
        return view('panel.tickets.edit',$result);
    }
    public function editTicketPost(Request $request){
        $id = $request->id;
        DB::table('label_ticket')->where('ticket_id',$id)->delete();
        $ticket = Ticket::find($id);
        $ticket->status = $request->status;
        $ticket->is_resolved = $request->is_resolved;
        $ticket->is_locked = $request->is_locked;
        $ticket->priority = $request->priority;
        $ticket->save();
        DB::table('category_ticket')->where('ticket_id',$id)->update(['category_id'=>$request->category]);
        foreach ($request->labels as $l){
            DB::table('label_ticket')->insert([
                'ticket_id'=>$id,
                'label_id'=>$l,
            ]);
        }
        return $this->allTickets();
    }

    public function getCategories(){
        $categories = Categories::withCount('posts')->get();
        $result = ['categories'=>$categories];
        return view('panel.categories.index',$result);
    }

    // interest

    public function addInterest(){
        return view('panel.ilgialanlari.add');
    }
    public function addInterestPost(Request $request){
        $item = Interest::where('text',$request->text)->first();
        if(!$item){
            $logo = $request->file('logo');
            $logo = $logo->store('logo');
            $item = new Interest();
            $item->text = $request->text;
            $item->logo = $logo;
            $result = $item->save();
            $this->checkResult($result);
        }
        else{
            session()->flash('error', 'İşlem Başarısız! Zaten Var!');
        }
        return redirect()->route('getinterest');
    }
    public function editInterest($id){
        $item = Interest::find($id);
        return view('panel.ilgialanlari.edit',compact('item'));
    }
    public function editInterestPost(Request $request){

        $item = Interest::find($request->id);
        if($request->file('logo')){
            Storage::delete($item->logo);
            $logo = $request->file('logo');
            $logo = $logo->store('logo');
            $item->logo = $logo;
        }
        $item->text= $request->text;
        $result = $item->save();
        $this->checkResult($result);
        return redirect()->route( 'getinterest');
    }

    public function deleteInterest($id)
    {
        $result = Interest::destroy($id);
        $this->checkResult($result);
        return redirect()->route( 'getinterest');
    }

    public function getSocialMedias()
    {
        $items  = DB::table('sosyal_medya')->get();
        $result = ['items'=>$items];
        return view('panel.socialmedia.index',$result);
    }
    public function addSocialMedia()
    {
        return view('panel.socialmedia.add');
    }
    public function addSocialMediaPost(Request $request){
        dd($request->all());
    }
    // Ortak fonksiyonlar
    public function checkResult($result){
        if ($result){
            session()->flash('success', 'İşlem Başarılı!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
    }
}
