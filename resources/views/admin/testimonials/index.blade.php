<x-admin-layout title="Testimonials">
<div class="section-header">
  <span class="section-title">Testimonials</span>
  <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">+ Add Testimonial</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Author</th><th>Company</th><th>Rating</th><th>Featured</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($testimonials as $t)
        <tr>
          <td>
            <div style="font-weight:600;">{{ $t->author_name }}</div>
            <div style="font-size:12px;color:var(--gray-400);">{{ $t->author_role }}</div>
          </td>
          <td>{{ $t->author_company ?? '—' }}</td>
          <td>{{ str_repeat('★', $t->rating) }}</td>
          <td>{{ $t->is_featured ? '✓' : '—' }}</td>
          <td><span class="badge {{ $t->is_active ? 'badge-green' : 'badge-gray' }}">{{ $t->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--gray-400);">No testimonials yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $testimonials->links() }}</div>
</div>
</x-admin-layout>
