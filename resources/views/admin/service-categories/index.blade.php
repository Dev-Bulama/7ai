<x-admin-layout title="Service Categories">
<div class="section-header">
  <span class="section-title">Service Categories</span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline btn-sm">← Services</a>
    <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary btn-sm">+ Add Category</a>
  </div>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Slug</th><th>Parent</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($categories as $cat)
        <tr>
          <td><strong>{{ $cat->name }}</strong></td>
          <td style="color:var(--gray-400);font-size:12px;">{{ $cat->slug }}</td>
          <td>{{ $cat->parent?->name ?? '—' }}</td>
          <td>{{ $cat->sort_order }}</td>
          <td><span class="badge {{ $cat->is_active ? 'badge-green' : 'badge-gray' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.service-categories.edit', $cat) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.service-categories.destroy', $cat) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--gray-400);">No categories yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
</x-admin-layout>
