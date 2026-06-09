<x-admin-layout title="Users">
<div class="section-header">
  <div class="section-title">All Users</div>
  <form method="GET" style="display:flex;gap:8px;">
    <input name="search" class="form-input" placeholder="Search name or email..." value="{{ request('search') }}" style="width:220px;">
    <button type="submit" class="btn btn-outline">Search</button>
  </form>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Country</th><th>Roles</th><th>Status</th><th>Joined</th><th></th></tr></thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td><a href="{{ route('admin.users.show',$user) }}" style="font-weight:600;color:var(--teal);text-decoration:none;">{{ $user->name }}</a></td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->country ?? '—' }}</td>
          <td>@foreach($user->roles as $role)<span class="badge badge-teal" style="margin-right:4px;">{{ $role->name }}</span>@endforeach</td>
          <td><span class="badge {{ $user->is_active?'badge-green':'badge-red' }}">{{ $user->is_active?'Active':'Inactive' }}</span></td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $user->created_at->format('M j, Y') }}</td>
          <td style="white-space:nowrap;">
            <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-outline btn-sm">Edit</a>
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy',$user) }}" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete user?')">Delete</button></form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $users->appends(request()->query())->links() }}</div>
</div>
</x-admin-layout>
