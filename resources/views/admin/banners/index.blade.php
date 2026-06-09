<x-admin-layout title="Banners">
<div class="section-header">
  <span class="section-title">Banners</span>
  <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">+ Add Banner</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Position</th><th>Dates</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($banners as $banner)
        <tr>
          <td><strong>{{ $banner->name }}</strong>@if($banner->title)<div style="font-size:12px;color:var(--gray-500);">{{ $banner->title }}</div>@endif</td>
          <td><span class="badge badge-teal">{{ $banner->position }}</span></td>
          <td style="font-size:12px;">{{ $banner->start_date?->format('M d') ?? '—' }} → {{ $banner->end_date?->format('M d') ?? '∞' }}</td>
          <td><span class="badge {{ $banner->is_active ? 'badge-green' : 'badge-gray' }}">{{ $banner->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray-400);">No banners yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $banners->links() }}</div>
</div>
</x-admin-layout>
