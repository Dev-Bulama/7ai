<x-admin-layout title="Leads & CRM">
<div class="section-header">
  <div class="section-title">All Leads</div>
  <div style="display:flex;gap:10px;">
    <form method="GET" style="display:flex;gap:8px;">
      <input name="search" class="form-input" placeholder="Search..." value="{{ request('search') }}" style="width:200px;">
      <select name="status" class="form-input" style="width:140px;"><option value="">All Status</option>@foreach(['new','contacted','qualified','proposal','won','lost'] as $s)<option {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>@endforeach</select>
      <button type="submit" class="btn btn-outline">Filter</button>
    </form>
  </div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Country</th><th>Service Interest</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
        @forelse($leads as $lead)
        <tr>
          <td><a href="{{ route('admin.leads.show',$lead) }}" style="font-weight:600;color:var(--teal);text-decoration:none;">{{ $lead->first_name }} {{ $lead->last_name }}</a><br><span style="font-size:11px;color:var(--gray-400);">{{ $lead->company }}</span></td>
          <td>{{ $lead->email }}</td>
          <td>{{ $lead->country ?? '—' }}</td>
          <td style="font-size:13px;">{{ $lead->service_interest ?? '—' }}</td>
          <td>
            <form method="POST" action="{{ route('admin.leads.update',$lead) }}" style="display:inline;">@csrf @method('PUT')
              <select name="status" class="form-input" style="width:110px;padding:4px 8px;font-size:12px;" onchange="this.form.submit()">
                @foreach(['new','contacted','qualified','proposal','won','lost'] as $s)
                <option value="{{ $s }}" {{ $lead->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
              </select>
            </form>
          </td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $lead->created_at->format('M j, Y') }}</td>
          <td>
            <a href="{{ route('admin.leads.show',$lead) }}" class="btn btn-outline btn-sm">View</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--gray-400);padding:32px;">No leads yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $leads->appends(request()->query())->links() }}</div>
</div>
</x-admin-layout>
