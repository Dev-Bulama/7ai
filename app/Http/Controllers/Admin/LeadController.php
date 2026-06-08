<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query();
        if ($s = $request->search) $query->where('email','like',"%$s%")->orWhere('first_name','like',"%$s%");
        if ($status = $request->status) $query->where('status', $status);
        $leads = $query->latest()->paginate(25);
        return view('admin.leads.index', compact('leads'));
    }

    public function show(Lead $lead) { return view('admin.leads.show', compact('lead')); }

    public function update(Request $request, Lead $lead)
    {
        $lead->update($request->only(['status','assigned_to','notes']));
        return redirect()->back()->with('success', 'Lead updated.');
    }

    public function destroy(Lead $lead) {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success','Lead deleted.');
    }
}
