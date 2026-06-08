<x-admin-layout title="Dashboard">

<div class="stats-grid">
  <div class="stat-card">
    <div class="label">Total Users</div>
    <div class="value">{{ number_format($stats['users']) }}</div>
  </div>
  <div class="stat-card">
    <div class="label">New Leads</div>
    <div class="value" style="color:#0B4F6C;">{{ $stats['new_leads'] }}</div>
  </div>
  <div class="stat-card">
    <div class="label">Open Tickets</div>
    <div class="value" style="color:#D97706;">{{ $stats['open_tickets'] }}</div>
  </div>
  <div class="stat-card">
    <div class="label">Subscribers</div>
    <div class="value" style="color:#15803D;">{{ number_format($stats['subscribers']) }}</div>
  </div>
  <div class="stat-card">
    <div class="label">Campaigns</div>
    <div class="value">{{ $stats['campaigns'] }}</div>
  </div>
  <div class="stat-card">
    <div class="label">Published Posts</div>
    <div class="value">{{ $stats['posts'] }}</div>
  </div>
</div>

@if($campaignStats && $campaignStats->sent)
<div class="card" style="margin-bottom:24px;">
  <div style="font-size:14px;font-weight:700;color:var(--dark);margin-bottom:16px;">Email Campaign Overview</div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
    <div><div style="font-size:24px;font-weight:700;color:var(--dark);">{{ number_format($campaignStats->sent) }}</div><div style="font-size:12px;color:var(--gray-500);margin-top:4px;">Emails Sent</div></div>
    <div><div style="font-size:24px;font-weight:700;color:#0B4F6C;">{{ $campaignStats->sent ? round(($campaignStats->opened/$campaignStats->sent)*100,1) : 0 }}%</div><div style="font-size:12px;color:var(--gray-500);margin-top:4px;">Open Rate</div></div>
    <div><div style="font-size:24px;font-weight:700;color:#15803D;">{{ $campaignStats->sent ? round(($campaignStats->clicked/$campaignStats->sent)*100,1) : 0 }}%</div><div style="font-size:12px;color:var(--gray-500);margin-top:4px;">Click Rate</div></div>
    <div><div style="font-size:24px;font-weight:700;color:var(--dark);">{{ number_format($campaignStats->opened) }}</div><div style="font-size:12px;color:var(--gray-500);margin-top:4px;">Total Opens</div></div>
  </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
  <div class="card">
    <div class="section-header">
      <div class="section-title">Recent Leads</div>
      <a href="{{ route('admin.leads.index') }}" class="btn btn-outline btn-sm">View All</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Name</th><th>Email</th><th>Service</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($recentLeads as $lead)
          <tr>
            <td><a href="{{ route('admin.leads.show',$lead) }}" style="color:var(--teal);text-decoration:none;font-weight:500;">{{ $lead->first_name }} {{ $lead->last_name }}</a></td>
            <td style="color:var(--gray-500);">{{ $lead->email }}</td>
            <td style="font-size:12px;color:var(--gray-500);">{{ $lead->service_interest ?? '—' }}</td>
            <td><span class="badge {{ $lead->status === 'new' ? 'badge-teal' : ($lead->status === 'won' ? 'badge-green' : 'badge-gray') }}">{{ ucfirst($lead->status) }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:var(--gray-400);padding:24px;">No leads yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="section-header">
      <div class="section-title">Recent Tickets</div>
      <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline btn-sm">View All</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Ticket</th><th>Subject</th><th>Priority</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($recentTickets as $ticket)
          <tr>
            <td><a href="{{ route('admin.tickets.show',$ticket) }}" style="color:var(--teal);text-decoration:none;font-weight:500;font-size:12px;">{{ $ticket->ticket_number }}</a></td>
            <td>{{ Str::limit($ticket->subject,30) }}</td>
            <td><span class="badge {{ $ticket->priority==='urgent'?'badge-red':($ticket->priority==='high'?'badge-yellow':'badge-gray') }}">{{ ucfirst($ticket->priority) }}</span></td>
            <td><span class="badge {{ $ticket->status==='open'?'badge-teal':($ticket->status==='resolved'?'badge-green':'badge-gray') }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:var(--gray-400);padding:24px;">No tickets yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

</x-admin-layout>
