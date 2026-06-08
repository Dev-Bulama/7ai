<x-admin-layout title="User Details">
<style>
  .back{font-size:13px;color:#6b7280;text-decoration:none;display:inline-block;margin-bottom:20px;}
  .layout{display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:24px;}
  .user-hero{display:flex;align-items:center;gap:16px;padding:24px;border-bottom:1px solid #f3f4f6;}
  .user-avatar{width:56px;height:56px;background:#0B4F6C;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;font-weight:700;}
  .user-name{font-size:18px;font-weight:700;color:#0d1b2a;}
  .user-email{font-size:14px;color:#9ca3af;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .detail-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f9fafb;font-size:13px;}
  .detail-row:last-child{border-bottom:none;}
  .detail-label{color:#9ca3af;}
  .detail-val{color:#0d1b2a;font-weight:500;text-align:right;}
  table{width:100%;border-collapse:collapse;}
  th{font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;padding:10px 20px;text-align:left;background:#f9fafb;}
  td{padding:12px 20px;font-size:13px;color:#374151;border-top:1px solid #f3f4f6;}
  .btn-sm{padding:7px 14px;background:#0B4F6C;color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-block;}
</style>

<a href="{{ route('admin.users.index') }}" class="back">← Back to Users</a>

<div class="layout">
  <div>
    <div class="card">
      <div class="user-hero">
        <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}</div>
        <div>
          <div class="user-name">{{ $user->name }}</div>
          <div class="user-email">{{ $user->email }}</div>
          <div style="margin-top:6px;display:flex;gap:6px;flex-wrap:wrap;">
            @foreach($user->roles as $role)
              <span class="badge badge-blue">{{ $role->name }}</span>
            @endforeach
            @if(!$user->is_active) <span class="badge badge-gray">Inactive</span> @endif
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="detail-row"><span class="detail-label">Phone</span><span class="detail-val">{{ $user->phone ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Company</span><span class="detail-val">{{ $user->company ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Country</span><span class="detail-val">{{ $user->country ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Member Since</span><span class="detail-val">{{ $user->created_at->format('M d, Y') }}</span></div>
        <div class="detail-row"><span class="detail-label">Last Login</span><span class="detail-val">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never' }}</span></div>
      </div>
    </div>

    @if($user->projects->count())
    <div class="card">
      <div class="card-head"><h3>Projects ({{ $user->projects->count() }})</h3></div>
      <table>
        <thead><tr><th>Name</th><th>Status</th><th>Budget</th></tr></thead>
        <tbody>
        @foreach($user->projects->take(5) as $p)
        <tr>
          <td style="font-weight:500;">{{ $p->name }}</td>
          <td><span class="badge badge-blue">{{ ucfirst(str_replace('_',' ',$p->status)) }}</span></td>
          <td>{{ $p->budget ? '$'.number_format($p->budget,0) : '—' }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Actions</h3>
      <a href="{{ route('admin.users.edit', $user) }}" class="btn-sm">Edit User</a>
    </div>
    <div class="card-body">
      <div class="detail-row"><span class="detail-label">Tickets</span><span class="detail-val">{{ $user->tickets->count() }}</span></div>
      <div class="detail-row"><span class="detail-label">Invoices</span><span class="detail-val">{{ $user->invoices->count() }}</span></div>
      <div class="detail-row"><span class="detail-label">2FA Enabled</span><span class="detail-val">{{ $user->two_factor_enabled ? 'Yes' : 'No' }}</span></div>
      <div class="detail-row"><span class="detail-label">Status</span>
        <span class="detail-val">
          <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-gray' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
        </span>
      </div>
    </div>
  </div>
</div>
</x-admin-layout>
