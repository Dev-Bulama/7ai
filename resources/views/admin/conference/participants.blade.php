<x-admin-layout :title="'Participants — '.$form->name">
<div style="padding:32px;max-width:1200px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <div>
      <div style="font-size:12px;color:#718096;margin-bottom:4px;">
        <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      </div>
      <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">{{ $form->name }}</h1>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
      <a href="{{ route('admin.conference.export-participants', $form) }}"
         style="padding:8px 16px;background:#276749;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
        ⬇ CSV
      </a>
      <a href="{{ route('admin.conference.export-qr', $form) }}" target="_blank"
         style="padding:8px 16px;background:#553c9a;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
        🏷 Export All QR Badges
      </a>
      <a href="{{ route('admin.conference.settings', $form) }}"
         style="padding:8px 16px;background:#4a5568;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
        ⚙ Settings
      </a>
    </div>
  </div>

  {{-- Stats --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;">
    @foreach([['Total Registered','total','#3182ce'],['Checked In','checked_in','#276749'],['Lunch Collected','lunch_collected','#d69e2e'],['Have QR Code','with_qr','#553c9a']] as [$label,$key,$color])
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;text-align:center;">
      <div style="font-size:28px;font-weight:800;color:{{ $color }};">{{ $stats[$key] }}</div>
      <div style="font-size:12px;color:#718096;margin-top:4px;">{{ $label }}</div>
    </div>
    @endforeach
  </div>

  {{-- Filter + Search --}}
  <form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <input name="search" value="{{ request('search') }}" placeholder="Search name, email, participant ID..."
      style="flex:1;min-width:220px;padding:9px 14px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
    <select name="filter" style="padding:9px 14px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;background:#fff;">
      <option value="all" @selected(request('filter','all')==='all')>All Participants</option>
      <option value="checked_in" @selected(request('filter')==='checked_in')>Checked In</option>
      <option value="not_checked_in" @selected(request('filter')==='not_checked_in')>Not Checked In</option>
      <option value="lunch_collected" @selected(request('filter')==='lunch_collected')>Lunch Collected</option>
      <option value="no_qr" @selected(request('filter')==='no_qr')>No QR Token</option>
    </select>
    <button type="submit"
      style="padding:9px 20px;background:#3182ce;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px;">
      Filter
    </button>
  </form>

  @if(session('success'))
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:10px 14px;border-radius:4px;margin-bottom:16px;font-size:14px;">
    {{ session('success') }}
  </div>
  @endif

  {{-- Table --}}
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:#f7fafc;">
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Participant ID</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Name</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Email</th>
          <th style="padding:10px 14px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Checked In</th>
          <th style="padding:10px 14px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Lunch</th>
          <th style="padding:10px 14px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">QR</th>
          <th style="padding:10px 14px;text-align:right;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($participants as $p)
        @php
          $data = $p->data ?? [];
          $name = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: '—';
          $email = $data['email'] ?? '—';
        @endphp
        <tr style="border-bottom:1px solid #f0f4f8;@if($p->attendance_verified) background:#f0fff4; @endif">
          <td style="padding:10px 14px;font-family:monospace;color:#553c9a;font-weight:600;">{{ $p->participant_id ?? '—' }}</td>
          <td style="padding:10px 14px;font-weight:500;color:#1a202c;">{{ $name }}</td>
          <td style="padding:10px 14px;color:#4a5568;">{{ $email }}</td>
          <td style="padding:10px 14px;text-align:center;">
            @if($p->attendance_verified)
              <span style="background:#9ae6b4;color:#276749;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;">✓ YES</span>
              <div style="font-size:10px;color:#718096;margin-top:2px;">{{ $p->checked_in_at?->format('H:i') }}</div>
            @else
              <span style="background:#fed7d7;color:#c53030;padding:2px 8px;border-radius:4px;font-size:11px;">✗ NO</span>
            @endif
          </td>
          <td style="padding:10px 14px;text-align:center;">
            @if($p->lunch_collected)
              <span style="background:#feebc8;color:#c05621;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;">✓ YES</span>
            @else
              <span style="color:#a0aec0;font-size:11px;">—</span>
            @endif
          </td>
          <td style="padding:10px 14px;text-align:center;">
            @if($p->qr_token)
              <span style="color:#38a169;font-size:14px;">✓</span>
            @else
              <span style="color:#fc8181;font-size:14px;">✗</span>
            @endif
          </td>
          <td style="padding:10px 14px;text-align:right;">
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.conference.participant-card', [$form, $p]) }}" target="_blank"
                 style="padding:5px 10px;background:#553c9a;color:#fff;text-decoration:none;border-radius:3px;font-size:11px;">
                🏷 Badge
              </a>
              <form method="POST" action="{{ route('admin.conference.manual-check-in', [$form, $p]) }}" style="margin:0;">
                @csrf
                <button type="submit"
                  style="padding:5px 10px;background:{{ $p->attendance_verified ? '#fc8181' : '#48bb78' }};color:#fff;border:none;border-radius:3px;cursor:pointer;font-size:11px;">
                  {{ $p->attendance_verified ? 'Undo' : 'Check In' }}
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="padding:40px;text-align:center;color:#a0aec0;">No participants found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:16px;">{{ $participants->withQueryString()->links() }}</div>

</div>
</x-admin-layout>
