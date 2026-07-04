<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Front Desk — {{ $form?->name ?? 'Conference' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:#0a1628; color:#fff; font-family:'DM Sans',Arial,sans-serif; min-height:100vh; }
    .topbar { background:#0b2240; border-bottom:1px solid rgba(62,224,127,0.15); padding:12px 24px; display:flex; align-items:center; justify-content:space-between; }
    .topbar-logo { font-family:monospace; font-size:11px; letter-spacing:0.15em; color:#3ee07f; text-transform:uppercase; }
    .topbar-user { font-size:13px; color:rgba(255,255,255,0.6); display:flex; align-items:center; gap:12px; }
    .container { max-width:700px; margin:0 auto; padding:32px 16px; }
    h1 { font-size:22px; font-weight:700; color:#fff; margin-bottom:4px; }
    .subtitle { font-size:14px; color:rgba(255,255,255,0.5); margin-bottom:24px; }
    .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:28px; }
    .stat { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:16px; text-align:center; }
    .stat-num { font-size:26px; font-weight:800; color:#3ee07f; }
    .stat-label { font-size:11px; color:rgba(255,255,255,0.5); margin-top:4px; text-transform:uppercase; letter-spacing:0.08em; }
    .card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:24px; margin-bottom:20px; }
    .card h2 { font-size:14px; font-weight:700; color:#a8cdb8; margin-bottom:16px; text-transform:uppercase; letter-spacing:0.08em; }
    input[type=text], input[type=search] {
      width:100%; padding:14px 16px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12);
      border-radius:4px; color:#fff; font-size:15px; outline:none; transition:border-color 0.2s;
    }
    input:focus { border-color:#3ee07f; }
    .btn { padding:12px 24px; border:none; border-radius:4px; cursor:pointer; font-size:14px; font-weight:600; transition:background 0.2s; }
    .btn-green { background:#3ee07f; color:#0a1628; }
    .btn-green:hover { background:#62e896; }
    .btn-gray { background:rgba(255,255,255,0.1); color:#fff; }
    .btn-gray:hover { background:rgba(255,255,255,0.15); }
    .result-box { margin-top:20px; border-radius:8px; padding:20px; display:none; }
    .result-success { background:rgba(62,224,127,0.12); border:1px solid #3ee07f; }
    .result-warning { background:rgba(255,220,50,0.1); border:1px solid rgba(255,220,50,0.4); }
    .result-error { background:rgba(200,80,80,0.12); border:1px solid rgba(200,80,80,0.4); }
    .result-name { font-size:22px; font-weight:700; color:#fff; margin-bottom:4px; }
    .result-id { font-family:monospace; font-size:12px; color:#3ee07f; }
    .result-msg { font-size:16px; margin-bottom:8px; }
    .search-results { margin-top:12px; }
    .search-row { padding:12px 16px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:4px; margin-bottom:8px; display:flex; align-items:center; justify-content:space-between; }
    .search-row-info .name { font-weight:600; color:#fff; }
    .search-row-info .meta { font-size:12px; color:rgba(255,255,255,0.5); }
    .badge-checked { background:rgba(62,224,127,0.15); border-color:rgba(62,224,127,0.3); }
    #scan-input { font-size:18px; letter-spacing:0.05em; }
    .loading { opacity:0.5; pointer-events:none; }
  </style>
</head>
<body>

<div class="topbar">
  <div class="topbar-logo">🎪 Front Desk Portal</div>
  <div class="topbar-user">
    <span>{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" style="background:none;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:13px;padding:4px 8px;">Logout</button>
    </form>
  </div>
</div>

<div class="container">

  @if($forms->count() > 1)
  <div style="margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:10px;">
      <select name="form_id" style="flex:1;padding:10px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#fff;border-radius:4px;font-size:14px;" onchange="this.form.submit()">
        @foreach($forms as $f)
        <option value="{{ $f->id }}" @selected($form?->id == $f->id)>{{ $f->name }}</option>
        @endforeach
      </select>
    </form>
  </div>
  @endif

  @if($form)
  <h1>{{ $form->name }}</h1>
  <div class="subtitle">Front Desk Check-In Station</div>

  @if($stats)
  <div class="stats">
    <div class="stat">
      <div class="stat-num">{{ $stats['total'] }}</div>
      <div class="stat-label">Registered</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:#3ee07f;">{{ $stats['checked_in'] }}</div>
      <div class="stat-label">Checked In</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:#fc8181;">{{ $stats['pending'] }}</div>
      <div class="stat-label">Pending</div>
    </div>
  </div>
  @endif

  {{-- QR Scanner --}}
  <div class="card">
    <h2>📷 QR Code Scanner</h2>
    <p style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:14px;">
      Scan or manually type the QR code value from the participant's badge.
    </p>
    <div style="display:flex;gap:10px;">
      <input id="scan-input" type="text" placeholder="Scan QR code here..." autocomplete="off" autofocus>
      <button class="btn btn-green" onclick="submitScan()">Check In</button>
    </div>
    <div id="scan-result" class="result-box"></div>
  </div>

  {{-- Manual Lookup --}}
  <div class="card">
    <h2>🔍 Manual Lookup</h2>
    <div style="display:flex;gap:10px;">
      <input id="lookup-input" type="search" placeholder="Search by name, email, phone, or Participant ID...">
      <button class="btn btn-gray" onclick="doLookup()">Search</button>
    </div>
    <div id="lookup-results" class="search-results"></div>
  </div>

  @else
  <div style="text-align:center;padding:60px;color:rgba(255,255,255,0.4);">
    <div style="font-size:40px;margin-bottom:12px;">🎪</div>
    <p>No conference forms available.</p>
  </div>
  @endif

</div>

<script>
var FORM_ID  = {{ $form?->id ?? 'null' }};
var CSRF     = document.querySelector('meta[name=csrf-token]').content;

// Auto-submit scan on Enter or when input goes quiet (scanner rapid-fire)
var scanTimer;
document.getElementById('scan-input')?.addEventListener('keydown', function(e) {
  clearTimeout(scanTimer);
  if (e.key === 'Enter') { submitScan(); return; }
  scanTimer = setTimeout(function() {
    var v = document.getElementById('scan-input').value.trim();
    if (v.length > 10) submitScan(); // QR tokens are long
  }, 400);
});

document.getElementById('lookup-input')?.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') doLookup();
});

function submitScan() {
  var token = document.getElementById('scan-input').value.trim();
  if (!token || !FORM_ID) return;

  fetch('{{ route("staff.scan-check-in") }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
    body: JSON.stringify({qr_token: token, form_id: FORM_ID})
  })
  .then(r => r.json())
  .then(data => {
    var box = document.getElementById('scan-result');
    box.style.display = 'block';
    if (data.success) {
      box.className = 'result-box ' + (data.already_checked ? 'result-warning' : 'result-success');
      box.innerHTML = '<div class="result-msg">' + data.message + '</div>'
        + '<div class="result-name">' + (data.name||'') + '</div>'
        + '<div class="result-id">' + (data.participant_id||'') + '</div>'
        + (data.checked_in_at ? '<div style="font-size:12px;color:rgba(255,255,255,0.5);margin-top:4px;">' + data.checked_in_at + '</div>' : '');
      if (!data.already_checked) playBeep(true);
    } else {
      box.className = 'result-box result-error';
      box.innerHTML = '<div class="result-msg" style="color:#fc8181;">' + (data.message||'Error') + '</div>';
      playBeep(false);
    }
    document.getElementById('scan-input').value = '';
    document.getElementById('scan-input').focus();
    setTimeout(() => { box.style.display='none'; }, 4000);
  })
  .catch(e => console.error(e));
}

function doLookup() {
  var q = document.getElementById('lookup-input').value.trim();
  if (!q || !FORM_ID) return;

  fetch('{{ route("staff.lookup-participant") }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
    body: JSON.stringify({query: q, form_id: FORM_ID})
  })
  .then(r => r.json())
  .then(data => {
    var container = document.getElementById('lookup-results');
    if (!data.results || !data.results.length) {
      container.innerHTML = '<div style="padding:16px;color:rgba(255,255,255,0.4);font-size:14px;">No results found.</div>';
      return;
    }
    container.innerHTML = data.results.map(p => `
      <div class="search-row ${p.checked_in ? 'badge-checked' : ''}">
        <div class="search-row-info">
          <div class="name">${p.name}</div>
          <div class="meta">${p.participant_id||''} &nbsp;·&nbsp; ${p.email||''} &nbsp;·&nbsp; ${p.phone||''}</div>
          ${p.checked_in ? '<div style="font-size:11px;color:#3ee07f;margin-top:2px;">✓ Checked in at ' + (p.checked_in_at||'') + '</div>' : ''}
        </div>
        ${!p.checked_in ? `<button class="btn btn-green" onclick="checkInById(${p.id}, this)" style="padding:8px 16px;font-size:12px;">Check In</button>` : '<span style="color:#3ee07f;font-size:12px;">✓ Done</span>'}
      </div>
    `).join('');
  });
}

function checkInById(id, btn) {
  btn.disabled = true;
  btn.textContent = '...';
  fetch('{{ route("staff.check-in-by-id") }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
    body: JSON.stringify({submission_id: id})
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      btn.textContent = '✓ Done';
      btn.style.background = 'rgba(62,224,127,0.2)';
      btn.style.color = '#3ee07f';
      playBeep(true);
    }
  });
}

function playBeep(success) {
  try {
    var ctx = new (window.AudioContext || window.webkitAudioContext)();
    var o = ctx.createOscillator();
    var g = ctx.createGain();
    o.connect(g); g.connect(ctx.destination);
    o.frequency.value = success ? 880 : 220;
    o.type = 'sine';
    g.gain.setValueAtTime(0.3, ctx.currentTime);
    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
    o.start(ctx.currentTime);
    o.stop(ctx.currentTime + 0.3);
  } catch(e) {}
}
</script>

</body>
</html>
