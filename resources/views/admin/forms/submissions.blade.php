<x-admin-layout title="Form Submissions">
<div class="section-header">
  <span class="section-title">Submissions: {{ $form->name }} <span style="font-weight:400;font-size:13px;color:var(--gray-500);">({{ $submissions->total() }})</span></span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.forms.submissions.export', $form) }}" class="btn btn-outline btn-sm">⬇ Export CSV</a>
    <a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-outline btn-sm">← Back to Form</a>
  </div>
</div>

@if(session('success'))
<div style="margin-bottom:16px;padding:12px 16px;background:#d1fae5;border:1px solid #6ee7b7;border-radius:8px;color:#065f46;font-size:13px;">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="margin-bottom:16px;padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;color:#991b1b;font-size:13px;">✗ {{ session('error') }}</div>
@endif

@if($submissions->isEmpty())
<div class="card" style="text-align:center;padding:60px;color:var(--gray-400);">No submissions yet.</div>
@else

{{-- Bulk action form wraps the whole table --}}
<form method="POST" action="{{ route('admin.form-submissions.bulk-action', $form) }}" id="bulk-form">
@csrf

{{-- Bulk action bar --}}
<div class="card" style="margin-bottom:12px;padding:12px 16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
  <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;cursor:pointer;">
    <input type="checkbox" id="select-all" style="width:16px;height:16px;">
    <span id="selected-count" style="color:var(--gray-500);">Select all</span>
  </label>

  <div style="display:flex;align-items:center;gap:8px;margin-left:auto;">
    <select name="action" id="bulk-action-select" class="form-input" style="width:auto;padding:6px 12px;font-size:13px;" required>
      <option value="">— Bulk action —</option>
      @if($form->welcome_email_enabled)
      <option value="resend_email">✉ Send Welcome Email</option>
      @endif
      <option value="mark_read">✓ Mark as Read</option>
      <option value="delete">🗑 Delete Selected</option>
    </select>
    <button type="button" id="bulk-apply-btn" class="btn btn-primary btn-sm" onclick="applyBulkAction()">Apply</button>
  </div>

  @if(!$form->welcome_email_enabled)
  <div style="width:100%;font-size:12px;color:var(--gray-400);">
    ℹ Welcome email not enabled — <a href="{{ route('admin.forms.edit', $form) }}#welcome-email" style="color:var(--teal);">enable it in form settings</a> to unlock bulk send.
  </div>
  @endif
</div>

<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:36px;"></th>
          <th>#</th>
          <th>Date</th>
          @foreach($form->fields as $field)
          <th>{{ $field->label }}</th>
          @endforeach
          <th>IP</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($submissions as $sub)
        <tr class="sub-row" style="{{ !$sub->is_read ? 'background:rgba(11,79,108,0.04);' : '' }}">
          <td style="text-align:center;">
            <input type="checkbox" name="submission_ids[]" value="{{ $sub->id }}" class="row-check" style="width:15px;height:15px;cursor:pointer;">
          </td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $sub->id }}</td>
          <td style="white-space:nowrap;font-size:12px;">{{ $sub->created_at->format('M d, Y H:i') }}</td>
          @foreach($form->fields as $field)
          <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:13px;">
            {{ is_array($sub->data[$field->name] ?? null) ? implode(', ', $sub->data[$field->name]) : ($sub->data[$field->name] ?? '—') }}
          </td>
          @endforeach
          <td style="font-size:11px;color:var(--gray-400);">{{ $sub->ip_address }}</td>
          <td>
            @if($sub->is_read)
            <span style="font-size:12px;color:var(--gray-400);">Read</span>
            @else
            <span style="font-size:12px;font-weight:600;color:#0b9e6e;">New</span>
            @endif
          </td>
          <td style="white-space:nowrap;">
            @if(!$sub->is_read)
            <form method="POST" action="{{ route('admin.form-submissions.read', $sub) }}" style="display:inline;">
              @csrf<button class="btn btn-outline btn-sm">Mark Read</button>
            </form>
            @endif
            @if($form->welcome_email_enabled)
            <form method="POST" action="{{ route('admin.form-submissions.resend-email', [$form, $sub]) }}" style="display:inline;" onsubmit="return confirm('Resend welcome email to this person?')">
              @csrf<button class="btn btn-outline btn-sm" style="color:#0b9e6e;border-color:#0b9e6e;">✉ Resend</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin.form-submissions.destroy', [$form, $sub]) }}" style="display:inline;" onsubmit="return confirm('Delete this submission?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div style="padding:16px;display:flex;align-items:center;justify-content:space-between;">
    <span id="page-selected-info" style="font-size:12px;color:var(--gray-400);"></span>
    {{ $submissions->links() }}
  </div>
</div>
</form>

@endif

<script>
(function () {
  var selectAll  = document.getElementById('select-all');
  var countLabel = document.getElementById('selected-count');
  var infoLabel  = document.getElementById('page-selected-info');
  var checks     = document.querySelectorAll('.row-check');

  function updateCount() {
    var n = document.querySelectorAll('.row-check:checked').length;
    countLabel.textContent = n > 0 ? n + ' selected' : 'Select all';
    countLabel.style.color = n > 0 ? 'var(--teal)' : 'var(--gray-500)';
    if (infoLabel) infoLabel.textContent = n > 0 ? n + ' row(s) selected on this page' : '';
    selectAll.indeterminate = n > 0 && n < checks.length;
    selectAll.checked = n === checks.length && checks.length > 0;
  }

  selectAll.addEventListener('change', function () {
    checks.forEach(function (c) { c.checked = selectAll.checked; });
    updateCount();
  });

  checks.forEach(function (c) {
    c.addEventListener('change', updateCount);
  });

  // Highlight selected rows
  checks.forEach(function (c) {
    c.addEventListener('change', function () {
      c.closest('tr').style.background = c.checked ? 'rgba(11,79,108,0.08)' : '';
    });
  });

  window.applyBulkAction = function () {
    var selected = document.querySelectorAll('.row-check:checked');
    var action   = document.getElementById('bulk-action-select').value;

    if (selected.length === 0) {
      alert('Please select at least one submission first.');
      return;
    }
    if (!action) {
      alert('Please choose an action from the dropdown.');
      return;
    }

    var confirmMsg = {
      'resend_email': 'Send welcome email to ' + selected.length + ' selected person(s)?',
      'mark_read':    'Mark ' + selected.length + ' submission(s) as read?',
      'delete':       'Permanently delete ' + selected.length + ' submission(s)? This cannot be undone.',
    };

    if (!confirm(confirmMsg[action] || 'Apply this action to ' + selected.length + ' item(s)?')) return;
    document.getElementById('bulk-form').submit();
  };
})();
</script>
</x-admin-layout>
