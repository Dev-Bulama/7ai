<x-admin-layout title="Email Templates">
<div class="section-header">
  <span class="section-title">Email Templates</span>
</div>

<div class="card" style="margin-bottom:20px;padding:14px 20px;background:var(--gray-50);border:1px solid var(--gray-200);">
  <div style="font-size:13px;color:var(--gray-600);line-height:1.7;">
    <strong style="color:var(--dark);">System templates</strong> are used for automated emails sent by the platform (registration welcome, admin notifications).
    Edit them here to customise what users receive.<br>
    <strong style="color:var(--dark);">Form templates</strong> are configured inside each individual form's settings (Welcome Email tab in Form Builder).
    They are separate from system templates and are NOT managed here.
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>Template Name</th>
          <th>Key</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Updated</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($templates as $t)
        @php
          $isSystem = str_starts_with($t->key, 'user_') || str_starts_with($t->key, 'admin_') || in_array($t->key, ['registration_welcome','password_reset','test_email']);
          $typeLabel = $isSystem ? 'System' : 'Form';
          $typeBadge = $isSystem ? 'badge-teal' : 'badge-gray';
        @endphp
        <tr>
          <td><span class="badge {{ $typeBadge }}" style="font-size:10px;">{{ $typeLabel }}</span></td>
          <td><strong>{{ $t->name }}</strong></td>
          <td><code style="font-size:11px;background:var(--gray-100);padding:2px 6px;border-radius:3px;">{{ $t->key }}</code></td>
          <td style="font-size:13px;color:var(--gray-600);">{{ Str::limit($t->subject, 55) }}</td>
          <td><span class="badge {{ $t->is_active ? 'badge-green' : 'badge-gray' }}">{{ $t->is_active ? 'Active' : 'Off' }}</span></td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $t->updated_at->format('M d, Y') }}</td>
          <td><a href="{{ route('admin.email-templates.edit', $t) }}" class="btn btn-outline btn-sm">Edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div style="margin-top:20px;padding:14px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;font-size:13px;color:#1e40af;">
    <strong>Registration welcome email</strong> — uses the template with key <code style="background:#dbeafe;padding:1px 6px;border-radius:3px;">user_welcome</code>.
    Edit it above to change what new users receive when they register.<br>
    <strong>Admin new user notification</strong> — uses key <code style="background:#dbeafe;padding:1px 6px;border-radius:3px;">admin_new_user</code>.<br><br>
    <strong>Supported variables:</strong>
    <code>@{{name}}</code> &nbsp; <code>@{{email}}</code> &nbsp; <code>@{{login_url}}</code> &nbsp; <code>@{{site_name}}</code> &nbsp; <code>@{{support_email}}</code> &nbsp; <code>@{{current_year}}</code>
  </div>
</div>
</x-admin-layout>
