<x-admin-layout :title="'Participants — '.$form->name">
<div style="padding:32px;max-width:1200px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <div>
      <div style="font-size:12px;color:#718096;margin-bottom:4px;">
        <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      </div>
      <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">{{ $form->name }}</h1>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
      {{-- Filtered CSV export dropdown --}}
      <div style="position:relative;" id="csv-dropdown-wrap">
        <button onclick="toggleCsvMenu()" type="button"
          style="padding:8px 14px;background:#276749;color:#fff;border:none;border-radius:4px;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:5px;">
          ⬇ Export CSV ▾
        </button>
        <div id="csv-menu" style="display:none;position:absolute;right:0;top:38px;background:#fff;border:1px solid #e2e8f0;border-radius:6px;min-width:190px;box-shadow:0 4px 16px rgba(0,0,0,.12);z-index:100;">
          <a href="{{ route('admin.conference.export-participants', $form) }}"
            style="display:block;padding:10px 16px;font-size:13px;color:#1a202c;text-decoration:none;border-bottom:1px solid #f0f4f8;">
            All Participants
          </a>
          <a href="{{ route('admin.conference.export-participants', $form) }}?filter=checked_in"
            style="display:block;padding:10px 16px;font-size:13px;color:#276749;text-decoration:none;border-bottom:1px solid #f0f4f8;">
            ✓ Checked In Only
          </a>
          <a href="{{ route('admin.conference.export-participants', $form) }}?filter=not_checked_in"
            style="display:block;padding:10px 16px;font-size:13px;color:#c53030;text-decoration:none;">
            ✗ Not Checked In Only
          </a>
        </div>
      </div>
      <a href="{{ route('admin.conference.export-qr', $form) }}" target="_blank"
         style="padding:8px 14px;background:#553c9a;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
        🏷 Export All QR
      </a>
      <a href="{{ route('admin.conference.settings', $form) }}"
         style="padding:8px 14px;background:#4a5568;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;">
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
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
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
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:10px 14px;border-radius:4px;margin-bottom:12px;font-size:14px;">
    {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div style="background:#fff5f5;border:1px solid #fed7d7;color:#c53030;padding:10px 14px;border-radius:4px;margin-bottom:12px;font-size:14px;">
    {{ session('error') }}
  </div>
  @endif

  {{-- Bulk check-in bar --}}
  <form method="POST" action="{{ route('admin.conference.bulk-check-in', $form) }}" id="bulk-checkin-form">
    @csrf
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:10px 14px;margin-bottom:10px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
      <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;cursor:pointer;">
        <input type="checkbox" id="select-all-chk" style="width:16px;height:16px;" onchange="toggleSelectAll(this)">
        <span id="bulk-label" style="color:#718096;">Select all</span>
      </label>
      <button type="button" onclick="doBulkCheckIn()"
        style="margin-left:auto;padding:7px 16px;background:#276749;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;font-weight:600;">
        ✓ Bulk Check In Selected
      </button>
    </div>

  {{-- Role colour key --}}
  @php
  $roleColors = [
    'Participant' => ['#e9d8fd','#553c9a'],
    'Speaker'     => ['#bee3f8','#2b6cb0'],
    'VIP'         => ['#feebc8','#c05621'],
    'USHER'       => ['#c6f6d5','#276749'],
    'Protocol'    => ['#fed7d7','#c53030'],
  ];
  @endphp

  {{-- Table --}}
  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow-x:auto;">
    <table style="width:100%;min-width:880px;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:#f7fafc;">
          <th style="padding:10px 10px;border-bottom:1px solid #e2e8f0;width:36px;"></th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Participant ID</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Name</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Email</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Badge Role</th>
          <th style="padding:10px 14px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Checked In</th>
          <th style="padding:10px 14px;text-align:center;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Lunch</th>
          <th style="padding:10px 14px;text-align:right;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($participants as $p)
        @php
          $data  = $p->data ?? [];
          $name  = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: '—';
          $email = $data['email'] ?? '—';
          $role  = $p->badge_role ?: ($data['role'] ?? $data['course'] ?? $data['category'] ?? 'Participant');
          $rc    = $roleColors[$role] ?? ['#edf2f7','#4a5568'];
        @endphp
        <tr class="p-row" style="border-bottom:1px solid #f0f4f8;@if($p->attendance_verified) background:#f0fff4; @endif">
          <td style="padding:10px 10px;text-align:center;">
            @if(!$p->attendance_verified)
            <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="row-chk"
              style="width:15px;height:15px;cursor:pointer;" onchange="updateBulkLabel()">
            @else
            <span style="color:#9ae6b4;font-size:14px;">✓</span>
            @endif
          </td>
          <td style="padding:10px 14px;font-family:monospace;color:#553c9a;font-weight:600;">{{ $p->participant_id ?? '—' }}</td>
          <td style="padding:10px 14px;font-weight:500;color:#1a202c;">{{ $name }}</td>
          <td style="padding:10px 14px;color:#4a5568;">{{ $email }}</td>
          <td style="padding:8px 14px;">
            <select onchange="setRole({{ $p->id }}, this.value, this)"
              style="padding:4px 8px;border:1px solid #e2e8f0;border-radius:4px;font-size:12px;font-weight:600;
                     background:{{ $rc[0] }};color:{{ $rc[1] }};cursor:pointer;outline:none;">
              @foreach(['Participant','Speaker','VIP','USHER','Protocol','Media','Volunteer','Staff','Guest'] as $opt)
              <option value="{{ $opt }}" @selected($role === $opt)>{{ $opt }}</option>
              @endforeach
              <option value="{{ $role }}" @if(!in_array($role,['Participant','Speaker','VIP','USHER','Protocol','Media','Volunteer','Staff','Guest'])) selected @endif>
                {{ in_array($role,['Participant','Speaker','VIP','USHER','Protocol','Media','Volunteer','Staff','Guest']) ? '' : $role }}
              </option>
            </select>
          </td>
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
          <td colspan="8" style="padding:40px;text-align:center;color:#a0aec0;">No participants found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  </form>{{-- end bulk form --}}

  <div style="margin-top:16px;">{{ $participants->withQueryString()->links() }}</div>

</div>

<script>
var CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

// ── CSV dropdown ────────────────────────────────────────────────────────────
function toggleCsvMenu() {
  var m = document.getElementById('csv-menu');
  m.style.display = m.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
  var wrap = document.getElementById('csv-dropdown-wrap');
  if (wrap && !wrap.contains(e.target)) {
    var m = document.getElementById('csv-menu');
    if (m) m.style.display = 'none';
  }
});

