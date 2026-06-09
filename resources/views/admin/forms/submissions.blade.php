<x-admin-layout title="Form Submissions">
<div class="section-header">
  <span class="section-title">Submissions: {{ $form->name }}</span>
  <a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-outline btn-sm">← Back to Form</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          @foreach($form->fields as $field)
          <th>{{ $field->label }}</th>
          @endforeach
          <th>IP</th>
          <th>Read</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($submissions as $sub)
        <tr style="{{ !$sub->is_read ? 'background:rgba(11,79,108,0.04);' : '' }}">
          <td style="white-space:nowrap;font-size:12px;">{{ $sub->created_at->format('M d, Y H:i') }}</td>
          @foreach($form->fields as $field)
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $sub->data[$field->name] ?? '—' }}</td>
          @endforeach
          <td style="font-size:12px;color:var(--gray-400);">{{ $sub->ip_address }}</td>
          <td>@if($sub->is_read)✓@else<span style="color:#0b9e6e;font-weight:600;">New</span>@endif</td>
          <td>
            @if(!$sub->is_read)
            <form method="POST" action="{{ route('admin.form-submissions.read', $sub) }}" style="display:inline;">
              @csrf<button class="btn btn-outline btn-sm">Mark Read</button>
            </form>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="20" style="text-align:center;padding:32px;color:var(--gray-400);">No submissions yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $submissions->links() }}</div>
</div>
</x-admin-layout>
