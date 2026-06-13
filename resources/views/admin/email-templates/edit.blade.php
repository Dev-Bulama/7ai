<x-admin-layout title="Edit Email Template">
<div class="section-header">
  <span class="section-title">{{ $emailTemplate->name }}</span>
  <div style="display:flex;gap:8px;">
    <form method="POST" action="{{ route('admin.email-templates.reset', $emailTemplate) }}" onsubmit="return confirm('Reset to default content?')">
      @csrf @method('PATCH')
      <button type="submit" class="btn btn-outline btn-sm">Reset to default</button>
    </form>
    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-outline btn-sm">← All Templates</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start;max-width:1100px;">

<div>
<form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate) }}">
@csrf @method('PUT')
<div class="card" style="margin-bottom:20px;">
  <div class="form-group"><label class="form-label">Subject *</label><input type="text" name="subject" class="form-input" value="{{ old('subject', $emailTemplate->subject) }}" required></div>
  <div class="form-group">
    <label class="form-label">Email Body (HTML)</label>
    <textarea name="body" class="form-input" rows="22" style="font-family:monospace;font-size:12px;line-height:1.6;">{{ old('body', $emailTemplate->body) }}</textarea>
  </div>
  <div style="display:flex;align-items:center;gap:20px;">
    <button type="submit" class="btn btn-primary">Save Template</button>
    <label class="form-check">
      <input type="checkbox" name="is_active" value="1" {{ $emailTemplate->is_active ? 'checked' : '' }}>
      Active
    </label>
  </div>
</div>
</form>
</div>

<div style="position:sticky;top:80px;">
  <div class="card">
    <div style="font-weight:700;font-size:13px;margin-bottom:12px;">Available Variables</div>
    <p style="font-size:12px;color:var(--gray-500);margin-bottom:14px;">Use these in the subject and body:</p>
    @foreach([
      '{{name}}'         => "User's full name",
      '{{email}}'        => "User's email address",
      '{{login_url}}'    => "Link to login/dashboard",
      '{{site_name}}'    => "Your site name",
      '{{support_email}}'=> "Support email address",
      '{{current_year}}' => "Current year (e.g. 2026)",
    ] as $var => $desc)
    <div style="margin-bottom:10px;">
      <code style="display:block;font-size:11px;background:var(--gray-100);padding:4px 8px;border-radius:3px;margin-bottom:3px;cursor:pointer;" onclick="navigator.clipboard.writeText('{{ $var }}')">{{ $var }}</code>
      <span style="font-size:11px;color:var(--gray-500);">{{ $desc }}</span>
    </div>
    @endforeach
    <p style="font-size:11px;color:var(--gray-400);margin-top:12px;">Click a variable to copy it.</p>
  </div>
</div>

</div>

@push('scripts')
<style>@media(max-width:900px){.grid-split{grid-template-columns:1fr!important;}}</style>
@endpush
</x-admin-layout>
