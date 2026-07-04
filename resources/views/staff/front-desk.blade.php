<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Front Desk — {{ $form?->name ?? 'Conference Check-In' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --green: #3ee07f;
      --navy:  #0a1628;
      --card:  rgba(255,255,255,0.05);
      --border:rgba(255,255,255,0.1);
    }
    * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
    html,body { height:100%; }
    body {
      background:var(--navy);
      color:#fff;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;
      min-height:100vh;
      display:flex; flex-direction:column;
    }

    /* ── TOP BAR ── */
    .topbar {
      background:#0b2240;
      border-bottom:1px solid rgba(62,224,127,0.2);
      padding:0 16px;
      height:56px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      flex-shrink:0;
      position:sticky; top:0; z-index:100;
    }
    .topbar-left { display:flex; align-items:center; gap:10px; }
    .topbar-logo { font-size:13px; font-weight:700; color:var(--green); letter-spacing:0.08em; }
    .topbar-event { font-size:12px; color:rgba(255,255,255,0.5); }
    .topbar-right { display:flex; align-items:center; gap:8px; }
    .user-name { font-size:12px; color:rgba(255,255,255,0.6); }
    .logout-btn {
      background:rgba(255,255,255,0.08);
      border:none; color:rgba(255,255,255,0.7);
      padding:6px 12px; border-radius:4px;
      font-size:12px; cursor:pointer;
    }

    /* ── TABS ── */
    .tabs {
      display:flex;
      background:#0b2240;
      border-bottom:1px solid var(--border);
      flex-shrink:0;
    }
    .tab {
      flex:1; padding:14px 8px;
      text-align:center; cursor:pointer;
      font-size:13px; font-weight:600;
      color:rgba(255,255,255,0.5);
      border-bottom:2px solid transparent;
      transition:all 0.2s;
      user-select:none;
    }
    .tab.active { color:var(--green); border-bottom-color:var(--green); }
    .tab-icon { font-size:18px; display:block; margin-bottom:2px; }

    /* ── CONTENT PANELS ── */
    .panel { display:none; flex:1; overflow-y:auto; padding:16px; }
    .panel.active { display:block; }

    /* ── STATS BAR ── */
    .stats {
      display:grid; grid-template-columns:repeat(3,1fr);
      gap:8px; margin-bottom:16px;
    }
    .stat {
      background:var(--card); border:1px solid var(--border);
      border-radius:8px; padding:12px 8px; text-align:center;
    }
    .stat-num { font-size:24px; font-weight:800; color:var(--green); }
    .stat-label { font-size:10px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.06em; margin-top:2px; }

    /* ── CAMERA ── */
    .camera-wrap {
      background:#000;
      border-radius:12px; overflow:hidden;
      position:relative; width:100%;
      max-width:400px; margin:0 auto 16px;
      aspect-ratio:1/1;
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
      width:60%; aspect-ratio:1/1;
      border:2px solid var(--green);
      border-radius:8px;
      box-shadow:0 0 0 9999px rgba(0,0,0,0.35);
    }
    .scan-frame::before, .scan-frame::after {
      content:''; position:absolute; width:20px; height:20px;
      border-color:var(--green); border-style:solid;
    }
    .scan-line {
      position:absolute;
      width:80%; height:2px;
      background:linear-gradient(to right,transparent,var(--green),transparent);
      animation:scan 2s infinite;
      top:50%;
    }
    @keyframes scan { 0%,100%{transform:translateY(-40px)} 50%{transform:translateY(40px)} }

    .camera-status {
      text-align:center; font-size:13px;
      color:rgba(255,255,255,0.5); margin-bottom:12px;
    }
    .camera-toggle-btn {
      display:block; width:100%; max-width:400px; margin:0 auto 12px;
      padding:12px; background:var(--green); color:var(--navy);
      font-size:14px; font-weight:700; border:none; border-radius:8px; cursor:pointer;
    }
    .camera-toggle-btn.stop { background:rgba(200,80,80,0.8); color:#fff; }

    /* ── MANUAL INPUT ── */
    .input-row { display:flex; gap:8px; margin-bottom:12px; }
    .scan-field {
      flex:1; padding:14px 16px;
      background:rgba(255,255,255,0.06);
      border:1px solid rgba(255,255,255,0.15);
      border-radius:8px; color:#fff;
      font-size:16px; outline:none;
    }
    .scan-field:focus { border-color:var(--green); }
    .action-btn {
      padding:14px 20px; border:none; border-radius:8px;
      font-size:14px; font-weight:700; cursor:pointer;
      white-space:nowrap;
    }
    .btn-green  { background:var(--green); color:var(--navy); }
    .btn-search { background:rgba(255,255,255,0.1); color:#fff; }

    /* ── RESULT BOX ── */
    .result-box {
      border-radius:10px; padding:16px 18px;
      margin-bottom:16px; display:none;
      animation:fadeIn 0.2s ease;
    }
    @keyframes fadeIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
    .result-success { background:rgba(62,224,127,0.12); border:1.5px solid var(--green); }
    .result-warning { background:rgba(255,210,50,0.12); border:1.5px solid rgba(255,210,50,0.6); }
    .result-error   { background:rgba(200,80,80,0.12); border:1.5px solid rgba(200,80,80,0.6); }
    .result-msg  { font-size:15px; font-weight:600; margin-bottom:4px; }
    .result-name { font-size:20px; font-weight:700; color:#fff; }
    .result-id   { font-family:monospace; font-size:12px; color:var(--green); margin-top:2px; }

    /* ── SEARCH RESULTS ── */
    .search-row {
      padding:14px 16px;
      background:var(--card); border:1px solid var(--border);
      border-radius:8px; margin-bottom:8px;
    }
    .search-row.checked { background:rgba(62,224,127,0.08); border-color:rgba(62,224,127,0.25); }
    .search-row .sname { font-size:15px; font-weight:700; color:#fff; margin-bottom:2px; }
    .search-row .smeta { font-size:12px; color:rgba(255,255,255,0.5); }
    .search-row .sstatus { font-size:11px; color:var(--green); margin-top:4px; }
    .search-row .checkin-btn {
      margin-top:10px; width:100%; padding:11px;
      background:var(--green); color:var(--navy);
      font-size:13px; font-weight:700; border:none; border-radius:6px; cursor:pointer;
    }
    .search-row .checkin-btn:disabled { opacity:0.5; }

    /* ── FORM SELECTOR ── */
    .form-select {
      width:100%; padding:12px 14px;
      background:rgba(255,255,255,0.06);
      border:1px solid var(--border);
      border-radius:8px; color:#fff; font-size:14px;
      outline:none; margin-bottom:16px;
    }

    /* ── NO FORM ── */
    .no-form { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.4); }
    .no-form .icon { font-size:48px; margin-bottom:12px; }

    /* ── SECTION HEADING ── */
    .section-title {
      font-size:11px; font-weight:700; color:rgba(255,255,255,0.4);
      text-transform:uppercase; letter-spacing:0.12em;
      margin-bottom:10px;
    }

    @media (min-width:600px) {
      .camera-wrap { max-width:360px; }
      .panel { padding:24px; }
    }
  </style>
</head>
<body>

{{-- ── TOP BAR ────────────────────────────────────────────────────── --}}
<div class="topbar">
  <div class="topbar-left">
    <div>
      <div class="topbar-logo">🎪 Front Desk</div>
      @if($form)
      <div class="topbar-event">{{ $form->name }}</div>
      @endif
    </div>
  </div>
  <div class="topbar-right">
    <span class="user-name">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" class="logout-btn">Sign Out</button>
    </form>
  </div>
</div>

{{-- ── TABS ────────────────────────────────────────────────────────── --}}
<div class="tabs">
  <div class="tab active" onclick="switchTab('search')" id="tab-search">
    <span class="tab-icon">🔍</span>Search
  </div>
  <div class="tab" onclick="switchTab('manual')" id="tab-manual">
    <span class="tab-icon">⌨️</span>QR Token
  </div>
  <div class="tab" onclick="switchTab('camera')" id="tab-camera">
    <span class="tab-icon">📷</span>Camera
  </div>
</div>

{{-- ── PANELS ──────────────────────────────────────────────────────── --}}

{{-- Search Panel (default) --}}
<div class="panel active" id="panel-search">

  @if($forms->count() > 1)
  <select class="form-select" onchange="changeForm(this.value)">
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
      <div class="stat-label">Total</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:var(--green);">{{ $stats['checked_in'] }}</div>
      <div class="stat-label">Checked In</div>
    </div>
    <div class="stat">
      <div class="stat-num" style="color:#fc8181;">{{ $stats['pending'] }}</div>
      <div class="stat-label">Pending</div>
    </div>
  </div>
  @endif

  <div class="section-title">Search Participants</div>
  <div class="input-row">
    <input id="search-input" type="search" class="scan-field" placeholder="Name, email, phone, or participant ID..." autocomplete="off" autofocus>
    <button class="action-btn btn-search" onclick="doSearch()">Search</button>
  </div>
  <div id="search-results"></div>
  @else
  <div class="no-form"><div class="icon">🎪</div><p>No conference forms available.</p></div>
  @endif
</div>

{{-- QR Token Manual Entry Panel --}}
<div class="panel" id="panel-manual">
  @if($form)
  <div class="section-title">Enter QR Token Manually</div>
  <div id="scan-result-manual" class="result-box"></div>
  <div class="input-row">
    <input id="manual-input" type="text" class="scan-field" placeholder="Paste or type QR token from badge..." autocomplete="off" autocorrect="off" spellcheck="false">
    <button class="action-btn btn-green" onclick="submitScan('manual')">✓ Check In</button>
  </div>
  <div style="font-size:12px;color:rgba(255,255,255,0.3);text-align:center;margin-top:4px;">
    Enter the long token printed on the participant badge, then press Enter or Check In.
  </div>
  @else
  <div class="no-form"><div class="icon">🎪</div><p>No conference forms available.</p></div>
  @endif
</div>

{{-- Camera Scan Panel --}}
<div class="panel" id="panel-camera">
  @if($form)
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
  <div class="camera-status" id="cam-status">Tap Start Camera to begin scanning</div>
  <button class="camera-toggle-btn" id="cam-btn" onclick="toggleCamera()">📷 Start Camera</button>
  @else
  <div class="no-form"><div class="icon">🎪</div><p>No conference forms available.</p></div>
  @endif
</div>

{{-- html5-qrcode library for camera scanning --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" crossorigin="anonymous"></script>

<script>
var FORM_ID = {{ $form?->id ?? 'null' }};
var CSRF    = document.querySelector('meta[name=csrf-token]').content;
var scanner = null;
var cameraOn = false;

// ── Tab switching ─────────────────────────────────────────────────────
function switchTab(name) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  document.getElementById('panel-' + name).classList.add('active');
  if (name !== 'camera' && cameraOn) stopCamera();
  if (name === 'manual') { setTimeout(() => document.getElementById('manual-input')?.focus(), 100); }
  if (name === 'search')  { setTimeout(() => document.getElementById('search-input')?.focus(), 100); }
}

// ── Form change ───────────────────────────────────────────────────────
function changeForm(id) {
  window.location.href = window.location.pathname + '?form_id=' + id;
}

// ── Camera scanner ────────────────────────────────────────────────────
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
    { facingMode: 'environment' }, // back camera
    { fps: 10, qrbox: { width: 200, height: 200 }, aspectRatio: 1.0 },
    function(decodedText) {
      // QR scanned successfully
      if (decodedText) {
        processToken(decodedText.trim(), 'cam');
      }
    },
    function(error) { /* ignore scan errors (frame with no QR) */ }
  )
  .then(function() {
    cameraOn = true;
    btn.textContent = '⏹ Stop Camera';
    btn.className = 'camera-toggle-btn stop';
    btn.disabled = false;
    status.textContent = 'Point camera at QR code on badge';
  })
  .catch(function(err) {
    cameraOn = false;
    btn.disabled = false;
    btn.textContent = '📷 Start Camera';
    if (err.toString().includes('Permission')) {
      status.textContent = '⛔ Camera permission denied. Please allow camera access.';
    } else {
      status.textContent = '⚠ Camera error: ' + err;
    }
  });
}

function stopCamera() {
  if (scanner && cameraOn) {
    scanner.stop().then(function() {
      cameraOn = false;
      document.getElementById('cam-btn').textContent = '📷 Start Camera';
      document.getElementById('cam-btn').className = 'camera-toggle-btn';
      document.getElementById('cam-status').textContent = 'Camera stopped. Tap Start Camera to begin.';
    });
  }
}

// ── Process scanned/entered token ────────────────────────────────────
var lastToken = '', lastTime = 0;
function processToken(token, context) {
  if (!token || !FORM_ID) return;
  // Debounce — ignore same token within 3 seconds (scanner rapid-fire)
  if (token === lastToken && (Date.now() - lastTime) < 3000) return;
  lastToken = token; lastTime = Date.now();
  submitScan(context, token);
}

function submitScan(context, tokenOverride) {
  var token = tokenOverride;
  if (!token) {
    var inputEl = document.getElementById('manual-input');
    if (inputEl) token = inputEl.value.trim();
  }
  if (!token || !FORM_ID) return;

  var resultId = context === 'cam' ? 'scan-result-cam' : 'scan-result-manual';

  fetch('{{ route("staff.scan-check-in") }}', {
    method: 'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
    body: JSON.stringify({ qr_token: token, form_id: FORM_ID })
  })
  .then(function(r) {
    if (!r.ok && r.status !== 404) {
      return r.text().then(function(t) {
        throw new Error('HTTP ' + r.status + (r.status === 419 ? ' — session expired, reload the page' : ''));
      });
    }
    return r.json();
  })
  .then(function(data) {
    showResult(resultId, data.success, data.already_checked, data);
    if (context === 'manual') { document.getElementById('manual-input').value = ''; }
    playBeep(data.success && !data.already_checked);
  })
  .catch(function(e) { showResult(resultId, false, false, { message: e.message || 'Network error. Try again.' }); });
}

function showResult(boxId, success, warning, data) {
  var box = document.getElementById(boxId);
  box.style.display = 'block';
  if (success && !warning) {
    box.className = 'result-box result-success';
  } else if (success && warning) {
    box.className = 'result-box result-warning';
  } else {
    box.className = 'result-box result-error';
  }
  box.innerHTML =
    '<div class="result-msg">' + escHtml(data.message || '') + '</div>' +
    (data.name ? '<div class="result-name">' + escHtml(data.name) + '</div>' : '') +
    (data.participant_id ? '<div class="result-id">' + escHtml(data.participant_id) + '</div>' : '') +
    (data.checked_in_at ? '<div style="font-size:11px;color:rgba(255,255,255,0.5);margin-top:4px;">' + escHtml(data.checked_in_at) + '</div>' : '');
  clearTimeout(box._timer);
  box._timer = setTimeout(() => { box.style.display = 'none'; }, 5000);
}

// ── Search ─────────────────────────────────────────────────────────────
document.getElementById('search-input')?.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') doSearch();
});
document.getElementById('manual-input')?.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') submitScan('manual');
});

