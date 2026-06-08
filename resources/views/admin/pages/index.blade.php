<x-admin-layout title="Pages">
  <x-slot name="actions">
    <a href="{{ route('admin.pages.create') }}" style="padding:8px 16px;background:#0B4F6C;color:#fff;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;">+ New Page</a>
  </x-slot>
<style>
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;}
  table{width:100%;border-collapse:collapse;}
  th{font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;padding:12px 24px;text-align:left;background:#f9fafb;}
  td{padding:14px 24px;font-size:14px;color:#374151;border-top:1px solid #f3f4f6;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .action-link{color:#0B4F6C;text-decoration:none;font-size:13px;font-weight:500;}
  .action-link:hover{text-decoration:underline;}
  .action-del{color:#dc2626;font-size:13px;font-weight:500;background:none;border:none;cursor:pointer;font-family:inherit;}
  .empty{padding:60px;text-align:center;color:#9ca3af;}
</style>
<div class="card">
  @if($pages->count())
  <table>
    <thead><tr><th>Title</th><th>Slug</th><th>Template</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($pages as $page)
    <tr>
      <td style="font-weight:500;">{{ $page->title }}</td>
      <td style="font-family:monospace;font-size:12px;color:#9ca3af;">/{{ $page->slug }}</td>
      <td>{{ $page->template }}</td>
      <td>
        @php $sc=['published'=>'badge-green','draft'=>'badge-gray','scheduled'=>'badge-yellow'][$page->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst($page->status) }}</span>
      </td>
      <td style="color:#9ca3af;font-size:13px;">{{ $page->updated_at->diffForHumans() }}</td>
      <td style="display:flex;gap:16px;">
        <a href="{{ route('admin.pages.edit', $page) }}" class="action-link">Edit</a>
        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?')">
          @csrf @method('DELETE')
          <button type="submit" class="action-del">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @else
    <div class="empty">No pages yet.</div>
  @endif
</div>
</x-admin-layout>
