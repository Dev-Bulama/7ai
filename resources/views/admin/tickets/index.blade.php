<x-admin-layout title="Support Tickets">
<div class="section-header">
  <div class="section-title">All Tickets</div>
  <form method="GET" style="display:flex;gap:8px;">
    <select name="status" class="form-input" style="width:140px;"><option value="">All Status</option>@foreach(['open','in_progress','waiting','resolved','closed'] as $s)<option {{ request('status')===$s?'selected':'' }} value="{{ $s }}">{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
    <select name="priority" class="form-input" style="width:120px;"><option value="">All Priority</option>@foreach(['low','medium','high','urgent'] as $p)<option {{ request('priority')===$p?'selected':'' }}>{{ ucfirst($p) }}</option>@endforeach</select>
    <button type="submit" class="btn btn-outline">Filter</button>
  </form>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Ticket #</th><th>Subject</th><th>User</th><th>Priority</th><th>Status</th><th>Created</th><th></th></tr></thead>
      <tbody>
        @forelse($tickets as $ticket)
        <tr>
          <td><span style="font-family:monospace;font-size:12px;color:var(--gray-500);">{{ $ticket->ticket_number }}</span></td>
          <td><a href="{{ route('admin.tickets.show',$ticket) }}" style="font-weight:500;color:var(--teal);text-decoration:none;">{{ $ticket->subject }}</a></td>
          <td>{{ $ticket->user?->name ?? $ticket->guest_name ?? '—' }}</td>
          <td><span class="badge {{ $ticket->priority==='urgent'?'badge-red':($ticket->priority==='high'?'badge-yellow':($ticket->priority==='medium'?'badge-teal':'badge-gray')) }}">{{ ucfirst($ticket->priority) }}</span></td>
          <td><span class="badge {{ $ticket->status==='open'?'badge-teal':($ticket->status==='resolved'?'badge-green':'badge-gray') }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $ticket->created_at->format('M j, Y') }}</td>
          <td><a href="{{ route('admin.tickets.show',$ticket) }}" class="btn btn-outline btn-sm">View</a></td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--gray-400);padding:32px;">No tickets yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $tickets->appends(request()->query())->links('pagination::simple-default') }}</div>
</div>
</x-admin-layout>
