<x-admin-layout title="SMTP Diagnostics">
<div class="section-header">
  <span class="section-title">SMTP Diagnostics</span>
  <a href="{{ route('admin.settings.index', ['tab' => 'smtp']) }}" class="btn btn-outline btn-sm">← Back to Settings</a>
</div>

{{-- Config check table --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;color:var(--dark);margin-bottom:16px;">
    SMTP Configuration Check
    <span style="margin-left:12px;font-size:12px;font-weight:400;padding:3px 10px;border-radius:20px;
      {{ $diag['all_ok'] ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">
      {{ $diag['all_ok'] ? '✓ All checks passed' : '⚠ Issues found' }}
    </span>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Setting</th><th>Value</th><th>Status</th></tr></thead>
      <tbody>
        @foreach($diag['checks'] as $check)
        <tr>
          <td style="font-weight:500;">{{ $check['label'] }}</td>
          <td style="font-family:monospace;font-size:13px;">{{ $check['value'] ?: '(empty)' }}</td>
          <td>
            <span class="badge {{ $check['ok'] ? 'badge-green' : 'badge-danger' }}">
              {{ $check['ok'] ? '✓ OK' : '✗ Missing' }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Send test email --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;color:var(--dark);margin-bottom:16px;">Send Test Email</div>

  @if($result !== null)
  <div style="padding:14px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;
    {{ $result['ok'] ? 'background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;' : 'background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;' }}">
    {{ $result['ok'] ? '✓ ' : '✗ ' }}{{ $result['message'] }}
  </div>
  @if(!$result['ok'])
  <script>
    console.error("SMTP Test Email Failed:", {{ Js::from($result['message']) }});
  </script>
  @endif
  @endif

  <form method="GET" action="{{ route('admin.settings.smtp-diagnostics') }}">
    <div style="display:flex;gap:12px;align-items:flex-end;">
      <div class="form-group" style="margin:0;flex:1;">
        <label class="form-label">Send test email to</label>
        <input type="email" name="send_to" class="form-input" value="{{ $testTo ?? '' }}" placeholder="your@email.com" required>
      </div>
      <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:1px;">Send Test</button>
    </div>
  </form>
</div>

{{-- Raw config dump (no password) --}}
<div class="card">
  <div style="font-weight:700;font-size:14px;color:var(--dark);margin-bottom:16px;">Active Runtime Config</div>
  <table style="font-size:13px;font-family:monospace;width:100%;border-collapse:collapse;">
    @foreach([
      'mail.default'                  => config('mail.default'),
      'mail.mailers.smtp.host'        => config('mail.mailers.smtp.host'),
      'mail.mailers.smtp.port'        => config('mail.mailers.smtp.port'),
      'mail.mailers.smtp.encryption'  => config('mail.mailers.smtp.encryption'),
      'mail.mailers.smtp.username'    => config('mail.mailers.smtp.username'),
      'mail.mailers.smtp.password'    => config('mail.mailers.smtp.password') ? '(set)' : '(empty)',
      'mail.from.address'             => config('mail.from.address'),
      'mail.from.name'                => config('mail.from.name'),
    ] as $key => $val)
    <tr style="border-bottom:1px solid var(--gray-100);">
      <td style="padding:6px 0;color:var(--gray-500);width:280px;">{{ $key }}</td>
      <td style="padding:6px 0;color:var(--dark);">{{ $val ?: '(empty)' }}</td>
    </tr>
    @endforeach
  </table>
  <p style="font-size:12px;color:var(--gray-400);margin-top:12px;">
    Note: This shows the config as loaded by PHP before any runtime override. After saving SMTP settings, the mailer is reconfigured dynamically at send time.
  </p>
</div>
</x-admin-layout>
