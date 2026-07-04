<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Export — {{ $form->name }}</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:#f5f5f5; font-family:Arial,Helvetica,sans-serif; padding:20px; }
    .page-header {
      display:flex; align-items:center; justify-content:space-between;
      margin-bottom:20px; padding:16px 20px;
      background:#fff; border-radius:8px; border:1px solid #ddd;
    }
    .page-header h1 { font-size:18px; font-weight:700; color:#1a202c; }
    .page-header p { font-size:13px; color:#718096; margin-top:2px; }
    .btn { padding:10px 20px; border:none; border-radius:4px; cursor:pointer; font-size:13px; font-weight:600; text-decoration:none; display:inline-block; }
    .btn-green { background:#276749; color:#fff; }
    .btn-blue  { background:#3182ce; color:#fff; }
    .btn-gray  { background:#4a5568; color:#fff; }
    .grid {
      display:grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap:16px;
    }
    .badge-card {
      background:#fff;
      border:1px solid #ddd;
      border-radius:8px;
      overflow:hidden;
      break-inside:avoid;
      page-break-inside:avoid;
    }
    .badge-header {
      background: {{ $settings->badge_accent_color ?? '#3ee07f' }};
      padding:10px 14px; text-align:center;
      font-size:11px; font-weight:700;
      color: #0a1628;
      letter-spacing:0.08em; text-transform:uppercase;
    }
    .badge-body { padding:14px; text-align:center; }
    .badge-body .qr-wrap {
      background:#f9f9f9; border:1px solid #eee;
      border-radius:4px; padding:8px;
      display:inline-block; margin-bottom:10px;
    }
    .badge-body .name { font-size:14px; font-weight:700; color:#1a202c; margin-bottom:2px; }
    .badge-body .pid  { font-family:monospace; font-size:11px; color:#553c9a; font-weight:700; margin-bottom:4px; }
    .badge-body .detail { font-size:11px; color:#718096; line-height:1.6; }
    .badge-footer {
      background:#f7fafc; border-top:1px solid #eee;
      padding:6px 14px; text-align:center;
      font-size:10px; color:#a0aec0; font-family:monospace;
    }
    .no-qr { background:#fff5f5; border-radius:4px; padding:40px; text-align:center; color:#c53030; font-size:13px; margin:10px; }
    @media print {
      body { background:white; padding:10px; }
      .page-header { display:none !important; }
      .grid { grid-template-columns: repeat(3, 1fr); gap:10px; }
      .badge-card { border:1px solid #ccc; }
    }
  </style>
</head>
<body>

<div class="page-header">
  <div>
    <h1>QR Code Export — {{ $form->name }}</h1>
    <p>{{ $submissions->count() }} participants with QR codes
       @if($settings?->event_date) · {{ $settings->event_date->format('d M Y') }} @endif
    </p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <button class="btn btn-green" onclick="window.print()">🖨 Print All Badges</button>
    <a href="{{ route('admin.conference.export-participants', $form) }}" class="btn btn-blue">⬇ CSV Export</a>
    <a href="{{ route('admin.conference.participants', $form) }}" class="btn btn-gray">← Back</a>
  </div>
</div>

@if($submissions->isEmpty())
<div class="no-qr">
  No participants have QR tokens yet.<br>
  Run: <code style="background:#fff;padding:2px 8px;border-radius:3px;">php artisan conference:generate-participant-qrcodes --form={{ $form->slug }}</code>
</div>
@else
<div class="grid">
  @foreach($submissions as $sub)
  @php
    $data  = $sub->data ?? [];
    $name  = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: 'Participant';
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $course= $data['course'] ?? '';
    try { $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(130)->errorCorrection('M')->generate($sub->qr_token); } catch(\Throwable $e) { $qrSvg = null; }
  @endphp
  <div class="badge-card">
    <div class="badge-header">
      {{ $settings->event_name ?? $form->name }}
    </div>
    <div class="badge-body">
      <div class="qr-wrap">
        @if($qrSvg)
          {!! $qrSvg !!}
        @else
          <div style="width:130px;height:130px;display:flex;align-items:center;justify-content:center;color:#c53030;font-size:11px;">QR Error</div>
        @endif
      </div>
      <div class="name">{{ $name }}</div>
      <div class="pid">{{ $sub->participant_id ?? 'NO-ID' }}</div>
      <div class="detail">
        @if($email){{ $email }}<br>@endif
        @if($phone){{ $phone }}<br>@endif
        @if($course)<span style="color:#553c9a;font-weight:600;">{{ $course }}</span>@endif
      </div>
    </div>
    <div class="badge-footer">
      @if($sub->attendance_verified)
        ✓ CHECKED IN {{ $sub->checked_in_at?->format('H:i') }}
      @else
        NOT YET CHECKED IN
      @endif
    </div>
  </div>
  @endforeach
</div>
@endif

</body>
</html>
