<x-admin-layout title="Create Form">
<div class="section-header">
  <span class="section-title">Create Form</span>
  <a href="{{ route('admin.forms.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.forms.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Form Name *</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Contact Form"></div>
    <div class="form-group"><label class="form-label">Slug (auto-generated if empty)</label><input type="text" name="slug" class="form-input" value="{{ old('slug') }}" placeholder="contact-form"></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="2">{{ old('description') }}</textarea></div>
    <div class="form-group"><label class="form-label">Success Message</label><textarea name="success_message" class="form-input" rows="2">{{ old('success_message', 'Thank you! We will get back to you soon.') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Redirect URL (optional)</label><input type="text" name="redirect_url" class="form-input" value="{{ old('redirect_url') }}" placeholder="/thank-you"></div>
      <div class="form-group"><label class="form-label">Notification Email</label><input type="email" name="notification_email" class="form-input" value="{{ old('notification_email') }}"></div>
    </div>
    <div style="display:flex;gap:24px;margin-bottom:16px;">
      <label class="form-check"><input type="checkbox" name="store_submissions" value="1" checked> Store Submissions</label>
      <label class="form-check"><input type="checkbox" name="is_active" value="1" checked> Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Create & Add Fields →</button>
  </form>
</div>
</x-admin-layout>
