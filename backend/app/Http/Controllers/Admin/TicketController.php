<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request) {
        $query = Ticket::with('user');
        if ($status = $request->status) $query->where('status',$status);
        if ($priority = $request->priority) $query->where('priority',$priority);
        $tickets = $query->latest()->paginate(25);
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket) {
        $ticket->load('user','replies.user','assignedTo');
        return view('admin.tickets.show', compact('ticket'));
    }
    public function reply(Request $request, Ticket $ticket) {
        $request->validate(['content'=>'required']);
        $ticket->replies()->create(['user_id'=>auth()->id(),'content'=>$request->content,'is_staff'=>true]);
        if ($request->status) $ticket->update(['status'=>$request->status]);
        if (!$ticket->first_response_at) $ticket->update(['first_response_at'=>now()]);
        return redirect()->back()->with('success','Reply sent.');
    }
    public function update(Request $request, Ticket $ticket) {
        $ticket->update($request->only(['status','priority','assigned_to']));
        return redirect()->back()->with('success','Ticket updated.');
    }
}
