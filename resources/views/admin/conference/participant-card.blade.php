<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participant Badge — {{ $submission->participant_id }}</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:#e8e8e8; display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:100vh; font-family:Arial,Helvetica,sans-serif; }
    .badge {
      width:85mm; min-height:120mm;
      background: {{ $settings->badge_bg_color ?? '#0a1628' }};
      border-radius:8px; overflow:hidden;
      box-shadow:0 6px 24px rgba(0,0,0,0.3);
    }
    .badge-header { background: {{ $settings->badge_accent_color ?? '#3ee07f' }}; padding:18px 20px 14px; text-align:center; }
    .event-name { font-size:13px; font-weight:700; color:#0a1628; letter-spacing:0.08em; text-transform:uppercase; }
    .badge-body { padding:20px; }
    .qr-area { display:flex; justify-content:center; margin-bottom:14px; }
    .qr-area svg, .qr-area img { background:#fff; padding:6px; border-radius:4px; display:block; }
    .participant-name { font-size:20px; font-weight:700; color:#fff; text-align:center; line-height:1.2; margin-bottom:6px; }
    .participant-id { font-family:monospace; font-size:11px; color: {{ $settings->badge_accent_color ?? '#3ee07f' }}; text-align:center; letter-spacing:0.12em; margin-bottom:14px; }
    .badge-detail { font-size:11px; color:rgba(255,255,255,0.6); text-align:center; line-height:1.8; }
    .badge-footer { border-top:1px solid rgba(255,255,255,0.1); padding:10px 20px; text-align:center; font-family:monospace; font-size:9px; color:rgba(255,255,255,0.3); letter-spacing:0.1em; }
    .actions { margin-top:24px; display:flex; gap:10px; }
    .btn { padding:10px 24px; border:none; border-radius:4px; font-weight:700; cursor:pointer; font-size:14px; }
    @media print {
      body { background:white; justify-content:flex-start; }
      .actions { display:none !important; }
      .badge { box-shadow:none; }
    }
  </style>
</head>
<body>

@php
  use SimpleSoftwareIO\QrCode\Facades\QrCode;

  $data      = $submission->data ?? [];
  $name      = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: 'Participant';
  $email     = $data['email'] ?? '';
  $phone     = $data['phone'] ?? '';
  $course    = $data['course'] ?? $data['category'] ?? '';
  $eventName = $settings->event_name ?? 'Conference';
  $qrValue   = $submission->qr_token ?? $submission->participant_id ?? (string)$submission->id;

  try {
      $qrSvg = QrCode::format('svg')->size(140)->errorCorrection('M')->generate($qrValue);
  } catch (\Throwable $e) {
      $qrSvg = null;
  }
@endphp

<div class="badge">
  <div class="badge-header">
    @if($settings?->badge_logo_path)
    <img src="{{ asset('storage/'.$settings->badge_logo_path) }}" style="height:28px;object-fit:contain;display:block;margin:0 auto 6px;" onerror="this.style.display='none'">
    @endif
    <div class="event-name">{{ $eventName }}</div>
  </div>

  <div class="badge-body">
    <div class="qr-area">
      @if($qrSvg)
        {!! $qrSvg !!}
      @else
        <div style="width:140px;height:140px;background:#fff;display:flex;align-items:center;justify-content:center;border-radius:4px;">
          <span style="color:#333;font-size:9px;font-family:monospace;text-align:center;padding:4px;">{{ $qrValue }}</span>
        </div>
      @endif
    </div>

    <div class="participant-name">{{ $name }}</div>
    <div class="participant-id">{{ $submission->participant_id ?? 'NO-ID' }}</div>

    <div class="badge-detail">
      @if($email)<div>{{ $email }}</div>@endif
      @if($phone)<div>{{ $phone }}</div>@endif
      @if($course)<div style="color:{{ $settings->badge_accent_color ?? '#3ee07f' }};margin-top:4px;">{{ $course }}</div>@endif
    </div>
  </div>

  <div class="badge-footer">
    {{ $settings->event_date?->format('d M Y') ?? '' }}@if($settings?->event_venue) &nbsp;·&nbsp; {{ $settings->event_venue }}@endif
  </div>
</div>

<div class="actions">
  <button onclick="window.print()" style="background:#3ee07f;color:#0a1628;" class="btn">🖨 Print Badge</button>
  <button onclick="window.history.back()" style="background:#4a5568;color:#fff;" class="btn">← Back</button>
</div>

</body>
</html>
