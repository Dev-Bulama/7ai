<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Badge Export — {{ $form->name }}</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box;
        -webkit-print-color-adjust:exact !important;
        print-color-adjust:exact !important; }
    body { background:#f5f5f5; font-family:Arial,Helvetica,sans-serif; padding:20px; }
    .page-header {
      display:flex; align-items:center; justify-content:space-between;
      margin-bottom:20px; padding:16px 20px;
      background:#fff; border-radius:8px; border:1px solid #ddd; flex-wrap:wrap; gap:12px;
    }
    .page-header h1 { font-size:18px; font-weight:700; color:#1a202c; }
    .page-header p { font-size:13px; color:#718096; margin-top:2px; }
    .btn { padding:10px 20px; border:none; border-radius:4px; cursor:pointer; font-size:13px; font-weight:600; text-decoration:none; display:inline-block; }
    .btn-green { background:#276749; color:#fff; }
    .btn-blue  { background:#3182ce; color:#fff; }
    .btn-gray  { background:#4a5568; color:#fff; }
    .badge-grid {
      display:grid;
      grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));
      gap:20px;
    }
    .no-badges { background:#fff5f5; border-radius:8px; padding:60px 20px; text-align:center; color:#c53030; font-size:14px; }
    @media print {
      * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
      body { background:white; padding:10px; }
      .page-header { display:none !important; }
      .badge-grid { grid-template-columns:repeat(3, 1fr); gap:12px; }
    }
  </style>
</head>
<body>

<div class="page-header">
  <div>
    <h1>QR Badge Export — {{ $form->name }}</h1>
    <p>{{ $submissions->count() }} badges
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
<div class="no-badges">
  No participants with QR codes yet.<br>
  Run: <code style="background:#fff;padding:2px 8px;border-radius:3px;font-size:12px;">php artisan conference:generate-participant-qrcodes --form={{ $form->slug }}</code>
</div>
@else
<div class="badge-grid">
  @foreach($badges as $badgeHtml)
    <div>{!! $badgeHtml !!}</div>
  @endforeach
</div>
@endif

</body>
</html>