function doSearch() {
  var q = (document.getElementById('search-input')?.value || '').trim();
  if (!q || !FORM_ID) return;
  document.getElementById('search-results').innerHTML = '<div style="padding:20px;text-align:center;color:rgba(255,255,255,0.4);">Searching...</div>';

  fetch('{{ route("staff.lookup-participant") }}', {
    method: 'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
    body: JSON.stringify({ query: q, form_id: FORM_ID })
  })
  .then(function(r) {
    if (!r.ok) {
      return r.json().catch(function() { return {}; }).then(function(j) {
        if (r.status === 401 || r.status === 403) throw new Error((j.error || 'Access denied') + ' — please reload and log in again.');
        if (r.status === 419) throw new Error('Session expired — please reload the page.');
        throw new Error('Server error (' + r.status + '). Please try again.');
      });
    }
    return r.json();
  })
  .then(function(data) {
    var cont = document.getElementById('search-results');
    if (!data.results || !data.results.length) {
      cont.innerHTML = '<div style="padding:20px;text-align:center;color:rgba(255,255,255,0.4);font-size:14px;">No participants found for "' + escHtml(q) + '"</div>';
      return;
    }
    cont.innerHTML = data.results.map(function(p) {
      return '<div class="search-row' + (p.checked_in ? ' checked' : '') + '">' +
        '<div class="sname">' + escHtml(p.name) + '</div>' +
        '<div class="smeta">' +
          (p.participant_id ? escHtml(p.participant_id) + ' &nbsp;·&nbsp; ' : '') +
          escHtml(p.email || '') + (p.phone ? ' &nbsp;·&nbsp; ' + escHtml(p.phone) : '') +
        '</div>' +
        (p.checked_in ? '<div class="sstatus">✓ Checked in' + (p.checked_in_at ? ' at ' + escHtml(p.checked_in_at) : '') + '</div>' : '') +
        (!p.checked_in ? '<button class="checkin-btn" onclick="checkInById(' + p.id + ', this)">✓ Mark as Checked In</button>' : '') +
        '</div>';
    }).join('');
  })
  .catch(function(err) {
    document.getElementById('search-results').innerHTML = '<div style="padding:20px;text-align:center;color:#fc8181;font-size:13px;">' + escHtml(err.message || 'Request failed. Please try again.') + '</div>';
  });
}

function checkInById(id, btn) {
  btn.disabled = true;
  btn.textContent = 'Processing...';
  fetch('{{ route("staff.check-in-by-id") }}', {
    method: 'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
    body: JSON.stringify({ submission_id: id })
  })
  .then(r => r.json())
  .then(function(data) {
    if (data.success) {
      btn.textContent = '✓ Checked In';
      btn.style.background = 'rgba(62,224,127,0.2)';
      btn.style.color = 'var(--green)';
      btn.closest('.search-row').classList.add('checked');
      playBeep(true);
    } else {
      btn.disabled = false;
      btn.textContent = '✓ Mark as Checked In';
    }
  });
}

// ── Utilities ─────────────────────────────────────────────────────────
function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
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
    g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
    o.start(ctx.currentTime);
    o.stop(ctx.currentTime + 0.35);
  } catch(e) {}
}
</script>

</body>
</html>
