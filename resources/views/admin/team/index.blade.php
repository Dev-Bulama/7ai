<x-admin-layout title="Team Members">
<div class="section-header">
  <span class="section-title">Team Members</span>
  <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">+ Add Member</a>
</div>

@if($members->isEmpty())
<div class="card" style="text-align:center;padding:60px;color:var(--gray-500);">
  <div style="font-size:40px;margin-bottom:12px;">👥</div>
  <div style="font-size:15px;font-weight:600;margin-bottom:8px;">No team members yet</div>
  <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">Add first member</a>
</div>
@else
<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Name</th>
          <th>Title</th>
          <th>Featured</th>
          <th>Order</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $member)
        <tr style="{{ $member->trashed() ? 'opacity:0.5;' : '' }}">
          <td>
            @if($member->photo_url)
            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
            @else
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(11,79,108,0.15);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0b4f6c;">{{ $member->initials }}</div>
            @endif
          </td>
          <td>
            <div style="font-weight:600;">{{ $member->name }}</div>
            @if($member->trashed())<span class="badge badge-gray">Deleted</span>@endif
          </td>
          <td style="font-size:13px;color:var(--gray-600);">{{ $member->job_title ?? '—' }}</td>
          <td>@if($member->is_featured)<span class="badge badge-teal">Featured</span>@else<span style="color:var(--gray-400);">—</span>@endif</td>
          <td style="font-size:13px;">{{ $member->sort_order }}</td>
          <td><span class="badge {{ $member->is_active ? 'badge-green' : 'badge-gray' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            @if(!$member->trashed())
            <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.team.destroy', $member) }}" style="display:inline;" onsubmit="return confirm('Delete {{ $member->name }}?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $members->links() }}
</div>
@endif
</x-admin-layout>
