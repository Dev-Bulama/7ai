<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Lunch Scanner — {{ $form?->name ?? 'Conference' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --orange: #f6892a;
      --bg:     #1a0c00;
      --card:   rgba(255,255,255,0.05);
      --border: rgba(255,255,255,0.1);
    }
    * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
    html,body { height:100%; }
    body {
      background:var(--bg);
      color:#fff;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;
      min-height:100vh; display:flex; flex-direction:column;
    }

    .topbar {
      background:#2d1400; border-bottom:1px solid rgba(246,137,42,0.25);
      padding:0 16px; height:56px;
      display:flex; align-items:center; justify-content:space-between;
      flex-shrink:0; position:sticky; top:0; z-index:100;
    }
    .topbar-logo { font-size:13px; font-weight:700; color:var(--orange); letter-spacing:0.08em; }
    .topbar-event { font-size:12px; color:rgba(255,255,255,0.5); }
    .user-name { font-size:12px; color:rgba(255,255,255,0.6); }
    .logout-btn {
      background:rgba(255,255,255,0.08); border:none;
      color:rgba(255,255,255,0.7); padding:6px 12px; border-radius:4px;
      font-size:12px; cursor:pointer;
    }

    .tabs {
      display:flex; background:#2d1400;
      border-bottom:1px solid var(--border); flex-shrink:0;
    }
    .tab {
      flex:1; padding:14px 8px; text-align:center; cursor:pointer;
      font-size:13px; font-weight:600; color:rgba(255,255,255,0.5);
      border-bottom:2px solid transparent; transition:all 0.2s; user-select:none;
    }
    .tab.active { color:var(--orange); border-bottom-color:var(--orange); }
    .tab-icon { font-size:18px; display:block; margin-bottom:2px; }

    .panel { display:none; flex:1; overflow-y:auto; padding:16px; }
    .panel.active { display:block; }

    .stats {
      display:grid; grid-template-columns:repeat(3,1fr);
      gap:8px; margin-bottom:16px;
    }
    .stat {
      background:var(--card); border:1px solid var(--border);
      border-radius:8px; padding:12px 8px; text-align:center;
    }
    .stat-num { font-size:24px; font-weight:800; color:var(--orange); }
    .stat-label { font-size:10px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.06em; margin-top:2px; }

    .camera-wrap {
      background:#000; border-radius:12px; overflow:hidden;
      position:relative; width:100%;
      max-width:400px; margin:0 auto 16px; aspect-ratio:1/1;
    }
    #qr-reader { width:100% !important; }
    #qr-reader video { width:100% !important; height:100% !important; object-fit:cover; border-radius:12px; }
    #qr-reader img { display:none !important; }
    .camera-overlay {
      position:absolute; inset:0;
      display:flex; align-items:center; justify-content:center;
      pointer-events:none;
    }
    .scan-frame {
      width:60%; aspect-ratio:1/1; border:2px solid var(--orange);
      border-radius:8px; box-shadow:0 0 0 9999px rgba(0,0,0,0.35);
    }
    .scan-line {
      position:absolute; width:80%; height:2px;
      background:linear-gradient(to right,transparent,var(--orange),transparent);
      animation:scan 2s infinite; top:50%;
    }
    @keyframes scan { 0%,100%{transform:translateY(-40px)} 50%{transform:translateY(40px)} }

    .camera-status { text-align:center; font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:12px; }
    .camera-toggle-btn {
      display:block; width:100%; max-width:400px; margin:0 auto 12px;
      padding:12px; background:var(--orange); color:#fff;
      font-size:14px; font-weight:700; border:none; border-radius:8px; cursor:pointer;
    }
    .camera-toggle-btn.stop { background:rgba(200,80,80,0.8); }

    .input-row { display:flex; gap:8px; margin-bottom:12px; }
    .scan-field {
      flex:1; padding:14px 16px;
      background:rgba(255,255,255,0.06);
      border:1px solid rgba(255,255,255,0.15);
      border-radius:8px; color:#fff; font-size:16px; outline:none;
    }
    .scan-field:focus { border-color:var(--orange); }
    .action-btn {
      padding:14px 20px; border:none; border-radius:8px;
      font-size:14px; font-weight:700; cursor:pointer; white-space:nowrap;
    }
    .btn-orange { background:var(--orange); color:#fff; }

    .result-box {
      border-radius:10px; padding:16px 18px;
      margin-bottom:16px; display:none;
      animation:fadeIn 0.2s ease;
    }
    @keyframes fadeIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
    .result-success { background:rgba(246,137,42,0.15); border:1.5px solid var(--orange); }
    .result-warning { background:rgba(255,210,50,0.12); border:1.5px solid rgba(255,210,50,0.6); }
    .result-error   { background:rgba(200,80,80,0.12); border:1.5px solid rgba(200,80,80,0.6); }
    .result-msg  { font-size:15px; font-weight:600; margin-bottom:4px; }
    .result-name { font-size:20px; font-weight:700; color:#fff; }
    .result-id   { font-family:monospace; font-size:12px; color:var(--orange); margin-top:2px; }

    .form-select {
      width:100%; padding:12px 14px;
      background:rgba(255,255,255,0.06);
      border:1px solid var(--border);
      border-radius:8px; color:#fff; font-size:14px; outline:none; margin-bottom:16px;
    }
    .no-form { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.4); }
    .no-form .icon { font-size:48px; margin-bottom:12px; }
    .section-title {
      font-size:11px; font-weight:700; color:rgba(255,255,255,0.4);
      text-transform:uppercase; letter-spacing:0.12em; margin-bottom:10px;
    }
  </style>
</head>
<body>

<div class="topbar">
  <div>
    <div class="topbar-logo">🍽 Lunch Scanner</div>
    @if($form)<div class="topbar-event">{{ $form->name }}</div>@endif
  </div>
  <div style="display:flex;align-items:center;gap:8px;">
    <span class="user-name">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" class="logout-btn">Sign Out</button>
    </form>
  </div>
</div>

<div class="tabs">
  <div class="tab active" onclick="switchTab('camera')" id="tab-camera">
    <span class="tab-icon">📷</span>Camera Scan
  </div>
  <div class="tab" onclick="switchTab('manual')" id="tab-manual">
    <span class="tab-icon">⌨️</span>Manual Entry
  </div>
</div>

{{-- Camera Panel --}}
<div class="panel active" id="panel-camera">

  @if($forms->count() > 1)
  <select class="form-select" onchange="window.location.href=window.location.pathname+'?form_id='+this.value">
    @foreach($forms as $f)
    <option value="{{ $f->id }}" @selected($form?->id == $f->id)>{{ $f->name }}</option>
    @endforeach
  </select>
  @endif

  @if($form)
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

  <div id="scan-result-cam" class="result-box"></div>

  <div class="camera-wrap" id="camera-wrap">
    <div id="qr-reader"></div>
    <div class="camera-overlay">
      <div style="position:relative;width:60%;aspect-ratio:1/1;">
        <div class="scan-frame"></div>
        <div class="scan-line"></div>
      </div>
    </div>
  </div>

  <div class="camera-status" id="cam-status">Tap Start Camera to scan participant badge</div>
  <button class="camera-toggle-btn" id="cam-btn" onclick="toggleCamera()">📷 Start Camera</button>

  <div style="background:rgba(246,137,42,0.08);border:1px solid rgba(246,137,42,0.2);border-radius:8px;padding:12px 16px;font-size:12px;color:rgba(255,255,255,0.6);margin-top:8px;">
    ⚠ Only checked-in participants can collect lunch. Scanning an unchecked participant will be rejected.
  </div>

  @else
  <div class="no-form"><div class="icon">🍽</div><p>No conference forms available.</p></div>
  @endif
</div>

{{-- Manual Entry Panel --}}
<div class="panel" id="panel-manual">

  @if($form)
  <div class="section-title">Enter QR Token Manually</div>
  <div id="scan-result-manual" class="result-box"></div>
  <div class="input-row">
    <input id="manual-input" type="text" class="scan-field" placeholder="Paste or type QR token..." autocomplete="off" autocorrect="off" spellcheck="false">
    <button class="action-btn btn-orange" onclick="submitLunch('manual')">🍽 Confirm</button>
  </div>
  <div style="font-size:12px;color:rgba(255,255,255,0.3);text-align:center;margin-top:4px;">
    Type the QR token from the participant badge and press Enter or Confirm.
  </div>
  @else
  <div class="no-form"><div class="icon">🍽</div><p>No conference forms available.</p></div>
  @endif
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" crossorigin="anonymous"></script>

<script>
var FORM_ID = {{ $form?->id ?? 'null' }};
var CSRF    = document.querySelector('meta[name=csrf-token]').content;
var scanner = null;
var cameraOn = false;

function switchTab(name) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  document.getElementById('panel-' + name).classList.add('active');
  if (name !== 'camera' && cameraOn) stopCamera();
  if (name === 'manual') setTimeout(() => document.getElementById('manual-input')?.focus(), 100);
}

function toggleCamera() {
  if (cameraOn) { stopCamera(); } else { startCamera(); }
}

function startCamera() {
  var btn = document.getElementById('cam-btn');
  var status = document.getElementById('cam-status');
  status.textContent = 'Starting camera...';
  btn.textContent = '⏳ Starting...';
  btn.disabled = true;

  scanner = new Html5Qrcode('qr-reader');
  scanner.start(
    { facingMode: 'environment' },
    { fps: 10, qrbox: { width: 200, height: 200 }, aspectRatio: 1.0 },
    function(decodedText) {
      if (decodedText) processToken(decodedText.trim());
    },
    function() {}
  )
  .then(function() {
    cameraOn = true;
    btn.textContent = '⏹ Stop Camera';
    btn.className = 'camera-toggle-btn stop';
    btn.disabled = false;
    status.textContent = 'Scanning — point camera at QR code on badge';
  })
  .catch(function(err) {
    cameraOn = false;
    btn.disabled = false;
    btn.textContent = '📷 Start Camera';
    status.textContent = err.toString().includes('Permission')
      ? '⛔ Camera permission denied. Please allow camera access and try again.'
      : '⚠ Camera error: ' + err;
  });
}

function stopCamera() {
  if (scanner && cameraOn) {
    scanner.stop().then(function() {
      cameraOn = false;
      document.getElementById('cam-btn').textContent = '📷 Start Camera';
      document.getElementById('cam-btn').className = 'camera-toggle-btn';
      document.getElementById('cam-status').textContent = 'Camera stopped.';
    });
  }
}

var lastToken = '', lastTime = 0;
function processToken(token) {
  if (!token || !FORM_ID) return;
  if (token === lastToken && (Date.now() - lastTime) < 4000) return;
  lastToken = token; lastTime = Date.now();
  submitLunch('cam', token);
}

function submitLunch(context, tokenOverride) {
  var token = tokenOverride || (document.getElementById('manual-input')?.value || '').trim();
  if (!token || !FORM_ID) return;
  var resultId = context === 'cam' ? 'scan-result-cam' : 'scan-result-manual';

  fetch('{{ route("staff.scan-lunch") }}', {
    method: 'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
    body: JSON.stringify({ qr_token: token, form_id: FORM_ID })
  })
  .then(r => r.json())
  .then(function(data) {
    var box = document.getElementById(resultId);
    box.style.display = 'block';
    if (data.success && !data.already_served) {
      box.className = 'result-box result-success';
      playBeep(true);
    } else if (data.success && data.already_served) {
      box.className = 'result-box result-warning';
      playBeep(false);
    } else {
      box.className = 'result-box result-error';
      playBeep(false);
    }
    box.innerHTML =
      '<div class="result-msg">' + escHtml(data.message || '') + '</div>' +
      (data.name ? '<div class="result-name">' + escHtml(data.name) + '</div>' : '') +
      (data.participant_id ? '<div class="result-id">' + escHtml(data.participant_id) + '</div>' : '');
    clearTimeout(box._timer);
    box._timer = setTimeout(() => { box.style.display = 'none'; }, 5000);
    if (context === 'manual') document.getElementById('manual-input').value = '';
  })
  .catch(function() {
    var box = document.getElementById(resultId);
    box.style.display = 'block';
    box.className = 'result-box result-error';
    box.innerHTML = '<div class="result-msg">Network error. Please try again.</div>';
  });
}

document.getElementById('manual-input')?.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') submitLunch('manual');
});

function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function playBeep(success) {
  try {
    var ctx = new (window.AudioContext || window.webkitAudioContext)();
    var o = ctx.createOscillator();
    var g = ctx.createGain();
    o.connect(g); g.connect(ctx.destination);
    o.frequency.value = success ? 660 : 180;
    g.gain.setValueAtTime(0.3, ctx.currentTime);
    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
    o.start(ctx.currentTime);
    o.stop(ctx.currentTime + 0.4);
  } catch(e) {}
}
</script>

</body>
</html>
