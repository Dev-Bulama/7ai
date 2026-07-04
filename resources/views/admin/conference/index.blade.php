<x-admin-layout title="Conference Management">
<div style="padding:32px;max-width:1200px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <div>
      <h1 style="font-size:22px;font-weight:700;color:#1a202c;margin:0;">Conference Management</h1>
      <p style="font-size:14px;color:#718096;margin:4px 0 0;">Manage conference forms, participants, and staff.</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="{{ route('admin.conference.staff') }}"
         style="padding:10px 18px;background:#4a5568;color:#fff;text-decoration:none;border-radius:6px;font-size:13px;font-weight:600;">
        👥 Staff Accounts
      </a>
      <a href="{{ route('admin.forms.index') }}"
         style="padding:10px 18px;background:#3182ce;color:#fff;text-decoration:none;border-radius:6px;font-size:13px;font-weight:600;">
        + Enable Conference on Form
      </a>
    </div>
  </div>

  @if(session('success'))
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:12px 16px;border-radius:6px;margin-bottom:20px;font-size:14px;">
    ✓ {{ session('success') }}
  </div>
  @endif

  {{-- Global Stats --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:28px;">
    @php
      $pct = $globalStats['total_registrations'] > 0
          ? round(($globalStats['total_checked_in'] / $globalStats['total_registrations']) * 100)
          : 0;
    @endphp
    @foreach([
      ['Total Registered',  $globalStats['total_registrations'], '#3182ce'],
      ['Checked In',        $globalStats['total_checked_in'],    '#276749'],
      ['Pending Check-In',  $globalStats['total_registrations'] - $globalStats['total_checked_in'], '#c05621'],
      ['Lunch Collected',   $globalStats['total_lunch'],         '#d69e2e'],
      ['Front Desk Staff',  $globalStats['front_desk_staff'],    '#553c9a'],
      ['Lunch Staff',       $globalStats['lunch_staff'],         '#b7791f'],
    ] as [$label, $value, $color])
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;text-align:center;">
      <div style="font-size:26px;font-weight:800;color:{{ $color }};">{{ $value }}</div>
      <div style="font-size:11px;color:#718096;margin-top:4px;text-transform:uppercase;letter-spacing:0.06em;">{{ $label }}</div>
    </div>
    @endforeach
  </div>

  {{-- Attendance progress bar --}}
  @if($globalStats['total_registrations'] > 0)
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:24px;">
    <div style="display:flex;justify-content:space-between;font-size:13px;color:#4a5568;margin-bottom:8px;">
      <span>Attendance Rate</span>
      <span style="font-weight:700;">{{ $pct }}%</span>
    </div>
    <div style="background:#e2e8f0;border-radius:4px;height:8px;overflow:hidden;">
      <div style="background:#276749;height:100%;width:{{ $pct }}%;transition:width 0.3s;border-radius:4px;"></div>
    </div>
  </div>
  @endif

  @if($forms->isEmpty())
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:60px;text-align:center;color:#718096;">
    <div style="font-size:48px;margin-bottom:16px;">🎪</div>
    <h3 style="font-size:18px;color:#4a5568;margin:0 0 8px;">No Conference Forms Yet</h3>
    <p style="font-size:14px;margin:0 0 20px;">Go to Form Builder, open a form, and enable Conference Mode to get started.</p>
    <a href="{{ route('admin.forms.index') }}"
       style="padding:10px 20px;background:#3182ce;color:#fff;text-decoration:none;border-radius:6px;font-size:13px;font-weight:600;">
      Go to Form Builder
    </a>
  </div>
  @else

  {{-- Conference Forms --}}
  <div style="display:grid;gap:14px;margin-bottom:32px;">
    @foreach($forms as $form)
    @php
      $checkedIn = \App\Models\FormSubmission::where('form_id',$form->id)->where('attendance_verified',true)->count();
      $total     = $form->submissions_count;
      $fp        = $total > 0 ? round(($checkedIn/$total)*100) : 0;
    @endphp
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:20px;">
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="flex:1;min-width:200px;">
          <h3 style="font-size:15px;font-weight:700;color:#1a202c;margin:0 0 4px;">{{ $form->name }}</h3>
          <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <span style="background:#ebf8ff;color:#2b6cb0;padding:2px 8px;border-radius:4px;font-size:12px;">{{ $total }} registered</span>
            <span style="background:#f0fff4;color:#276749;padding:2px 8px;border-radius:4px;font-size:12px;">{{ $checkedIn }} checked in</span>
            <span style="font-size:12px;color:#718096;">{{ $fp }}% attendance</span>
          </div>
          <div style="background:#e2e8f0;border-radius:4px;height:4px;overflow:hidden;margin-top:8px;max-width:300px;">
            <div style="background:#276749;height:100%;width:{{ $fp }}%;border-radius:4px;"></div>
          </div>
        </div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
          <a href="{{ route('admin.conference.participants', $form) }}"
             style="padding:7px 14px;background:#3182ce;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;font-weight:600;white-space:nowrap;">
            👥 Participants
          </a>
          <a href="{{ route('admin.conference.export-participants', $form) }}"
             style="padding:7px 14px;background:#276749;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;white-space:nowrap;">
            ⬇ Export
          </a>
          <a href="{{ route('admin.conference.settings', $form) }}"
             style="padding:7px 14px;background:#4a5568;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;white-space:nowrap;">
            ⚙ Settings
          </a>
          <a href="{{ route('admin.conference.scan-logs', $form) }}"
             style="padding:7px 14px;background:#744210;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;white-space:nowrap;">
            📋 Logs
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Recent Activity --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:20px;">
      <h3 style="font-size:13px;font-weight:700;color:#4a5568;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 14px;">Recent Check-ins</h3>
      @forelse($recentCheckIns as $ci)
      @php $d = $ci->data ?? []; $n = $d['full_name'] ?? $d['name'] ?? 'Participant'; @endphp
      <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f0f4f8;font-size:13px;">
        <div>
          <div style="font-weight:600;color:#1a202c;">{{ $n }}</div>
          <div style="font-size:11px;color:#718096;font-family:monospace;">{{ $ci->participant_id }}</div>
        </div>
        <div style="font-size:11px;color:#718096;text-align:right;">{{ $ci->checked_in_at?->format('H:i d/m') }}</div>
      </div>
      @empty
      <div style="color:#a0aec0;font-size:13px;padding:16px 0;text-align:center;">No check-ins yet</div>
      @endforelse
    </div>

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:20px;">
      <h3 style="font-size:13px;font-weight:700;color:#4a5568;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 14px;">Recent Scan Activity</h3>
      @forelse($recentScans as $log)
      @php
        $actionColors = ['check_in'=>'#2b6cb0','lunch'=>'#c05621','manual_verify'=>'#276749','badge_print'=>'#553c9a'];
        $color = $actionColors[$log->action] ?? '#4a5568';
      @endphp
      <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f0f4f8;font-size:13px;">
        <div>
          <span style="color:{{ $color }};font-weight:600;font-size:11px;text-transform:uppercase;">{{ str_replace('_',' ',$log->action) }}</span>
          <div style="font-size:11px;color:#718096;">{{ $log->scanner?->name ?? 'Unknown' }}</div>
        </div>
        <div style="font-size:11px;color:#718096;">{{ $log->scanned_at->format('H:i d/m') }}</div>
      </div>
      @empty
      <div style="color:#a0aec0;font-size:13px;padding:16px 0;text-align:center;">No scan activity yet</div>
      @endforelse
    </div>
  </div>

  {{-- Staff Portal Links --}}
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:20px;">
    <h3 style="font-size:13px;font-weight:700;color:#4a5568;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 14px;">Staff Portal Links</h3>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <a href="{{ route('staff.front-desk') }}" target="_blank"
         style="display:flex;align-items:center;gap:8px;padding:12px 20px;background:#ebf8ff;border:1px solid #bee3f8;border-radius:6px;text-decoration:none;color:#2b6cb0;font-size:13px;font-weight:600;">
        🎪 Front Desk Portal
        <span style="font-size:11px;font-weight:400;color:#4a90e2;">{{ url('/staff/front-desk') }}</span>
      </a>
      <a href="{{ route('staff.lunch-scanner') }}" target="_blank"
         style="display:flex;align-items:center;gap:8px;padding:12px 20px;background:#fffaf0;border:1px solid #fbd38d;border-radius:6px;text-decoration:none;color:#c05621;font-size:13px;font-weight:600;">
        🍽 Lunch Scanner Portal
        <span style="font-size:11px;font-weight:400;color:#dd6b20;">{{ url('/staff/lunch-scanner') }}</span>
      </a>
    </div>
  </div>

  @endif

</div>
</x-admin-layout>