// ── Bulk check-in ───────────────────────────────────────────────────────────
function toggleSelectAll(chk) {
  document.querySelectorAll('.row-chk').forEach(function(c) { c.checked = chk.checked; });
  updateBulkLabel();
}

function updateBulkLabel() {
  var n = document.querySelectorAll('.row-chk:checked').length;
  var all = document.querySelectorAll('.row-chk').length;
  document.getElementById('bulk-label').textContent = n > 0 ? n + ' selected' : 'Select all';
  document.getElementById('select-all-chk').indeterminate = n > 0 && n < all;
  document.getElementById('select-all-chk').checked = n > 0 && n === all;
}

function doBulkCheckIn() {
  var checked = document.querySelectorAll('.row-chk:checked');
  if (!checked.length) { alert('Select at least one participant first.'); return; }
  if (!confirm('Check in ' + checked.length + ' participant(s)?')) return;
  document.getElementById('bulk-checkin-form').submit();
}

// ── Badge role colors ────────────────────────────────────────────────────────
var roleColors = {
  'Participant': ['#e9d8fd','#553c9a'],
  'Speaker':     ['#bee3f8','#2b6cb0'],
  'VIP':         ['#feebc8','#c05621'],
  'USHER':       ['#c6f6d5','#276749'],
  'Protocol':    ['#fed7d7','#c53030'],
  'Media':       ['#e2e8f0','#2d3748'],
  'Volunteer':   ['#c6f6d5','#276749'],
  'Staff':       ['#e2e8f0','#4a5568'],
  'Guest':       ['#fefcbf','#744210'],
};

function setRole(id, role, selectEl) {
  var colors = roleColors[role] || ['#edf2f7','#4a5568'];
  selectEl.style.background = colors[0];
  selectEl.style.color = colors[1];
  selectEl.disabled = true;

  fetch('/admin/conference/{{ $form->id }}/participants/' + id + '/role', {
    method: 'PATCH',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
    body: JSON.stringify({badge_role: role})
  })
  .then(r => r.json())
  .then(function(d) {
    selectEl.disabled = false;
    if (!d.success) { alert('Failed to save role.'); }
  })
  .catch(function() {
    selectEl.disabled = false;
    alert('Network error saving role.');
  });
}
</script>
</x-admin-layout>
