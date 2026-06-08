<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadCaptureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'company'    => 'nullable|string|max:100',
            'country'    => 'nullable|string|max:100',
            'message'    => 'nullable|string|max:2000',
            'service_interest' => 'nullable|string|max:100',
        ]);

        Lead::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'company'          => $request->company,
            'country'          => $request->country,
            'message'          => $request->message,
            'service_interest' => $request->service_interest,
            'source'           => 'website',
            'ip_address'       => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Thank you! We will be in touch shortly.');
    }
}
