<?php

namespace App\Http\Controllers;

use Coderflex\LaravelTicket\Models\Message;
use Coderflex\LaravelTicket\Models\Ticket;
use Coderflex\LaravelTicket\Models\Categories;
use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketController extends BaseController
{
    public function alltickets(){
        $posts = Ticket::first();
        return view('livewire.tickets', ['posts' => $posts]);
    }
    public function myTickets(){
        $user = Auth::user();
        $tickets = Ticket::with(['labels', 'categories'])
            ->where('user_id', $user->id)
            ->get();
        return view('user.ticket.index',compact('tickets'));
    }
    public function createNewTicket(){
        $categories = Categories::all();
        $labels = Label::all();
        $result= ['categories'=>$categories,'labels'=>$labels];
        return view('user.ticket.add',$result);
    }
    public function  showTicket($id){
        $ticket = Ticket::where('uuid',$id);
        dd($ticket);
    }
    public function editTicket($id){
        $ticket = Ticket::with(['labels', 'categories'])
            ->where('uuid', $id)
            ->first();
        $categories = Categories::all();
        $labels = Label::all();
        $result= ['categories'=>$categories,'labels'=>$labels,'ticket'=>$ticket];
        return view('user.ticket.edit',$result);
    }
    public function editTicketPost(Request $request){
        $id = $request->id;
        DB::table('label_ticket')->where('ticket_id',$id)->delete();
        $ticket = Ticket::find($id);
        $ticket->title = $request->title;
        $ticket->message = $request->message;
        $ticket->priority = $request->priority;
        $ticket->save();
        DB::table('category_ticket')->where('ticket_id',$id)->update(['category_id'=>$request->category]);
        foreach ($request->labels as $l){
            DB::table('label_ticket')->insert([
                'ticket_id'=>$id,
                'label_id'=>$l,
            ]);
        }
        return $this->myTickets();
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $ticket = new Ticket();
        $ticket->uuid=(string) Str::uuid();
        $ticket->user_id=$user->id;
        $ticket->title=$request->title;
        $ticket->message=$request->message;
        $ticket->priority=$request->priority;
        $ticket->status = 'Okunmadı';
        $ticket->is_resolved = 0;
        $ticket->is_locked = 0;
        $ticket->assigned_to = 0;
        $ticket->save();
        $this->storeTicketCategories($ticket->id,$request->category);
        $this->storeTicketLabels($ticket->id,$request->labels);
        return redirect(route('ticket.show'))
            ->with('success', __('Your Ticket Was created successfully.'));
    }
    public function storeTicketCategories($ticket,$category){
        DB::table('category_ticket')->insert([
            'category_id'=>$category,
            'ticket_id'=>$ticket
        ]);
    }
    public function storeTicketLabels($ticket,$labels){
        foreach ($labels as $label){
            DB::table('label_ticket')->insert([
                'label_id'=>$label,
                'ticket_id'=>$ticket
            ]);
        }
    }
    public function createLabel($ticket)
    {
        $label = new Label();
        $label->name;
        $label->slug;
        $label->is_visible;
        $label->save();
        $label->tickets()->attach($ticket);
    }

    public function createCategory($ticket)
    {
        $category = new Categories();
        $category->name;
        $category->slug;
        $category->is_visible;
        $category->save();
    }
    public function deleteTicket($id){
        $ticket = Ticket::where('uuid',$id)->first();
        if ($ticket){
            $ticket->deleteQuietly();
            DB::table('category_ticket')->where('ticket_id',$id)->delete();
            DB::table('label_ticket')->where('ticket_id',$id)->delete();
        }

        return $this->myTickets();
    }
    public function myTicketHistory($uuid){
        $user = Auth::user();
        $ticket = Ticket::where('uuid',$uuid)->first();
        $messages = Message::with(['user'])->where('ticket_id',$ticket->id)
            ->get();
        $creator = Ticket::with(['user'])->where('uuid',$uuid)->first();
        $result = ['messages'=>$messages,'creator'=>$creator,'firstmessage'=>$ticket->message,'user'=>$user];
        return view('user.ticket.show',$result);
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
        return $this->myTicketHistory($ticket->uuid);
        //$messages = Message::with(['user','ticket'])->;
    }
}
