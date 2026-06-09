<x-admin-layout title="Services">
<div class="section-header">
  <span class="section-title">Services</span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline btn-sm">Manage Categories</a>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">+ Add Service</a>
  </div>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr>
        <th>Title</th><th>Category</th><th>Status</th><th>Sort</th><th>Actions</th>
      </tr></thead>
      <tbody>
        @forelse($services as $service)
        <tr>
          <td>
            <div style="font-weight:600;color:var(--dark);">{{ $service->title }}</div>
            <div style="font-size:12px;color:var(--gray-400);">{{ $service->slug }}</div>
          </td>
          <td>{{ $service->category?->name ?? '—' }}</td>
          <td><span class="badge {{ $service->status === 'published' ? 'badge-green' : 'badge-gray' }}">{{ $service->status }}</span></td>
          <td>{{ $service->sort_order }}</td>
          <td>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline;" onsubmit="return confirm('Delete this service?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:var(--gray-400);padding:32px;">No services yet. <a href="{{ route('admin.services.create') }}">Add one</a>.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $services->links() }}</div>
</div>
</x-admin-layout>
