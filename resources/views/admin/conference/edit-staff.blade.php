<x-admin-layout :title="'Edit Staff — '.$user->name">
<div style="padding:32px;max-width:600px;">

  <div style="margin-bottom:24px;">
    <div style="font-size:12px;color:#718096;margin-bottom:4px;">
      <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      <a href="{{ route('admin.conference.staff') }}" style="color:#3182ce;text-decoration:none;">Staff</a> /
    </div>
    <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">Edit Staff: {{ $user->name }}</h1>
  </div>

  @if($errors->any())
  <div style="background:#fff5f5;border:1px solid #fc8181;color:#c53030;padding:12px 16px;border-radius:6px;margin-bottom:20px;font-size:14px;">
    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
  </div>
  @endif

  <form method="POST" action="{{ route('admin.conference.update-staff', $user) }}"
    style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:32px;">
    @csrf @method('PUT')

    <div style="display:grid;gap:20px;">
      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Full Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" required
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
      </div>
      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Role</label>
        <select name="role" required
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;background:#fff;">
          <option value="front-desk-staff" @selected($user->hasRole('front-desk-staff'))>Front Desk Staff</option>
          <option value="lunch-staff" @selected($user->hasRole('lunch-staff'))>Lunch Staff</option>
        </select>
      </div>
      <div>
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:#4a5568;">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1" @checked($user->is_active)
            style="width:16px;height:16px;">
          Active Account
        </label>
      </div>
      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">New Password <span style="font-weight:400;color:#a0aec0;">(leave blank to keep current)</span></label>
        <input name="password" type="password" minlength="8"
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
      </div>
      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Confirm Password</label>
        <input name="password_confirmation" type="password" minlength="8"
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
      </div>
    </div>

    <div style="margin-top:28px;display:flex;gap:10px;">
      <button type="submit"
        style="padding:10px 24px;background:#3182ce;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px;font-weight:600;">
        Save Changes
      </button>
      <a href="{{ route('admin.conference.staff') }}"
        style="padding:10px 20px;background:#f7fafc;color:#4a5568;text-decoration:none;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
        Cancel
      </a>
    </div>
  </form>

</div>
</x-admin-layout>
