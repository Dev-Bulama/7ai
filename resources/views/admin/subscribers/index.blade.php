<x-admin-layout title="Subscribers">
<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">
  <div>
    <div class="section-header">
      <div class="section-title">All Subscribers ({{ $subscribers->total() }})</div>
      <form method="GET" style="display:flex;gap:8px;">
        <input name="search" class="form-input" placeholder="Search email..." value="{{ request('search') }}" style="width:180px;">
        <select name="status" class="form-input" style="width:130px;"><option value="">All</option><option value="subscribed" {{ request('status')==='subscribed'?'selected':'' }}>Subscribed</option><option value="unsubscribed">Unsubscribed</option></select>
        <button type="submit" class="btn btn-outline">Filter</button>
      </form>
    </div>
    <div class="card">
      <div class="table-wrap">
        <table>
          <thead><tr><th>Email</th><th>Name</th><th>Country</th><th>Lists</th><th>Status</th><th>Subscribed</th><th></th></tr></thead>
          <tbody>
            @forelse($subscribers as $sub)
            <tr>
              <td style="font-weight:500;">{{ $sub->email }}</td>
              <td>{{ trim($sub->first_name.' '.$sub->last_name) ?: '—' }}</td>
              <td>{{ $sub->country ?? '—' }}</td>
              <td style="font-size:12px;color:var(--gray-400);">{{ $sub->lists->pluck('name')->join(', ') ?: '—' }}</td>
              <td><span class="badge {{ $sub->status==='subscribed'?'badge-green':'badge-red' }}">{{ ucfirst($sub->status) }}</span></td>
              <td style="font-size:12px;color:var(--gray-400);">{{ $sub->subscribed_at->format('M j, Y') }}</td>
              <td><form method="POST" action="{{ route('admin.subscribers.destroy',$sub) }}">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove?')">Remove</button></form></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--gray-400);padding:24px;">No subscribers yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="pagination">{{ $subscribers->appends(request()->query())->links() }}</div>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:16px;">
      <div class="section-title" style="margin-bottom:16px;">Add Subscriber</div>
      <form method="POST" action="{{ route('admin.subscribers.store') }}">@csrf
        <div class="form-group"><label class="form-label">Email *</label><input name="email" type="email" class="form-input" required></div>
        <div class="form-group"><label class="form-label">First Name</label><input name="first_name" class="form-input"></div>
        <div class="form-group"><label class="form-label">List</label>
          <select name="subscriber_list_id" class="form-input"><option value="">— None —</option>@foreach($lists as $l)<option value="{{ $l->id }}">{{ $l->name }} ({{ $l->subscriber_count }})</option>@endforeach</select>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Add Subscriber</button>
      </form>
    </div>
    <div class="card">
      <div class="section-title" style="margin-bottom:16px;">Lists</div>
      @foreach($lists as $list)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray-100);">
        <div><div style="font-size:13px;font-weight:500;">{{ $list->name }}</div><div style="font-size:11px;color:var(--gray-400);">{{ $list->subscribers_count }} subscribers</div></div>
      </div>
      @endforeach
      <form method="POST" action="{{ route('admin.subscriber-lists.store') }}" style="margin-top:16px;">@csrf
        <div class="form-group"><input name="name" class="form-input" placeholder="New list name..." required></div>
        <button type="submit" class="btn btn-outline" style="width:100%;">Create List</button>
      </form>
    </div>
  </div>
</div>
</x-admin-layout>
