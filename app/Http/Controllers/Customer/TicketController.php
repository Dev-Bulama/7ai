<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index() {
        $tickets = auth()->user()->tickets()->latest()->paginate(15);
        return view('customer.tickets.index', compact('tickets'));
    }
    public function create() { return view('customer.tickets.create'); }
    public function store(Request $request) {
        $data = $request->validate(['subject'=>'required','description'=>'required','priority'=>'required','category'=>'nullable']);
        $data['user_id'] = auth()->id();
        Ticket::create($data);
        return redirect()->route('customer.tickets.index')->with('success','Ticket submitted.');
    }
    public function show(Ticket $ticket) {
        abort_if($ticket->user_id !== auth()->id(), 403);
        $ticket->load('replies.user');
        return view('customer.tickets.show', compact('ticket'));
    }
    public function reply(Request $request, Ticket $ticket) {
        abort_if($ticket->user_id !== auth()->id(), 403);
        $request->validate(['content'=>'required']);
        $ticket->replies()->create(['user_id'=>auth()->id(),'content'=>$request->content]);
        return redirect()->back()->with('success','Reply sent.');
    }
}
