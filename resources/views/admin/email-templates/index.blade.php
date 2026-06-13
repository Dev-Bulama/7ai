<x-admin-layout title="Email Templates">
<div class="section-header">
  <span class="section-title">Email Templates</span>
</div>
<div class="card">
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:20px;">These templates are used for automated emails sent by the system. Edit the subject and body for each template. Supported variables are shown on the edit page.</p>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Template</th><th>Key</th><th>Subject</th><th>Status</th><th>Updated</th><th></th></tr></thead>
      <tbody>
        @foreach($templates as $t)
        <tr>
          <td><strong>{{ $t->name }}</strong></td>
          <td><code style="font-size:11px;background:var(--gray-100);padding:2px 6px;border-radius:3px;">{{ $t->key }}</code></td>
          <td style="font-size:13px;color:var(--gray-600);">{{ Str::limit($t->subject, 60) }}</td>
          <td><span class="badge {{ $t->is_active ? 'badge-green' : 'badge-gray' }}">{{ $t->is_active ? 'Active' : 'Off' }}</span></td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $t->updated_at->format('M d, Y') }}</td>
          <td><a href="{{ route('admin.email-templates.edit', $t) }}" class="btn btn-outline btn-sm">Edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</x-admin-layout>
