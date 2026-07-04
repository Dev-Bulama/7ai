<x-admin-layout title="Conference Staff">
<div style="padding:32px;max-width:900px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
      <div style="font-size:12px;color:#718096;margin-bottom:4px;">
        <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      </div>
      <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">Staff Accounts</h1>
    </div>
    <a href="{{ route('admin.conference.create-staff') }}"
      style="padding:10px 20px;background:#3182ce;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;font-weight:600;">
      + Add Staff
    </a>
  </div>

  @if(session('success'))
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:12px 16px;border-radius:6px;margin-bottom:20px;font-size:14px;">
    {{ session('success') }}
  </div>
  @endif

  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr style="background:#f7fafc;">
          <th style="padding:12px 16px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Name</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Email</th>
          <th style="padding:12px 16px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Role</th>
          <th style="padding:12px 16px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Status</th>
          <th style="padding:12px 16px;text-align:right;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($staff as $member)
        <tr style="border-bottom:1px solid #f0f4f8;">
          <td style="padding:12px 16px;font-weight:500;color:#1a202c;">{{ $member->name }}</td>
          <td style="padding:12px 16px;color:#4a5568;">{{ $member->email }}</td>
          <td style="padding:12px 16px;">
            @php $role = $member->roles->first(); @endphp
            @if($role)
            <span style="background:{{ $role->name === 'front-desk-staff' ? '#ebf8ff' : '#fffaf0' }};
                         color:{{ $role->name === 'front-desk-staff' ? '#2b6cb0' : '#c05621' }};
                         padding:2px 10px;border-radius:4px;font-size:12px;font-weight:600;text-transform:capitalize;">
              {{ str_replace('-', ' ', $role->name) }}
            </span>
            @endif
          </td>
          <td style="padding:12px 16px;text-align:center;">
            @if($member->is_active)
              <span style="background:#f0fff4;color:#276749;padding:2px 8px;border-radius:4px;font-size:12px;">Active</span>
            @else
              <span style="background:#fff5f5;color:#c53030;padding:2px 8px;border-radius:4px;font-size:12px;">Inactive</span>
            @endif
          </td>
          <td style="padding:12px 16px;text-align:right;">
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.conference.edit-staff', $member) }}"
                style="padding:5px 12px;background:#4a5568;color:#fff;text-decoration:none;border-radius:3px;font-size:12px;">
                Edit
              </a>
              <form method="POST" action="{{ route('admin.conference.destroy-staff', $member) }}" style="margin:0;"
                onsubmit="return confirm('Remove this staff account?');">
                @csrf @method('DELETE')
                <button type="submit"
                  style="padding:5px 12px;background:#fc8181;color:#fff;border:none;border-radius:3px;cursor:pointer;font-size:12px;">
                  Remove
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="padding:40px;text-align:center;color:#a0aec0;">No staff accounts yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
</x-admin-layout>
