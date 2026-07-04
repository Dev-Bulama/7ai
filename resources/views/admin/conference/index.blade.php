<x-admin-layout title="Conference Management">
<div style="padding:32px;max-width:1100px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
    <div>
      <h1 style="font-size:22px;font-weight:700;color:#1a202c;margin:0;">Conference Management</h1>
      <p style="font-size:14px;color:#718096;margin:4px 0 0;">Manage conference forms, participants, and staff.</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a href="{{ route('admin.conference.staff') }}"
         style="padding:10px 18px;background:#4a5568;color:#fff;text-decoration:none;border-radius:6px;font-size:13px;font-weight:600;">
        👥 Staff Accounts
      </a>
    </div>
  </div>

  @if(session('success'))
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:12px 16px;border-radius:6px;margin-bottom:20px;font-size:14px;">
    {{ session('success') }}
  </div>
  @endif

  @if($forms->isEmpty())
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:60px;text-align:center;color:#718096;">
    <div style="font-size:48px;margin-bottom:16px;">🎪</div>
    <h3 style="font-size:18px;color:#4a5568;margin:0 0 8px;">No Conference Forms Yet</h3>
    <p style="font-size:14px;margin:0 0 20px;">Enable conference mode on any form to start managing participants.</p>
    <a href="{{ route('admin.forms.index') }}"
       style="padding:10px 20px;background:#3182ce;color:#fff;text-decoration:none;border-radius:6px;font-size:13px;font-weight:600;">
      Go to Form Builder
    </a>
  </div>
  @else
  <div style="display:grid;gap:16px;">
    @foreach($forms as $form)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:24px;display:flex;align-items:center;justify-content:space-between;">
      <div>
        <h3 style="font-size:16px;font-weight:700;color:#1a202c;margin:0 0 4px;">{{ $form->name }}</h3>
        <div style="font-size:13px;color:#718096;">
          <span style="background:#ebf8ff;color:#2b6cb0;padding:2px 8px;border-radius:4px;margin-right:8px;">{{ $form->submissions_count }} registrations</span>
          @if($form->public_path)
          <span>{{ $form->public_path }}</span>
          @endif
        </div>
      </div>
      <div style="display:flex;gap:8px;">
        <a href="{{ route('admin.conference.participants', $form) }}"
           style="padding:8px 16px;background:#3182ce;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;font-weight:600;">
          👥 Participants
        </a>
        <a href="{{ route('admin.conference.settings', $form) }}"
           style="padding:8px 16px;background:#4a5568;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
          ⚙ Settings
        </a>
        <a href="{{ route('admin.conference.scan-logs', $form) }}"
           style="padding:8px 16px;background:#744210;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
          📋 Logs
        </a>
      </div>
    </div>
    @endforeach
  </div>
  @endif

</div>
</x-admin-layout>
