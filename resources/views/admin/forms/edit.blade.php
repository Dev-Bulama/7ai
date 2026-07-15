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
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Success Popup Heading</label><input type="text" name="success_heading" class="form-input" value="{{ old('success_heading', $form->success_heading) }}" placeholder="You're registered!"></div>
      <div class="form-group"><label class="form-label">Success Message (body text)</label><textarea name="success_message" class="form-input" rows="2">{{ old('success_message', $form->success_message) }}</textarea></div>
    </div>
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

  @if(session('success'))
  <div class="alert alert-success" style="margin-bottom:16px;padding:10px 16px;background:#d1fae5;border:1px solid #6ee7b7;border-radius:6px;font-size:13px;color:#065f46;">
    ✓ {{ session('success') }}
  </div>
  @endif

  @if($form->fields->isNotEmpty())
  <div class="table-wrap" style="margin-bottom:20px;">
    <table>
      <thead>
        <tr>
          <th>Label</th>
          <th>Name</th>
          <th>Type</th>
          <th>Required</th>
          <th>Sort</th>
          <th>Status</th>
          <th style="width:160px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($form->fields->sortBy('sort_order') as $field)
        {{-- View row --}}
        <tr id="field-row-{{ $field->id }}">
          <td style="font-weight:500;">{{ $field->label }}</td>
          <td style="font-size:12px;color:var(--gray-400);font-family:monospace;">{{ $field->name }}</td>
          <td><span class="badge badge-teal">{{ $field->field_type }}</span></td>
          <td>{{ $field->is_required ? '✓' : '—' }}</td>
          <td>{{ $field->sort_order }}</td>
          <td><span class="badge {{ $field->is_active ? 'badge-green' : 'badge-gray' }}">{{ $field->is_active ? 'Active' : 'Off' }}</span></td>
          <td style="white-space:nowrap;">
            <button type="button" class="btn btn-outline btn-sm" onclick="openFieldEdit({{ $field->id }})">Edit</button>
            <form method="POST" action="{{ route('admin.forms.fields.destroy', [$form, $field]) }}" style="display:inline;" onsubmit="return confirm('Delete this field permanently?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>

        {{-- Inline edit panel (hidden by default) --}}
        <tr id="field-edit-{{ $field->id }}" style="display:none;">
          <td colspan="7" style="padding:0;">
            <div style="background:#f0fdf4;border-left:3px solid var(--teal);padding:20px 20px 16px;">
              <div style="font-weight:600;font-size:13px;color:var(--teal);margin-bottom:14px;">✏ Editing: {{ $field->label }}</div>
              <form method="POST" action="{{ route('admin.forms.fields.update', [$form, $field]) }}">
                @csrf @method('PUT')
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px;">
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Label *</label>
                    <input type="text" name="label" class="form-input" value="{{ old('label', $field->label) }}" required>
                  </div>
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Field Name * <span style="font-weight:300;color:var(--gray-400);">(snake_case)</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $field->name) }}" required pattern="[a-z_][a-z0-9_]*">
                  </div>
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Field Type *</label>
                    <select name="field_type" class="form-input field-type-sel" data-target="opts-{{ $field->id }}">
                      @foreach(['text' => 'Text', 'email' => 'Email', 'phone' => 'Phone / Tel', 'number' => 'Number', 'textarea' => 'Textarea', 'select' => 'Dropdown / Select', 'radio' => 'Radio Buttons', 'checkbox' => 'Checkboxes', 'file' => 'File Upload', 'date' => 'Date', 'hidden' => 'Hidden'] as $ft => $ftLabel)
                      <option value="{{ $ft }}" {{ $field->field_type === $ft ? 'selected' : '' }}>{{ $ftLabel }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Placeholder text</label>
                    <input type="text" name="placeholder" class="form-input" value="{{ old('placeholder', $field->placeholder) }}">
                  </div>
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Help Text</label>
                    <input type="text" name="help_text" class="form-input" value="{{ old('help_text', $field->help_text) }}">
                  </div>
                </div>
                <div id="opts-{{ $field->id }}" class="form-group" style="margin-bottom:12px;{{ in_array($field->field_type, ['select','radio','checkbox']) ? '' : 'display:none;' }}">
                  <label class="form-label" style="font-size:11px;">Options <span style="font-weight:300;color:var(--gray-400);">(one per line)</span></label>
                  <textarea name="options" class="form-input options-textarea" id="options-ta-{{ $field->id }}" rows="6"
                    placeholder="Option One&#10;Option Two&#10;Option Three"
                    oninput="buildPriceRows('{{ $field->id }}', this.value)">{{ old('options', $field->options) }}</textarea>
                  {{-- Per-option pricing (only shown when form has payment enabled) --}}
                  @if($form->payment_enabled)
                  <div style="margin-top:10px;padding:12px 14px;background:#f0fdf4;border:1px solid #6ee7b7;border-radius:4px;">
                    <div style="font-size:11px;font-weight:700;color:#065f46;margin-bottom:8px;letter-spacing:.04em;">PER-OPTION PRICING (₦) — leave 0 to use the form's default price</div>
                    <div id="price-rows-{{ $field->id }}" style="display:flex;flex-direction:column;gap:6px;"></div>
                    <input type="hidden" name="option_prices" id="option-prices-json-{{ $field->id }}" value="{{ $field->option_prices ? json_encode($field->option_prices) : '{}' }}">
                  </div>
                  @endif
                </div>
                <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;margin-bottom:14px;">
                  <div class="form-group" style="margin:0;">
                    <label class="form-label" style="font-size:11px;">Sort Order</label>
                    <input type="number" name="sort_order" class="form-input" style="width:80px;" value="{{ old('sort_order', $field->sort_order) }}">
                  </div>
                  <label class="form-check" style="margin-top:18px;"><input type="checkbox" name="is_required" value="1" {{ $field->is_required ? 'checked' : '' }}> Required field</label>
                  <label class="form-check" style="margin-top:18px;"><input type="checkbox" name="is_active" value="1" {{ $field->is_active ? 'checked' : '' }}> Active</label>
                </div>
                <div style="display:flex;gap:10px;">
                  <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                  <button type="button" class="btn btn-outline btn-sm" onclick="closeFieldEdit({{ $field->id }})">Cancel</button>
                </div>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Add New Field --}}
  <div style="background:var(--gray-50);border:1px solid var(--gray-200);border-radius:8px;padding:20px;">
    <div style="font-weight:600;margin-bottom:14px;font-size:13px;color:var(--gray-700);">+ Add New Field</div>
    <form method="POST" action="{{ route('admin.forms.fields.store', $form) }}" id="add-field-form">
      @csrf
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Label *</label><input type="text" name="label" class="form-input" required placeholder="Full Name"></div>
        <div class="form-group"><label class="form-label">Field Name * <span style="font-weight:300;color:var(--gray-400);">(lowercase, no spaces)</span></label><input type="text" name="name" class="form-input" required placeholder="full_name" pattern="[a-z_][a-z0-9_]*"></div>
      </div>
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Field Type *</label>
          <select name="field_type" class="form-input" id="new-field-type-select">
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
      <div class="form-group" id="new-options-group" style="display:none;">
        <label class="form-label">Options <span style="font-weight:300;color:var(--gray-400);">(one per line)</span></label>
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
  <div style="font-weight:700;color:var(--dark);margin-bottom:4px;font-size:14px;">Welcome / Autoresponder Email</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">
    Automatically send a confirmation email to each person who submits this form.
    Requires SMTP to be configured in <a href="{{ route('admin.settings.index', ['tab'=>'smtp']) }}" style="color:var(--teal);">Settings → Email</a>.
    If you leave the body blank, a default thank-you email will be sent.
  </p>
  <form method="POST" action="{{ route('admin.forms.update', $form) }}">
    @csrf @method('PUT')
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
        Enable welcome email after form submission
      </label>
    </div>

    <div id="email-config" style="display:{{ $form->welcome_email_enabled ? 'block' : 'none' }};">

      {{-- Recipient field --}}
      <div class="card" style="background:var(--gray-50);border:1px solid var(--gray-200);margin-bottom:20px;padding:14px 16px;">
        <div style="font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px;">Recipient Email Field</div>
        <p style="font-size:12px;color:var(--gray-500);margin:0 0 10px;">
          Select the form field that contains the submitter's email address. This is who receives the welcome email.
          If left on auto-detect, the system will use a field named <code>email</code> or the first email-type field.
        </p>
        <select name="welcome_email_field" class="form-input" style="max-width:360px;">
          <option value="">— Auto-detect (recommended) —</option>
          @php
            $emailFields = $form->fields->where('is_active', true)->where('field_type', 'email');
            $otherFields = $form->fields->where('is_active', true)->where('field_type', '!=', 'email');
            $currentField = $form->fields->where('is_active', true)->firstWhere('name', $form->welcome_email_field);
            $currentIsNonEmail = $currentField && $currentField->field_type !== 'email';
          @endphp
          @if($emailFields->count())
          <optgroup label="Email fields (recommended)">
            @foreach($emailFields as $f)
            <option value="{{ $f->name }}" {{ $form->welcome_email_field === $f->name ? 'selected' : '' }}>
              {{ $f->label }} — {{ $f->name }}
            </option>
            @endforeach
          </optgroup>
          @endif
          @if($otherFields->count())
          <optgroup label="Other fields">
            @foreach($otherFields as $f)
            <option value="{{ $f->name }}" {{ $form->welcome_email_field === $f->name ? 'selected' : '' }}>
              {{ $f->label }} — {{ $f->name }}
            </option>
            @endforeach
          </optgroup>
          @endif
        </select>
        @if($currentIsNonEmail)
        <div style="margin-top:8px;padding:10px 14px;background:#fef3c7;border:1px solid #fbbf24;border-radius:6px;font-size:12px;color:#92400e;">
          ⚠ <strong>Warning:</strong> The selected field "<strong>{{ $currentField->label }}</strong>" is not an email field — it will not contain a valid email address.
          Please change this to your <strong>Email Address</strong> field, or leave it on Auto-detect.
        </div>
        @endif
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Email Subject</label>
          <input type="text" name="welcome_email_subject" class="form-input"
            value="{{ old('welcome_email_subject', $form->welcome_email_subject) }}"
            placeholder="Thank you for registering — {{ $form->name }}">
          <span style="font-size:11px;color:var(--gray-400);">Leave blank to use default. Supports <code>&#123;&#123;form_name&#125;&#125;</code>, <code>&#123;&#123;name&#125;&#125;</code> etc.</span>
        </div>
        <div class="form-group">
          <label class="form-label">From Name</label>
          <input type="text" name="welcome_email_from_name" class="form-input"
            value="{{ old('welcome_email_from_name', $form->welcome_email_from_name) }}"
            placeholder="{{ \App\Models\Setting::get('mail_from_name', '7AI') }}">
          <span style="font-size:11px;color:var(--gray-400);">Defaults to your global mail From Name in Settings.</span>
        </div>
      </div>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">From Email Address</label>
          <input type="email" name="welcome_email_from_address" class="form-input"
            value="{{ old('welcome_email_from_address', $form->welcome_email_from_address) }}"
            placeholder="{{ \App\Models\Setting::get('mail_from_address', 'hello@7ai.africa') }}">
          <span style="font-size:11px;color:var(--gray-400);">Defaults to your global From Address in Settings.</span>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Email Body <span style="font-weight:400;color:var(--gray-400);">(HTML supported — leave blank for default)</span></label>
        <textarea name="welcome_email_body" class="form-input" rows="14" style="font-family:monospace;font-size:12px;"
          placeholder="<p>Hello &#123;&#123;name&#125;&#125;,</p>&#10;<p>Thank you for registering for &#123;&#123;form_name&#125;&#125;.</p>">{{ old('welcome_email_body', $form->welcome_email_body) }}</textarea>
      </div>

      {{-- Variable reference --}}
      <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:12px 16px;font-size:12px;color:#1e40af;margin-bottom:16px;">
        <strong>Available variables:</strong><br>
        <code>&#123;&#123;name&#125;&#125;</code> &nbsp;
        <code>&#123;&#123;email&#125;&#125;</code> &nbsp;
        <code>&#123;&#123;form_name&#125;&#125;</code> &nbsp;
        <code>&#123;&#123;site_name&#125;&#125;</code> &nbsp;
        <code>&#123;&#123;support_email&#125;&#125;</code> &nbsp;
        <code>&#123;&#123;current_year&#125;&#125;</code> &nbsp;
        + any field name from this form e.g.
        @foreach($form->fields->where('is_active', true)->take(4) as $f)
          <code>&#123;&#123;{{ $f->name }}&#125;&#125;</code>
        @endforeach
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Save Email Settings</button>
  </form>
