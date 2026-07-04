<x-admin-layout :title="'Scan Logs — '.$form->name">
<div style="padding:32px;max-width:1000px;">

  <div style="margin-bottom:24px;">
    <div style="font-size:12px;color:#718096;margin-bottom:4px;">
      <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      <a href="{{ route('admin.conference.participants', $form) }}" style="color:#3182ce;text-decoration:none;">{{ $form->name }}</a> /
    </div>
    <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">Scan Logs</h1>
  </div>

  <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:#f7fafc;">
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Time</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Action</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Participant</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">Scanned By</th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#4a5568;border-bottom:1px solid #e2e8f0;">IP</th>
        </tr>
      </thead>
      <tbody>
        @forelse($logs as $log)
        @php
          $actionColors = ['check_in'=>['#ebf8ff','#2b6cb0'],'lunch'=>['#fffaf0','#c05621'],'manual_verify'=>['#f0fff4','#276749'],'badge_print'=>['#faf5ff','#553c9a']];
          [$bg,$fg] = $actionColors[$log->action] ?? ['#f7fafc','#4a5568'];
        @endphp
        <tr style="border-bottom:1px solid #f0f4f8;">
          <td style="padding:10px 14px;color:#718096;font-size:12px;">{{ $log->scanned_at->format('d/m H:i:s') }}</td>
          <td style="padding:10px 14px;">
            <span style="background:{{ $bg }};color:{{ $fg }};padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;text-transform:uppercase;">
              {{ str_replace('_', ' ', $log->action) }}
            </span>
          </td>
          <td style="padding:10px 14px;font-family:monospace;color:#553c9a;font-size:12px;">
            {{ $log->submission?->participant_id ?? '#'.$log->form_submission_id }}
          </td>
          <td style="padding:10px 14px;color:#4a5568;">{{ $log->scanner?->name ?? '—' }}</td>
          <td style="padding:10px 14px;color:#a0aec0;font-size:12px;">{{ $log->ip_address }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="padding:40px;text-align:center;color:#a0aec0;">No scan logs yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:16px;">{{ $logs->links() }}</div>

</div>
</x-admin-layout>
