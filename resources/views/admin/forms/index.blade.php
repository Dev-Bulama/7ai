<x-admin-layout title="Form Builder">
<div class="section-header">
  <span class="section-title">Forms</span>
  <a href="{{ route('admin.forms.create') }}" class="btn btn-primary btn-sm">+ Create Form</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Slug</th><th>Submissions</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($forms as $form)
        <tr>
          <td><strong>{{ $form->name }}</strong>@if($form->description)<div style="font-size:12px;color:var(--gray-400);">{{ Str::limit($form->description,60) }}</div>@endif</td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $form->slug }}</td>
          <td><a href="{{ route('admin.forms.submissions', $form) }}" style="color:var(--teal);font-weight:600;">{{ $form->submissions_count }}</a></td>
          <td><span class="badge {{ $form->is_active ? 'badge-green' : 'badge-gray' }}">{{ $form->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.forms.edit', $form) }}" class="btn btn-outline btn-sm">Edit / Fields</a>
            <a href="{{ route('admin.forms.submissions', $form) }}" class="btn btn-outline btn-sm">Submissions</a>
            <form method="POST" action="{{ route('admin.forms.destroy', $form) }}" style="display:inline;" onsubmit="return confirm('Delete this form and all its submissions?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray-400);">No forms yet. <a href="{{ route('admin.forms.create') }}">Create your first form</a>.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $forms->links() }}</div>
</div>
</x-admin-layout>