</div>

{{-- Payment Gateway --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:4px;font-size:14px;">💳 Payment (Paystack)</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">
    Require payment before form submission. Users must pay via Paystack before their registration is accepted.
    Paystack keys must be configured in <a href="{{ route('admin.settings.index', ['tab'=>'payment']) }}" style="color:var(--teal);">Settings → Payment</a>.
  </p>
  <form method="POST" action="{{ route('admin.forms.update', $form) }}">
    @csrf @method('PUT')
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
    @if($form->welcome_email_enabled)<input type="hidden" name="welcome_email_enabled" value="1">@endif
    @if($form->prevent_duplicates)<input type="hidden" name="prevent_duplicates" value="1">@endif
    <input type="hidden" name="duplicate_check_fields" value="{{ $form->duplicate_check_fields }}">

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
      <label class="form-check" style="font-size:14px;font-weight:600;">
        <input type="checkbox" name="payment_enabled" value="1" {{ $form->payment_enabled ? 'checked' : '' }}
          id="payment-toggle" onchange="document.getElementById('payment-config').style.display=this.checked?'block':'none'">
        Require payment before form submission
      </label>
    </div>

    <div id="payment-config" style="display:{{ $form->payment_enabled ? 'block' : 'none' }};">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Amount <span style="font-weight:400;color:var(--gray-400);">(in {{ $form->payment_currency ?: 'NGN' }})</span></label>
          <input type="number" name="payment_amount" class="form-input" step="0.01" min="0"
            value="{{ old('payment_amount', $form->payment_amount) }}" placeholder="5000">
          <span style="font-size:11px;color:var(--gray-400);">Enter the amount in full e.g. 5000 for ₦5,000</span>
        </div>
        <div class="form-group">
          <label class="form-label">Currency</label>
          <select name="payment_currency" class="form-input">
            <option value="NGN" {{ ($form->payment_currency ?: 'NGN') === 'NGN' ? 'selected' : '' }}>NGN — Nigerian Naira (₦)</option>
            <option value="GHS" {{ $form->payment_currency === 'GHS' ? 'selected' : '' }}>GHS — Ghanaian Cedi</option>
            <option value="KES" {{ $form->payment_currency === 'KES' ? 'selected' : '' }}>KES — Kenyan Shilling</option>
            <option value="USD" {{ $form->payment_currency === 'USD' ? 'selected' : '' }}>USD — US Dollar</option>
            <option value="ZAR" {{ $form->payment_currency === 'ZAR' ? 'selected' : '' }}>ZAR — South African Rand</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Payment Description <span style="font-weight:400;color:var(--gray-400);">(shown in Paystack popup)</span></label>
        <input type="text" name="payment_description" class="form-input"
          value="{{ old('payment_description', $form->payment_description) }}"
          placeholder="Abuja AI Conference Registration Fee">
      </div>
      @if(!\App\Models\Setting::get('paystack_public_key'))
      <div style="padding:12px 16px;background:#fef3c7;border:1px solid #fbbf24;border-radius:8px;font-size:13px;color:#92400e;margin-top:4px;">
        ⚠ Paystack keys not configured. Go to <a href="{{ route('admin.settings.index', ['tab'=>'payment']) }}" style="color:#92400e;font-weight:600;">Settings → Payment</a> to add them first.
      </div>
      @endif
    </div>

    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:16px;">Save Payment Settings</button>
  </form>
</div>

{{-- Duplicate Prevention --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:4px;font-size:14px;">🚫 Duplicate Submission Prevention</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">
    Block users from submitting this form more than once using the same email address or phone number.
  </p>
  <form method="POST" action="{{ route('admin.forms.update', $form) }}">
    @csrf @method('PUT')
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
    @if($form->welcome_email_enabled)<input type="hidden" name="welcome_email_enabled" value="1">@endif
    @if($form->payment_enabled)<input type="hidden" name="payment_enabled" value="1">@endif
    <input type="hidden" name="payment_amount" value="{{ $form->payment_amount }}">
    <input type="hidden" name="payment_currency" value="{{ $form->payment_currency ?: 'NGN' }}">
    <input type="hidden" name="payment_description" value="{{ $form->payment_description }}">

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
      <label class="form-check" style="font-size:14px;font-weight:600;">
        <input type="checkbox" name="prevent_duplicates" value="1" {{ $form->prevent_duplicates ? 'checked' : '' }}
          id="dup-toggle" onchange="document.getElementById('dup-config').style.display=this.checked?'block':'none'">
        Block duplicate submissions
      </label>
    </div>

    <div id="dup-config" style="display:{{ $form->prevent_duplicates ? 'block' : 'none' }};">
      <div class="form-group">
        <label class="form-label">Check for duplicates using</label>
        @php $dupFields = explode(',', $form->duplicate_check_fields ?? 'email'); @endphp
        <div style="display:flex;gap:20px;padding-top:6px;">
          <label style="display:flex;align-items:center;gap:8px;font-size:14px;cursor:pointer;">
            <input type="checkbox" name="dup_field_email" value="1" {{ in_array('email',$dupFields) ? 'checked' : '' }} style="width:15px;height:15px;">
            Email address
          </label>
          <label style="display:flex;align-items:center;gap:8px;font-size:14px;cursor:pointer;">
            <input type="checkbox" name="dup_field_phone" value="1" {{ in_array('phone',$dupFields) ? 'checked' : '' }} style="width:15px;height:15px;">
            Phone number
          </label>
        </div>
        <span style="font-size:12px;color:var(--gray-400);display:block;margin-top:6px;">
          If either field matches an existing submission, the new submission is blocked.
        </span>
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:16px;" onclick="buildDupFields()">Save Duplicate Settings</button>
  </form>
</div>

{{-- Conference Mode --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;color:var(--dark);margin-bottom:4px;font-size:14px;">🎪 Conference Mode</div>
  <div style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Enable to unlock participant verification, QR code check-in, lunch scanning, and badge printing for this form.</div>

  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div>
      @if($form->is_conference_form)
        <span style="background:#f0fff4;color:#276749;border:1px solid #9ae6b4;border-radius:4px;padding:4px 12px;font-size:12px;font-weight:600;">✓ Conference Mode Enabled</span>
      @else
        <span style="background:#f7fafc;color:#718096;border:1px solid #e2e8f0;border-radius:4px;padding:4px 12px;font-size:12px;">Conference Mode Disabled</span>
      @endif
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
      <form method="POST" action="{{ route('admin.conference.toggle', $form) }}" style="margin:0;">
        @csrf
        <button type="submit" class="btn btn-sm {{ $form->is_conference_form ? 'btn-outline' : 'btn-primary' }}">
          {{ $form->is_conference_form ? 'Disable Conference Mode' : 'Enable Conference Mode' }}
        </button>
      </form>
      @if($form->is_conference_form)
      <a href="{{ route('admin.conference.participants', $form) }}" class="btn btn-sm btn-outline">👥 Manage Participants</a>
      <a href="{{ route('admin.conference.settings', $form) }}" class="btn btn-sm btn-outline">⚙ Conference Settings</a>
      @endif
    </div>
  </div>
</div>

<div style="background:var(--gray-100);border-radius:8px;padding:16px;font-size:13px;color:var(--gray-600);">
  <strong>Form Shortcode:</strong> Use <code style="background:var(--white);padding:2px 8px;border-radius:4px;font-size:12px;">[form:{{ $form->slug }}]</code> to embed this form in page content, or reference it via <code>/forms/{{ $form->slug }}/submit</code>
</div>

<script>
function buildDupFields() {
  var fields = [];
  if (document.querySelector('[name="dup_field_email"]')?.checked) fields.push('email');
  if (document.querySelector('[name="dup_field_phone"]')?.checked) fields.push('phone');
  // inject into the hidden input in the dup form
  var inputs = document.querySelectorAll('[name="duplicate_check_fields"]');
  inputs.forEach(function(i){ i.value = fields.join(','); });
}
</script>

<script>
(function () {
  // New field — show/hide options
  var newSel = document.getElementById('new-field-type-select');
  var newOg  = document.getElementById('new-options-group');
  function toggleNewOpts() {
    newOg.style.display = ['select','radio','checkbox'].includes(newSel.value) ? 'block' : 'none';
  }
  newSel.addEventListener('change', toggleNewOpts);
  toggleNewOpts();

  // Edit field type selects — show/hide options
  document.querySelectorAll('.field-type-sel').forEach(function(sel) {
    sel.addEventListener('change', function() {
      var tgt = document.getElementById(this.dataset.target);
      if (tgt) tgt.style.display = ['select','radio','checkbox'].includes(this.value) ? '' : 'none';
    });
  });

  // Auto-fill snake_case field name from label (new field only)
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

function openFieldEdit(id) {
  // Close any other open edit panels first
  document.querySelectorAll('[id^="field-edit-"]').forEach(function(r) { r.style.display = 'none'; });
  document.querySelectorAll('[id^="field-row-"]').forEach(function(r) { r.style.opacity = '1'; });
  var editRow = document.getElementById('field-edit-' + id);
  var viewRow = document.getElementById('field-row-' + id);
  if (editRow) editRow.style.display = '';
  if (viewRow) viewRow.style.opacity = '0.4';
  // Scroll into view
  if (editRow) editRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  // Init price rows after panel opens
  var ta = editRow ? editRow.querySelector('.options-textarea') : null;
  if (ta) buildPriceRows(id, ta.value);
}

function closeFieldEdit(id) {
  var editRow = document.getElementById('field-edit-' + id);
  var viewRow = document.getElementById('field-row-' + id);
  if (editRow) editRow.style.display = 'none';
  if (viewRow) viewRow.style.opacity = '1';
}

// ── Per-option price builder ────────────────────────────────────────────────
function buildPriceRows(fieldId, optionsText) {
  var container = document.getElementById('price-rows-' + fieldId);
  var jsonInput  = document.getElementById('option-prices-json-' + fieldId);
  if (!container || !jsonInput) return;

  var existing = {};
  try { existing = JSON.parse(jsonInput.value || '{}'); } catch(e) {}

  // Handle both JSON array format and one-per-line format
  var opts = [];
  var trimmed = optionsText.trim();
  if (trimmed.startsWith('[')) {
    try {
      var parsed = JSON.parse(trimmed);
      if (Array.isArray(parsed)) opts = parsed.map(function(s){ return String(s).trim(); }).filter(Boolean);
    } catch(e) {}
  }
  if (!opts.length) {
    opts = optionsText.split('\n').map(function(s){ return s.trim(); }).filter(Boolean);
  }

  container.innerHTML = '';
  opts.forEach(function(opt) {
    var row = document.createElement('div');
    row.style.cssText = 'display:flex;align-items:center;gap:8px;';
    var lbl = document.createElement('span');
    lbl.style.cssText = 'flex:1;font-size:12px;color:#374151;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;';
    lbl.textContent = opt;
    var inp = document.createElement('input');
    inp.type = 'number';
    inp.min  = '0';
    inp.step = '1';
    inp.placeholder = '0';
    inp.value = existing[opt] || '';
    inp.style.cssText = 'width:110px;padding:5px 8px;border:1px solid #d1d5db;border-radius:3px;font-size:12px;';
    inp.dataset.opt = opt;
    inp.addEventListener('input', function() { serializePrices(fieldId); });
    row.appendChild(lbl);
    var prefix = document.createElement('span');
    prefix.textContent = '₦';
    prefix.style.cssText = 'font-size:12px;color:#6b7280;';
    row.appendChild(prefix);
    row.appendChild(inp);
    container.appendChild(row);
  });

  serializePrices(fieldId);
}

function serializePrices(fieldId) {
  var container = document.getElementById('price-rows-' + fieldId);
  var jsonInput  = document.getElementById('option-prices-json-' + fieldId);
  if (!container || !jsonInput) return;
  var out = {};
  container.querySelectorAll('input[data-opt]').forEach(function(inp) {
    var v = parseFloat(inp.value);
    if (v > 0) out[inp.dataset.opt] = v;
  });
  jsonInput.value = JSON.stringify(out);
}

// Init price rows for all open edit panels on page load
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.options-textarea').forEach(function(ta) {
    var id = ta.id.replace('options-ta-', '');
    if (document.getElementById('price-rows-' + id)) {
      buildPriceRows(id, ta.value);
    }
  });
});
</script>
</x-admin-layout>
