<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lead;
use App\Models\Ticket;
use App\Models\Campaign;
use App\Models\Subscriber;
use App\Models\Post;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'       => User::count(),
            'leads'       => Lead::count(),
            'new_leads'   => Lead::where('status', 'new')->count(),
            'open_tickets'=> Ticket::whereNotIn('status', ['closed','resolved'])->count(),
            'campaigns'   => Campaign::count(),
            'subscribers' => Subscriber::where('status', 'subscribed')->count(),
            'posts'       => Post::where('status', 'published')->count(),
        ];

        $recentLeads   = Lead::latest()->take(8)->get();
        $recentTickets = Ticket::with('user')->latest()->take(8)->get();

        $campaignStats = Campaign::where('status', 'sent')
            ->selectRaw('SUM(total_sent) as sent, SUM(total_opened) as opened, SUM(total_clicked) as clicked')
            ->first();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentTickets', 'campaignStats'));
    }
}
