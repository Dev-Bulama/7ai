<x-admin-layout title="Edit Form">
<div class="section-header">
  <span class="section-title">Edit Form: {{ $form->name }}</span>
  <a href="{{ route('admin.forms.index') }}" class="btn btn-outline btn-sm">← All Forms</a>
</div>

{{-- Form Settings --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:16px;font-size:14px;">Form Settings</div>
  @if($form->public_path)
  <div style="background:var(--gray-50);border:1px solid var(--gray-200);border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:var(--gray-600);">
    📎 Public URL: <a href="{{ $form->public_path }}" target="_blank" style="color:var(--teal);font-weight:600;">{{ request()->getSchemeAndHttpHost() }}{{ $form->public_path }}</a>
  </div>
  @endif
  <form method="POST" action="{{ route('admin.forms.update', $form) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Form Name *</label><input type="text" name="name" class="form-input" value="{{ old('name', $form->name) }}" required></div>
      <div class="form-group"><label class="form-label">Slug</label><input type="text" name="slug" class="form-input" value="{{ old('slug', $form->slug) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Public URL Path <span style="font-weight:400;color:var(--gray-400);">(e.g. /abuja)</span></label>
        <input type="text" name="public_path" class="form-input" value="{{ old('public_path', $form->public_path) }}" placeholder="/abuja">
      </div>
      <div class="form-group"><label class="form-label">Page Title</label><input type="text" name="title" class="form-input" value="{{ old('title', $form->title) }}"></div>
    </div>
    <div class="form-group"><label class="form-label">Page Subtitle / Tagline</label><input type="text" name="subtitle" class="form-input" value="{{ old('subtitle', $form->subtitle) }}"></div>
    <div class="form-group"><label class="form-label">Success Message</label><textarea name="success_message" class="form-input" rows="2">{{ old('success_message', $form->success_message) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Redirect URL</label><input type="text" name="redirect_url" class="form-input" value="{{ old('redirect_url', $form->redirect_url) }}"></div>
      <div class="form-group"><label class="form-label">Notification Email</label><input type="email" name="notification_email" class="form-input" value="{{ old('notification_email', $form->notification_email) }}"></div>
    </div>
    <div style="display:flex;gap:24px;margin-bottom:16px;">
      <label class="form-check"><input type="checkbox" name="store_submissions" value="1" {{ old('store_submissions', $form->store_submissions) ? 'checked' : '' }}> Store Submissions</label>
      <label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $form->is_active) ? 'checked' : '' }}> Active</label>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Save Settings</button>
  </form>
</div>

{{-- Form Fields --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:16px;font-size:14px;">Form Fields ({{ $form->fields->count() }})</div>
  @if($form->fields->isNotEmpty())
  <div class="table-wrap" style="margin-bottom:20px;">
    <table>
      <thead><tr><th>Label</th><th>Name</th><th>Type</th><th>Required</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($form->fields as $field)
        <tr>
          <td>{{ $field->label }}</td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $field->name }}</td>
          <td><span class="badge badge-teal">{{ $field->field_type }}</span></td>
          <td>{{ $field->is_required ? '✓' : '—' }}</td>
          <td>{{ $field->sort_order }}</td>
          <td><span class="badge {{ $field->is_active ? 'badge-green' : 'badge-gray' }}">{{ $field->is_active ? 'On' : 'Off' }}</span></td>
          <td>
            <form method="POST" action="{{ route('admin.forms.fields.destroy', [$form, $field]) }}" style="display:inline;" onsubmit="return confirm('Delete field?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Add Field Form --}}
  <div style="background:var(--gray-50);border:1px solid var(--gray-200);border-radius:8px;padding:20px;">
    <div style="font-weight:600;margin-bottom:14px;font-size:13px;color:var(--gray-700);">Add New Field</div>
    <form method="POST" action="{{ route('admin.forms.fields.store', $form) }}">
      @csrf
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Label *</label><input type="text" name="label" class="form-input" required placeholder="Your Name"></div>
        <div class="form-group"><label class="form-label">Field Name *</label><input type="text" name="name" class="form-input" required placeholder="your_name" pattern="[a-z_][a-z0-9_]*"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Field Type *</label>
          <select name="field_type" class="form-input" id="field-type-select">
            @foreach(['text','email','phone','number','textarea','select','radio','checkbox','file','date','hidden'] as $ft)
            <option value="{{ $ft }}">{{ ucfirst($ft) }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group"><label class="form-label">Placeholder</label><input type="text" name="placeholder" class="form-input"></div>
      </div>
      <div class="form-group" id="options-group" style="display:none;"><label class="form-label">Options (one per line)</label><textarea name="options" class="form-input" rows="4" placeholder="Option 1&#10;Option 2&#10;Option 3"></textarea></div>
      <div class="form-group"><label class="form-label">Help Text</label><input type="text" name="help_text" class="form-input"></div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ $form->fields->count() * 10 }}"></div>
        <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_required" value="1"> Required</label></div>
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Add Field</button>
    </form>
  </div>
</div>

<div style="background:var(--gray-100);border-radius:8px;padding:16px;font-size:13px;color:var(--gray-600);">
  <strong>Form Shortcode:</strong> Use <code style="background:var(--white);padding:2px 8px;border-radius:4px;font-size:12px;">[form:{{ $form->slug }}]</code> to embed this form in page content, or reference it via <code>/forms/{{ $form->slug }}/submit</code>
</div>

<script>
document.getElementById('field-type-select').addEventListener('change', function(){
  var g = document.getElementById('options-group');
  g.style.display = ['select','radio','checkbox'].includes(this.value) ? 'block' : 'none';
});
</script>
</x-admin-layout>
