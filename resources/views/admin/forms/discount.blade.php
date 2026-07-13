<x-admin-layout :title="'Discount Settings — '.$form->name">
<div class="section-header">
  <span class="section-title">Discount Settings: {{ $form->name }}</span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.forms.submissions', $form) }}" class="btn btn-outline btn-sm">← Submissions</a>
    <a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-outline btn-sm">← Back to Form</a>
  </div>
</div>

@if(session('success'))
<div style="margin-bottom:16px;padding:12px 16px;background:#d1fae5;border:1px solid #6ee7b7;border-radius:8px;color:#065f46;font-size:13px;">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="margin-bottom:16px;padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;color:#991b1b;font-size:13px;">✗ {{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.forms.discount.update', $form) }}">
@csrf
@method('PUT')

{{-- ── Enable / Percent ───────────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:20px;">
  <div class="card-title">Discount Configuration</div>

  <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;font-weight:600;">
      <input type="checkbox" name="discount_enabled" value="1" {{ $form->discount_enabled ? 'checked' : '' }}
        style="width:18px;height:18px;">
      Enable discount for this form
    </label>
    @if($form->discount_enabled)
    <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600;">ACTIVE</span>
    @else
    <span style="background:#f3f4f6;color:#6b7280;padding:3px 10px;border-radius:12px;font-size:12px;">INACTIVE</span>
    @endif
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
    <div>
      <label class="form-label">Discount Percentage (%)</label>
      <input type="number" name="discount_percent" value="{{ old('discount_percent', $form->discount_percent ?? 50) }}"
        min="1" max="100" step="0.01" class="form-input" required>
      <p style="font-size:12px;color:var(--gray-400);margin-top:4px;">Applied to eligible registrants (e.g. 50 = 50% off)</p>
    </div>
    <div>
      <label class="form-label">Check Against Form (conference registrations)</label>
      <select name="discount_check_form_id" class="form-input">
        <option value="">— Select a form to check —</option>
        @foreach($allForms as $f)
        <option value="{{ $f->id }}" {{ (old('discount_check_form_id', $form->discount_check_form_id) == $f->id) ? 'selected' : '' }}>
          {{ $f->name }} {{ $f->is_conference_form ? '(conference)' : '' }}
        </option>
        @endforeach
      </select>
      <p style="font-size:12px;color:var(--gray-400);margin-top:4px;">Registrants whose email matches a submission in this form will receive the discount.</p>
    </div>
  </div>
</div>

{{-- ── Discount Email ─────────────────────────────────────────────────── --}}
<div class="card" style="margin-bottom:20px;">
  <div class="card-title">Discount Notification Email</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">
    This email is automatically sent to registrants who qualify for a discount. Leave body blank to use the default template.
    Available variables: <code>@{{name}}</code>, <code>@{{email}}</code>, <code>@{{form_name}}</code>,
    <code>@{{discount_percent}}</code>, <code>@{{site_name}}</code>, <code>@{{support_email}}</code>, <code>@{{current_year}}</code>.
    You can also use any submitted field name e.g. <code>@{{course}}</code>.
  </p>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
    <div>
      <label class="form-label">From Name</label>
      <input type="text" name="discount_email_from_name" value="{{ old('discount_email_from_name', $form->discount_email_from_name) }}"
        class="form-input" placeholder="e.g. 7AI Team">
    </div>
    <div>
      <label class="form-label">From Email Address</label>
      <input type="email" name="discount_email_from_address" value="{{ old('discount_email_from_address', $form->discount_email_from_address) }}"
        class="form-input" placeholder="e.g. hello@7ai.africa">
    </div>
  </div>

  <div style="margin-bottom:16px;">
    <label class="form-label">Email Subject</label>
    <input type="text" name="discount_email_subject" value="{{ old('discount_email_subject', $form->discount_email_subject) }}"
      class="form-input" placeholder="🎉 You qualify for a {{discount_percent}}% discount — {{form_name}}">
  </div>

  <div>
    <label class="form-label">Email Body (HTML)</label>
    <textarea name="discount_email_body" class="form-input" rows="14"
      placeholder="Leave blank to use the default discount email template."
      style="font-family:monospace;font-size:12px;">{{ old('discount_email_body', $form->discount_email_body) }}</textarea>
  </div>
</div>

<div style="display:flex;gap:12px;">
  <button type="submit" class="btn btn-primary">Save Discount Settings</button>
  <a href="{{ route('admin.forms.submissions', $form) }}" class="btn btn-outline">Cancel</a>
</div>
</form>
</x-admin-layout>
