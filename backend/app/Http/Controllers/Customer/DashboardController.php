<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();
        $projects = $user->projects()->latest()->take(5)->get();
        $tickets = $user->tickets()->latest()->take(5)->get();
        $stats = [
            'projects' => $user->projects()->count(),
            'open_tickets' => $user->tickets()->whereIn('status',['open','in_progress','waiting'])->count(),
            'unpaid_invoices' => $user->invoices()->whereIn('status',['sent','overdue'])->count(),
            'total_spent' => $user->invoices()->where('status','paid')->sum('total'),
        ];
        return view('customer.dashboard', compact('user','projects','tickets','stats'));
    }
    public function projects() {
        $projects = auth()->user()->projects()->paginate(12);
        return view('customer.projects', compact('projects'));
    }
    public function invoices() {
        $invoices = auth()->user()->invoices()->paginate(20);
        return view('customer.invoices', compact('invoices'));
    }
}
