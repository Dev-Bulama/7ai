<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\SubscriberList;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request) {
        $query = Subscriber::query();
        if ($s = $request->search) $query->where('email','like',"%$s%");
        if ($status = $request->status) $query->where('status',$status);
        $subscribers = $query->latest()->paginate(25);
        $lists = SubscriberList::withCount('subscribers')->get();
        return view('admin.subscribers.index', compact('subscribers','lists'));
    }

    public function store(Request $request) {
        $data = $request->validate(['email'=>'required|email|unique:subscribers','first_name'=>'nullable','last_name'=>'nullable','country'=>'nullable','source'=>'nullable']);
        $data['subscribed_at'] = now();
        $sub = Subscriber::create($data);
        if ($listId = $request->subscriber_list_id) $sub->lists()->attach($listId);
        return redirect()->back()->with('success','Subscriber added.');
    }

    public function destroy(Subscriber $subscriber) {
        $subscriber->delete();
        return redirect()->back()->with('success','Subscriber removed.');
    }

    public function storeList(Request $request) {
        $data = $request->validate(['name'=>'required','description'=>'nullable']);
        SubscriberList::create($data);
        return redirect()->back()->with('success','List created.');
    }
}
