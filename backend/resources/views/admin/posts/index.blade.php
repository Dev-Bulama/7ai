<x-admin-layout title="Blog Posts">
<div class="section-header">
  <div class="section-title">All Posts</div>
  <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th>Views</th><th>Published</th><th></th></tr></thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td><a href="{{ route('admin.posts.edit',$post) }}" style="font-weight:500;color:var(--teal);text-decoration:none;">{{ $post->title }}</a></td>
          <td>{{ $post->author?->name ?? '—' }}</td>
          <td>{{ $post->category?->name ?? '—' }}</td>
          <td><span class="badge {{ $post->status==='published'?'badge-green':($post->status==='draft'?'badge-gray':'badge-yellow') }}">{{ ucfirst($post->status) }}</span></td>
          <td>{{ number_format($post->views) }}</td>
          <td style="font-size:12px;color:var(--gray-400);">{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.posts.edit',$post) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.posts.destroy',$post) }}" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button></form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--gray-400);padding:32px;">No posts yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $posts->links('pagination::simple-default') }}</div>
</div>
</x-admin-layout>
