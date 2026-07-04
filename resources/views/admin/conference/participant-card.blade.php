<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Badge — {{ $submission->participant_id }}</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box;
        -webkit-print-color-adjust:exact !important;
        print-color-adjust:exact !important; }
    body {
      background:#e8e8e8;
      display:flex; flex-direction:column;
      align-items:center; justify-content:flex-start;
      min-height:100vh; padding:30px 20px;
      font-family:Arial,Helvetica,sans-serif;
    }
    .actions {
      display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap; justify-content:center;
    }
    .btn {
      padding:10px 22px; border:none; border-radius:5px;
      font-weight:700; cursor:pointer; font-size:14px;
      text-decoration:none; display:inline-block;
    }
    .btn-print { background:#276749; color:#fff; }
    .btn-back  { background:#4a5568; color:#fff; }
    .btn-edit  { background:#3182ce; color:#fff; }
    @media print {
      * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
      body { background:white; padding:0; justify-content:center; }
      .actions { display:none !important; }
    }
  </style>
</head>
<body>

<div class="actions">
  <button onclick="window.print()" class="btn btn-print">🖨 Print Badge</button>
  <a href="{{ route('admin.conference.settings', $form) }}" class="btn btn-edit">✏ Edit Badge Design</a>
  <button onclick="window.history.back()" class="btn btn-back">← Back</button>
</div>

{!! $badgeHtml !!}

</body>
</html>
