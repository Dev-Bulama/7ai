<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participant Badge — {{ $submission->participant_id }}</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500;700&display=swap');
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:#f0f0f0; display:flex; align-items:center; justify-content:center; min-height:100vh; font-family:'DM Sans',sans-serif; }
    .badge {
      width:85mm; min-height:120mm;
      background: {{ $settings->badge_bg_color ?? '#0a1628' }};
      border-radius:8px;
      overflow:hidden;
      box-shadow:0 4px 20px rgba(0,0,0,0.3);
      position:relative;
    }
    .badge-header {
      background: {{ $settings->badge_accent_color ?? '#3ee07f' }};
      padding:18px 20px 14px;
      text-align:center;
    }
    .event-name {
      font-size:13px;
      font-weight:700;
      color:#0a1628;
      letter-spacing:0.08em;
      text-transform:uppercase;
    }
    .badge-body { padding:20px; }
    .qr-area {
      display:flex; justify-content:center; margin-bottom:14px;
    }
    .qr-area canvas { border-radius:4px; background:#fff; padding:6px; }
    .participant-name {
      font-size:20px;
      font-weight:700;
      color:#fff;
      text-align:center;
      line-height:1.2;
      margin-bottom:6px;
    }
    .participant-id {
      font-family:'DM Mono',monospace;
      font-size:11px;
      color:{{ $settings->badge_accent_color ?? '#3ee07f' }};
      text-align:center;
      letter-spacing:0.12em;
      margin-bottom:14px;
    }
    .badge-detail {
      font-size:11px;
      color:rgba(255,255,255,0.6);
      text-align:center;
      line-height:1.8;
    }
    .badge-footer {
      border-top:1px solid rgba(255,255,255,0.1);
      padding:10px 20px;
      text-align:center;
      font-family:'DM Mono',monospace;
      font-size:9px;
      color:rgba(255,255,255,0.3);
      letter-spacing:0.1em;
    }
    @media print {
      body { background:white; }
      .no-print { display:none !important; }
      .badge { box-shadow:none; }
    }
  </style>
</head>
<body>

@php
  $data = $submission->data ?? [];
  $name = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: 'Participant';
  $email = $data['email'] ?? '';
  $phone = $data['phone'] ?? '';
  $course = $data['course'] ?? $data['category'] ?? '';
  $eventName = $settings->event_name ?? 'Conference';
  $qrData = url('/staff/front-desk') . '?scan=' . $submission->qr_token;
@endphp

<div class="badge" id="badge">
  <div class="badge-header">
    @if($settings?->badge_logo_path)
    <img src="{{ asset('storage/'.$settings->badge_logo_path) }}" style="height:28px;object-fit:contain;display:block;margin:0 auto 6px;">
    @endif
    <div class="event-name">{{ $eventName }}</div>
  </div>

  <div class="badge-body">
    <div class="qr-area">
      <canvas id="qr-canvas"></canvas>
    </div>

    <div class="participant-name">{{ $name }}</div>
    <div class="participant-id">{{ $submission->participant_id ?? 'NO ID' }}</div>

    <div class="badge-detail">
      @if($email)<div>{{ $email }}</div>@endif
      @if($phone)<div>{{ $phone }}</div>@endif
      @if($course)<div style="color:{{ $settings->badge_accent_color ?? '#3ee07f' }};margin-top:4px;">{{ $course }}</div>@endif
    </div>
  </div>

  <div class="badge-footer">{{ $settings->event_date?->format('d M Y') ?? '' }} &nbsp;·&nbsp; {{ $settings->event_venue ?? '' }}</div>
</div>

<div class="no-print" style="position:fixed;bottom:20px;left:50%;transform:translateX(-50%);display:flex;gap:10px;">
  <button onclick="window.print()"
    style="padding:10px 24px;background:#3ee07f;color:#0a1628;border:none;border-radius:4px;font-weight:700;cursor:pointer;font-size:14px;">
    🖨 Print Badge
  </button>
  <button onclick="window.history.back()"
    style="padding:10px 24px;background:#4a5568;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px;">
    ← Back
  </button>
</div>

<script>
// Inline QR code generation using qrcode-generator
// Using Google Charts API for QR (no external package needed)
(function() {
  var canvas = document.getElementById('qr-canvas');
  var qrData = {{ json_encode($submission->qr_token ?? $submission->participant_id ?? '') }};
  var size = 140;
  canvas.width = size;
  canvas.height = size;

  var img = new Image();
  img.onload = function() { canvas.getContext('2d').drawImage(img, 0, 0, size, size); };
  img.onerror = function() {
    // Fallback: just show the token as text
    canvas.getContext('2d').fillStyle='#fff';
    canvas.getContext('2d').fillRect(0,0,size,size);
    canvas.getContext('2d').fillStyle='#0a1628';
    canvas.getContext('2d').font='8px monospace';
    canvas.getContext('2d').fillText(qrData.substring(0,30), 4, 14);
  };
  // Use Google Charts QR API
  img.src = 'https://chart.googleapis.com/chart?cht=qr&chs=' + size + 'x' + size + '&chl=' + encodeURIComponent(qrData) + '&choe=UTF-8';
})();
</script>

</body>
</html>
