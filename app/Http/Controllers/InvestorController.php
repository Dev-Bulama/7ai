<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'company'          => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'investor_type'    => 'nullable|string|max:100',
            'investment_range' => 'nullable|string|max:100',
            'message'          => 'nullable|string|max:2000',
        ]);

        $notes = '';
        if ($request->investor_type)    $notes .= 'Investor Type: '    . $request->investor_type    . "\n";
        if ($request->investment_range) $notes .= 'Investment Range: ' . $request->investment_range . "\n";
        if ($request->message)          $notes .= 'Message: '          . $request->message;

        Lead::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'company'          => $request->company,
            'country'          => $request->country,
            'message'          => trim($notes),
            'service_interest' => 'investor',
            'source'           => 'website',
            'ip_address'       => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your interest! Our investor relations team will contact you within 48 hours.');
    }
}
