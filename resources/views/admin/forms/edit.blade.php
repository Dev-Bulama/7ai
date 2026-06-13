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
    <form method="POST" action="{{ route('admin.forms.fields.store', $form) }}" id="add-field-form">
      @csrf
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Label *</label><input type="text" name="label" class="form-input" required placeholder="Full Name"></div>
        <div class="form-group"><label class="form-label">Field Name * <span style="font-weight:300;color:var(--gray-400);">(lowercase, no spaces)</span></label><input type="text" name="name" class="form-input" required placeholder="full_name" pattern="[a-z_][a-z0-9_]*"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Field Type *</label>
          <select name="field_type" class="form-input" id="field-type-select">
            <option value="text">Text</option>
            <option value="email">Email</option>
            <option value="phone">Phone / Tel</option>
            <option value="number">Number</option>
            <option value="textarea">Textarea (multi-line)</option>
            <option value="select">Dropdown / Select</option>
            <option value="radio">Radio Buttons</option>
            <option value="checkbox">Checkboxes (multi-select)</option>
            <option value="file">File Upload</option>
            <option value="date">Date</option>
            <option value="hidden">Hidden</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Placeholder text</label><input type="text" name="placeholder" class="form-input" placeholder="e.g. Enter your full name"></div>
      </div>
      <div class="form-group" id="options-group" style="display:none;">
        <label class="form-label">Options <span style="font-weight:300;color:var(--gray-400);">(one per line — for dropdown, radio, checkboxes)</span></label>
        <textarea name="options" class="form-input" rows="5" placeholder="Consultation&#10;Training&#10;Partnership&#10;Support&#10;Other"></textarea>
      </div>
      <div class="form-group"><label class="form-label">Help Text <span style="font-weight:300;color:var(--gray-400);">(optional hint shown under field)</span></label><input type="text" name="help_text" class="form-input"></div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ ($form->fields->max('sort_order') ?? 0) + 10 }}"></div>
        <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_required" value="1"> Required field</label></div>
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Add Field</button>
    </form>
  </div>
</div>

{{-- Welcome Email --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:4px;font-size:14px;">Welcome Email</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Send an automatic welcome email to each registrant. Requires SMTP to be configured in <a href="{{ route('admin.settings.index') }}" style="color:var(--teal);">Settings → Email</a>.</p>
  <form method="POST" action="{{ route('admin.forms.update', $form) }}">
    @csrf @method('PUT')
    {{-- Re-send existing non-email fields so we don't blank them out --}}
    <input type="hidden" name="name" value="{{ $form->name }}">
    <input type="hidden" name="slug" value="{{ $form->slug }}">
    <input type="hidden" name="public_path" value="{{ $form->public_path }}">
    <input type="hidden" name="title" value="{{ $form->title }}">
    <input type="hidden" name="subtitle" value="{{ $form->subtitle }}">
    <input type="hidden" name="success_message" value="{{ $form->success_message }}">
    <input type="hidden" name="redirect_url" value="{{ $form->redirect_url }}">
    <input type="hidden" name="notification_email" value="{{ $form->notification_email }}">
    @if($form->store_submissions)<input type="hidden" name="store_submissions" value="1">@endif
    @if($form->is_active)<input type="hidden" name="is_active" value="1">@endif

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
      <label class="form-check" style="font-size:14px;font-weight:600;">
        <input type="checkbox" name="welcome_email_enabled" value="1" {{ $form->welcome_email_enabled ? 'checked' : '' }}
          id="email-toggle" onchange="document.getElementById('email-config').style.display=this.checked?'block':'none'">
        Enable welcome email on registration
      </label>
    </div>

    <div id="email-config" style="display:{{ $form->welcome_email_enabled ? 'block' : 'none' }};">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Email Field <span style="font-weight:400;color:var(--gray-400);">(which field contains the registrant's email)</span></label>
          <select name="welcome_email_field" class="form-input">
            <option value="">— Auto-detect first email field —</option>
            @foreach($form->fields->where('is_active', true) as $f)
            <option value="{{ $f->name }}" {{ $form->welcome_email_field === $f->name ? 'selected' : '' }}>{{ $f->label }} ({{ $f->name }})</option>
            @endforeach
          </select>
        </div>
        <div class="form-group"><label class="form-label">Email Subject</label><input type="text" name="welcome_email_subject" class="form-input" value="{{ old('welcome_email_subject', $form->welcome_email_subject) }}" placeholder="Welcome to the Abuja AI Conference!"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">From Name <span style="font-weight:400;color:var(--gray-400);">(leave blank to use global setting)</span></label><input type="text" name="welcome_email_from_name" class="form-input" value="{{ old('welcome_email_from_name', $form->welcome_email_from_name) }}" placeholder="7AI"></div>
        <div class="form-group"><label class="form-label">From Email Address</label><input type="email" name="welcome_email_from_address" class="form-input" value="{{ old('welcome_email_from_address', $form->welcome_email_from_address) }}" placeholder="hello@7ai.africa"></div>
      </div>
      <div class="form-group">
        <label class="form-label">Email Body (HTML supported — you can use inline CSS or Tailwind via CDN)</label>
        <textarea name="welcome_email_body" class="form-input" rows="16" style="font-family:monospace;font-size:13px;" placeholder="<h1>Welcome!</h1><p>Thank you for registering...</p>">{{ old('welcome_email_body', $form->welcome_email_body) }}</textarea>
        <p style="font-size:12px;color:var(--gray-400);margin-top:6px;">Full HTML is supported. Use inline styles for maximum email client compatibility. To use Tailwind, add <code>&lt;link href=&quot;https://cdn.tailwindcss.com&quot; rel=&quot;stylesheet&quot;&gt;</code> at the top.</p>
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Save Email Settings</button>
  </form>
</div>

<div style="background:var(--gray-100);border-radius:8px;padding:16px;font-size:13px;color:var(--gray-600);">
  <strong>Form Shortcode:</strong> Use <code style="background:var(--white);padding:2px 8px;border-radius:4px;font-size:12px;">[form:{{ $form->slug }}]</code> to embed this form in page content, or reference it via <code>/forms/{{ $form->slug }}/submit</code>
</div>

<script>
(function () {
  var sel = document.getElementById('field-type-select');
  var og  = document.getElementById('options-group');
  function toggleOptions() {
    og.style.display = ['select','radio','checkbox'].includes(sel.value) ? 'block' : 'none';
  }
  sel.addEventListener('change', toggleOptions);
  toggleOptions(); // run on page load in case browser restores a previous value

  // Auto-fill field name from label (snake_case)
  var labelInput = document.querySelector('#add-field-form input[name="label"]');
  var nameInput  = document.querySelector('#add-field-form input[name="name"]');
  if (labelInput && nameInput) {
    labelInput.addEventListener('input', function () {
      if (!nameInput._dirty) {
        nameInput.value = labelInput.value.toLowerCase()
          .replace(/[^a-z0-9]+/g, '_')
          .replace(/^_+|_+$/g, '');
      }
    });
    nameInput.addEventListener('input', function () { nameInput._dirty = true; });
  }
})();
</script>
</x-admin-layout>
