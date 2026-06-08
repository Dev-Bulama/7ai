<x-customer-layout title="Dashboard">
<style>
  .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:32px;}
  .stat-card{background:#fff;border-radius:12px;padding:24px;border:1px solid #e5e7eb;}
  .stat-label{font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;}
  .stat-val{font-size:28px;font-weight:700;color:#0d1b2a;}
  .stat-sub{font-size:12px;color:#9ca3af;margin-top:4px;}
  .section-card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:24px;}
  .card-head{padding:20px 24px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-head a{font-size:13px;color:#0B4F6C;text-decoration:none;font-weight:500;}
  table{width:100%;border-collapse:collapse;}
  th{font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;padding:12px 24px;text-align:left;background:#f9fafb;}
  td{padding:14px 24px;font-size:14px;color:#374151;border-top:1px solid #f3f4f6;}
  .badge{display:inline-flex;align-items:center;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-red{background:#fee2e2;color:#991b1b;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .empty{padding:48px;text-align:center;color:#9ca3af;font-size:14px;}
  .welcome-banner{background:linear-gradient(135deg,#0B4F6C 0%,#093d56 100%);border-radius:16px;padding:32px;margin-bottom:32px;color:#fff;}
  .welcome-banner h2{font-size:22px;font-weight:700;margin-bottom:8px;}
  .welcome-banner p{font-size:14px;color:rgba(255,255,255,0.75);}
</style>

<div class="welcome-banner">
  <h2>Welcome back, {{ auth()->user()->name }}!</h2>
  <p>Here's a summary of your account and active projects.</p>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Active Projects</div>
    <div class="stat-val">{{ $stats['projects'] }}</div>
    <div class="stat-sub">Total projects</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Open Tickets</div>
    <div class="stat-val">{{ $stats['open_tickets'] }}</div>
    <div class="stat-sub">Awaiting response</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Unpaid Invoices</div>
    <div class="stat-val">{{ $stats['unpaid_invoices'] }}</div>
    <div class="stat-sub">Pending payment</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Spent</div>
    <div class="stat-val">${{ number_format($stats['total_spent'], 0) }}</div>
    <div class="stat-sub">Lifetime value</div>
  </div>
</div>

<div class="section-card">
  <div class="card-head">
    <h3>Recent Projects</h3>
    <a href="{{ route('customer.projects') }}">View all →</a>
  </div>
  @if($projects->count())
  <table>
    <thead><tr><th>Project</th><th>Type</th><th>Status</th><th>Start Date</th></tr></thead>
    <tbody>
    @foreach($projects as $p)
    <tr>
      <td style="font-weight:500;">{{ $p->name }}</td>
      <td>{{ $p->type ?? '—' }}</td>
      <td>
        @php $sc=['planning'=>'badge-blue','in_progress'=>'badge-yellow','completed'=>'badge-green','on_hold'=>'badge-gray','installation'=>'badge-yellow'][$p->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$p->status)) }}</span>
      </td>
      <td>{{ $p->start_date ? \Carbon\Carbon::parse($p->start_date)->format('M d, Y') : '—' }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @else
    <div class="empty">No projects yet. Contact us to get started.</div>
  @endif
</div>

<div class="section-card">
  <div class="card-head">
    <h3>Recent Tickets</h3>
    <a href="{{ route('customer.tickets.index') }}">View all →</a>
  </div>
  @if($tickets->count())
  <table>
    <thead><tr><th>#</th><th>Subject</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
    @foreach($tickets as $t)
    <tr>
      <td style="font-family:monospace;font-size:12px;color:#9ca3af;">{{ $t->ticket_number }}</td>
      <td><a href="{{ route('customer.tickets.show',$t) }}" style="color:#0B4F6C;text-decoration:none;font-weight:500;">{{ $t->subject }}</a></td>
      <td>
        @php $pc=['low'=>'badge-gray','medium'=>'badge-blue','high'=>'badge-yellow','urgent'=>'badge-red'][$t->priority] ?? 'badge-gray' @endphp
        <span class="badge {{ $pc }}">{{ ucfirst($t->priority) }}</span>
      </td>
      <td>
        @php $sc=['open'=>'badge-blue','in_progress'=>'badge-yellow','waiting'=>'badge-yellow','resolved'=>'badge-green','closed'=>'badge-gray'][$t->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span>
      </td>
      <td style="color:#9ca3af;font-size:13px;">{{ $t->created_at->diffForHumans() }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @else
    <div class="empty">No support tickets yet.</div>
  @endif
</div>
</x-customer-layout>
