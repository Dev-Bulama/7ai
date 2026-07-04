<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lunch Scanner — {{ $form?->name ?? 'Conference' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:#1a0a0a; color:#fff; font-family:'DM Sans',Arial,sans-serif; min-height:100vh; }
    .topbar { background:#2d1010; border-bottom:1px solid rgba(252,129,74,0.2); padding:12px 24px; display:flex; align-items:center; justify-content:space-between; }
    .topbar-logo { font-family:monospace; font-size:11px; letter-spacing:0.15em; color:#fc814a; text-transform:uppercase; }
    .topbar-user { font-size:13px; color:rgba(255,255,255,0.6); display:flex; align-items:center; gap:12px; }
    .container { max-width:600px; margin:0 auto; padding:32px 16px; }
    h1 { font-size:22px; font-weight:700; color:#fff; margin-bottom:4px; }
    .subtitle { font-size:14px; color:rgba(255,255,255,0.5); margin-bottom:24px; }
    .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:28px; }
    .stat { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:16px; text-align:center; }
    .stat-num { font-size:26px; font-weight:800; color:#fc814a; }
    .stat-label { font-size:11px; color:rgba(255,255,255,0.5); margin-top:4px; text-transform:uppercase; letter-spacing:0.08em; }
    .card { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:24px; margin-bottom:20px; }
    .card h2 { font-size:14px; font-weight:700; color:#fc814a; margin-bottom:16px; text-transform:uppercase; letter-spacing:0.08em; }
    input[type=text] {
      width:100%; padding:14px 16px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12);
      border-radius:4px; color:#fff; font-size:18px; outline:none; transition:border-color 0.2s; letter-spacing:0.05em;
    }
    input:focus { border-color:#fc814a; }
    .btn { padding:12px 24px; border:none; border-radius:4px; cursor:pointer; font-size:14px; font-weight:600; }
    .btn-orange { background:#fc814a; color:#fff; }
    .btn-orange:hover { background:#f96e30; }
    .result-box { margin-top:20px; border-radius:8px; padding:20px; display:none; }
    .result-success { background:rgba(252,129,74,0.12); border:1px solid rgba(252,129,74,0.4); }
    .result-warning { background:rgba(255,220,50,0.1); border:1px solid rgba(255,220,50,0.4); }
    .result-error { background:rgba(200,80,80,0.12); border:1px solid rgba(200,80,80,0.4); }
    .result-name { font-size:22px; font-weight:700; color:#fff; margin-bottom:4px; }
    .result-id { font-family:monospace; font-size:12px; color:#fc814a; }
    .result-msg { font-size:16px; margin-bottom:8px; }
  </style>
</head>
<body>

<div class="topbar">
  <div class="topbar-logo">🍽 Lunch Scanner Portal</div>
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
  <div class="subtitle">Lunch Distribution Scanner</div>

  @if($stats)
  <div class="stats">
    <div class="stat">
      <div class="stat-num">{{ $stats['total'] }}</div>
      <div class="stat-label">Checked In</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:#48bb78;">{{ $stats['lunch_collected'] }}</div>
      <div class="stat-label">Served</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:#fc8181;">{{ $stats['pending'] }}</div>
      <div class="stat-label">Remaining</div>
    </div>
  </div>
  @endif

  <div class="card">
    <h2>🔍 Scan Lunch QR Code</h2>
    <p style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:14px;">
      Scan participant badge QR code. Only checked-in participants receive lunch.
    </p>
    <div style="display:flex;gap:10px;">
      <input id="scan-input" type="text" placeholder="Scan QR code here..." autocomplete="off" autofocus>
      <button class="btn btn-orange" onclick="submitScan()">Confirm</button>
    </div>
    <div id="scan-result" class="result-box"></div>
  </div>

  @else
  <div style="text-align:center;padding:60px;color:rgba(255,255,255,0.4);">
    <div style="font-size:40px;margin-bottom:12px;">🍽</div>
    <p>No conference forms available.</p>
  </div>
  @endif

</div>

<script>
var FORM_ID = {{ $form?->id ?? 'null' }};
var CSRF    = document.querySelector('meta[name=csrf-token]').content;

var scanTimer;
document.getElementById('scan-input')?.addEventListener('keydown', function(e) {
  clearTimeout(scanTimer);
  if (e.key === 'Enter') { submitScan(); return; }
  scanTimer = setTimeout(function() {
    var v = document.getElementById('scan-input').value.trim();
    if (v.length > 10) submitScan();
  }, 400);
});

function submitScan() {
  var token = document.getElementById('scan-input').value.trim();
  if (!token || !FORM_ID) return;

  fetch('{{ route("staff.scan-lunch") }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
    body: JSON.stringify({qr_token: token, form_id: FORM_ID})
  })
  .then(r => r.json())
  .then(data => {
    var box = document.getElementById('scan-result');
    box.style.display = 'block';

    if (data.success) {
      box.className = 'result-box ' + (data.already_served ? 'result-warning' : 'result-success');
    } else {
      box.className = 'result-box result-error';
    }

    box.innerHTML = '<div class="result-msg">' + data.message + '</div>'
      + (data.name ? '<div class="result-name">' + data.name + '</div>' : '')
      + (data.participant_id ? '<div class="result-id">' + data.participant_id + '</div>' : '');

    if (data.success && !data.already_served) playBeep(true);
    else if (!data.success) playBeep(false);

    document.getElementById('scan-input').value = '';
    document.getElementById('scan-input').focus();
    setTimeout(() => { box.style.display = 'none'; }, 4000);
  })
  .catch(e => console.error(e));
}

function playBeep(success) {
  try {
    var ctx = new (window.AudioContext || window.webkitAudioContext)();
    var o = ctx.createOscillator();
    var g = ctx.createGain();
    o.connect(g); g.connect(ctx.destination);
    o.frequency.value = success ? 660 : 180;
    o.type = 'sine';
    g.gain.setValueAtTime(0.3, ctx.currentTime);
    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
    o.start(ctx.currentTime);
    o.stop(ctx.currentTime + 0.35);
  } catch(e) {}
}
</script>

</body>
</html>
