<x-admin-layout title="Form Submissions">
<div class="section-header">
  <span class="section-title">Submissions: {{ $form->name }} <span style="font-weight:400;font-size:13px;color:var(--gray-500);">({{ $submissions->total() }})</span></span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.forms.submissions.export', $form) }}" class="btn btn-outline btn-sm">⬇ Export CSV</a>
    <a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-outline btn-sm">← Back to Form</a>
  </div>
</div>

@if($submissions->isEmpty())
<div class="card" style="text-align:center;padding:60px;color:var(--gray-400);">No submissions yet.</div>
@else
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
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
        <tr style="{{ !$sub->is_read ? 'background:rgba(11,79,108,0.04);' : '' }}">
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
            <form method="POST" action="{{ route('admin.form-submissions.destroy', [$form, $sub]) }}" style="display:inline;" onsubmit="return confirm('Delete this submission?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $submissions->links() }}</div>
</div>
@endif
</x-admin-layout>
