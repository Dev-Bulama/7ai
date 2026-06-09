<x-admin-layout title="Email Campaigns">
<div class="section-header">
  <div class="section-title">All Campaigns</div>
  <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">+ New Campaign</a>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Type</th><th>Status</th><th>Sent</th><th>Open Rate</th><th>Click Rate</th><th>Scheduled</th><th></th></tr></thead>
      <tbody>
        @forelse($campaigns as $c)
        <tr>
          <td><a href="{{ route('admin.campaigns.show',$c) }}" style="font-weight:600;color:var(--teal);text-decoration:none;">{{ $c->name }}</a><br><span style="font-size:11px;color:var(--gray-400);">{{ $c->subject }}</span></td>
          <td><span class="badge badge-teal">{{ ucfirst($c->type) }}</span></td>
          <td><span class="badge {{ $c->status==='sent'?'badge-green':($c->status==='sending'?'badge-teal':($c->status==='scheduled'?'badge-yellow':'badge-gray')) }}">{{ ucfirst($c->status) }}</span></td>
          <td>{{ number_format($c->total_sent) }}</td>
          <td>{{ $c->total_sent ? round(($c->total_opened/$c->total_sent)*100,1).'%' : '—' }}</td>
          <td>{{ $c->total_sent ? round(($c->total_clicked/$c->total_sent)*100,1).'%' : '—' }}</td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $c->scheduled_at?->format('M j, Y H:i') ?? '—' }}</td>
          <td style="white-space:nowrap;">
            <a href="{{ route('admin.campaigns.edit',$c) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.campaigns.destroy',$c) }}" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button></form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--gray-400);padding:32px;">No campaigns yet. <a href="{{ route('admin.campaigns.create') }}" style="color:var(--teal);">Create one →</a></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $campaigns->links() }}</div>
</div>
</x-admin-layout>
