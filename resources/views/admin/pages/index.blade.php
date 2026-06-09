<x-admin-layout title="Pages">
<div class="section-header">
  <span class="section-title">Pages</span>
  <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">+ New Page</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr>
        <th>Title</th><th>Slug</th><th>Template</th><th>Status</th><th>Updated</th><th>Actions</th>
      </tr></thead>
      <tbody>
        @forelse($pages as $page)
        <tr>
          <td>
            <div style="font-weight:600;color:var(--dark);">{{ $page->title }}</div>
            @if($page->parent)<div style="font-size:11px;color:var(--gray-400);">↳ under {{ $page->parent->title }}</div>@endif
          </td>
          <td style="font-family:monospace;font-size:12px;color:var(--gray-400);">/{{ $page->slug }}</td>
          <td><span class="badge badge-gray">{{ $page->template }}</span></td>
          <td>
            @php $c = ['published'=>'badge-green','draft'=>'badge-gray','scheduled'=>'badge-yellow'][$page->status] ?? 'badge-gray' @endphp
            <span class="badge {{ $c }}">{{ ucfirst($page->status) }}</span>
          </td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $page->updated_at->diffForHumans() }}</td>
          <td>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.pages.toggle-status', $page) }}" style="display:inline;">
              @csrf
              <button class="btn btn-sm {{ $page->status === 'published' ? 'btn-outline' : 'btn-success' }}">
                {{ $page->status === 'published' ? 'Unpublish' : 'Publish' }}
              </button>
            </form>
            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline;" onsubmit="return confirm('Delete this page?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--gray-400);">No pages yet. <a href="{{ route('admin.pages.create') }}" style="color:var(--teal);">Create your first page</a>.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $pages->links() }}</div>
</div>
</x-admin-layout>
